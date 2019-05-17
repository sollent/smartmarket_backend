<?php

namespace App\ClientBundle\Controller;

use App\AdminBundle\Entity\Order\Order;
use App\AdminBundle\Entity\Order\OrderClientInfo;
use App\AdminBundle\Entity\Order\OrderDeliveryWay;
use App\AdminBundle\Entity\Order\OrderedProducts;
use App\AdminBundle\Entity\Order\OrderLocation;
use App\AdminBundle\Entity\Order\OrderLocationType;
use App\AdminBundle\Entity\Order\OrderPromoCode;
use App\AdminBundle\Entity\Product\Product;
use App\AdminBundle\Form\Order\OrderClientInfoType;
use App\AdminBundle\Form\Order\OrderLocationForm;
use App\AdminBundle\Form\Order\OrderType;
use App\AdminBundle\Service\PromoCodeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class OrderController
 * @package App\ClientBundle\Controller
 */
class OrderController extends BaseController
{
    const PROMOCODE_ERROR_MESSAGE = 'Вы ввели неверный промокод';

    /**
     * @var PromoCodeService
     */
    private $promoCodeService;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(
        PromoCodeService $promoCodeService,
        \Swift_Mailer $mailer
    )
    {
        $this->promoCodeService = $promoCodeService;
        $this->mailer = $mailer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductsByIdsAction(Request $request)
    {
        $ids = json_decode($request->get('ids'));
        $products = array();

        foreach ($ids as $id) {
            $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
            array_push($products, $product);
        }

        $products = $this->getSerializer()->normalize($products, null, [ObjectNormalizer::ENABLE_MAX_DEPTH => true]);

        return new JsonResponse($products);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function newOrderAction(Request $request)
    {
        // Entities
        $order = new Order();
        $orderClientInfo = new OrderClientInfo();
        $orderLocation = new OrderLocation();

        // Forms
        $orderForm = $this->createForm(OrderType::class, $order);
        $clientInfoForm = $this->createForm(OrderClientInfoType::class, $orderClientInfo);
        $locationForm = $this->createForm(OrderLocationForm::class, $orderLocation);

        // Handle requests for forms
        $orderForm->handleRequest($request);
        $clientInfoForm->handleRequest($request);
        $locationForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if (
            $orderForm->isSubmitted() &&
            $clientInfoForm->isSubmitted() &&
            $locationForm->isSubmitted()
        ) {
            $order = $orderForm->getData();
            $orderClientInfo = $clientInfoForm->getData();
            /** @var OrderLocation $orderLocation */
            $orderLocation = $locationForm->getData();

            // Setting location type
            if ($request->get('type') === 'Mail') {
                $orderLocation
                    ->setLocationType(
                        $this
                            ->getDoctrine()
                            ->getRepository(OrderLocationType::class)
                            ->findOneBy(['name' => 'Minsk']));
            } else {
                $orderLocation
                    ->setLocationType(
                        $this
                            ->getDoctrine()
                            ->getRepository(OrderLocationType::class)
                            ->findOneBy(['name' => 'Mail']));
            }

            $em->persist($orderClientInfo);
            $em->persist($orderLocation);

            /** @var Order $order */
            $order
                ->setClientInfo($orderClientInfo)
                ->setLocation($orderLocation);

            // Setting delivery way
            if ($request->get('deliveryWay') === 'mail') {
                $order->setDeliveryWay(
                    $this->
                    getDoctrine()
                        ->getRepository(OrderDeliveryWay::class)
                        ->findOneBy(['name' => 'mail'])
                );
            } else if ($request->get('deliveryWay') === 'own') {
                $order->setDeliveryWay(
                    $this->
                    getDoctrine()
                        ->getRepository(OrderDeliveryWay::class)
                        ->findOneBy(['name' => 'own'])
                );
            } else {
                $order->setDeliveryWay(
                    $this->
                    getDoctrine()
                        ->getRepository(OrderDeliveryWay::class)
                        ->findOneBy(['name' => 'driver'])
                );
            }

            $order
                ->setOrderDate(
                    (string)$request->get('deliveryDate') === 'today' ?
                        new \DateTime() :
                        new \DateTime((string)$request->get('deliveryDate'))
                )
                ->setOrderTime(new \DateTime((string)$request->get('deliveryTime')))
                ->setCreatedAt(new \DateTime())
                ->setTotalCost(
                    $request->get('orderCost') +
                    $request->get('deliveryCost')
                );

            $promoCode = new OrderPromoCode();
            $promoCode
                ->setPromoHash(
                    $this
                        ->promoCodeService
                        ->generateOrderPromoCode()
                )
                ->setCreatedAt(new \DateTime());

            $em->persist($promoCode);

            $order->setPromoCode($promoCode);

            $em->persist($order);

            $productsList = $this
                ->getSerializer()
                ->decode($request->get('products'), 'json');

            foreach ($productsList as $product) {
                $orderedProducts = new OrderedProducts();
                $orderedProducts
                    ->setOrder($order)
                    ->setProduct(
                        $this
                            ->getDoctrine()
                            ->getRepository(Product::class)
                            ->find($product['productId'])
                    )
                    ->setCount($product['count'])
                ;
                $em->persist($orderedProducts);
            }

            $em->flush();

            $jsonResponse = ['message' => 'Order has been successfully saved', 'promoCode' => $promoCode->getPromoHash()];

            if ($request->get('email') !== null) {
                $jsonResponse['messageStatus'] = $this->sendMessage($request->get('email')) ? true : false;
            }

            $jsonResponse['orderId'] = $order->getId();

            return new JsonResponse($jsonResponse);
        }

        return new JsonResponse(['message' => 'errors']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function recalculateByPromoCodeAction(Request $request)
    {
        /** @var OrderPromoCode $promoCode */
        $promoCode = $this
            ->getDoctrine()
            ->getRepository(OrderPromoCode::class)
            ->findOneBy(['promoHash' => $request->get('promoCode')]);

        if ($promoCode) {
            return new JsonResponse(['percent' => 5, 'promocode_id' => $promoCode->getId()]);
        }

        return new JsonResponse(['error' => self::PROMOCODE_ERROR_MESSAGE], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param string $email
     * @return bool
     */
    private function sendMessage(string $email): bool
    {
        try {
            $message = (new \Swift_Message('Статус заказа'))
                ->setFrom('smartmarket.by.company@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        '@AppClient/components/email/success-order.html.twig',
                        [ 'email' => $email ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }
}