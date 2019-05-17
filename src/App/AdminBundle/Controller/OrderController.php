<?php

namespace App\AdminBundle\Controller;

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
use App\AdminBundle\Service\MailerService;
use App\AdminBundle\Service\PromoCodeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package App\AdminBundle\Controller
 * @Route("/order")
 */
class OrderController extends BaseController
{
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
     * @Route(
     *     "/remove/{orderId}"
     * )
     * @param int $orderId
     * @return JsonResponse
     */
    public function removeOrder(int $orderId)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($orderId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();

        return new JsonResponse(['message' => 'Deleted']);
    }

    /**
     * @Route(
     *     "",
     *     name="get-orders-action"
     * )
     */
    public function getOrdersAction(): JsonResponse
    {
        $orders = $this
            ->getSerializer()
            ->normalize(
                $this
                    ->getDoctrine()
                    ->getRepository(Order::class)
                    ->findBy(array(), ['createdAt' => 'DESC'], 20, null)
            );

        $orders = $this->serializeOrdersList($orders);

        return new JsonResponse($orders);
    }

    /**
     * @Route(
     *     "/{orderId}",
     *     name="get-order-by-id-action",
     *     requirements={"id"="\d+"}
     * )
     * @param int $orderId
     * @return JsonResponse
     */
    public function getOrderByIdAction(int $orderId): JsonResponse
    {
        $order = $this
            ->getSerializer()
            ->normalize(
                $this
                    ->getDoctrine()
                    ->getRepository(Order::class)
                    ->find($orderId)
            );

        $order = $this->serializeOrdersList([$order])[0];

        return new JsonResponse($order);
    }

    /**
     * @param $orders
     * @return mixed
     */
    private function serializeOrdersList($orders)
    {
        $i = 0;
        foreach ($orders as $order) {
            $orderedProducts = [];
            foreach ($order['products'] as $orderProduct) {
                $orderProduct['product']['category'] = [
                    'id' => $orderProduct['product']['category']['id'],
                    'name' => $orderProduct['product']['category']['name']
                ];
                unset($orderProduct['product']['characteristics']);
                unset($orderProduct['product']['photos']);
                $orderProduct['product']['count'] = $orderProduct['count'];
                $orderedProducts[] = $orderProduct['product'];
            }
            $order['products'] = $orderedProducts;
            $orders[$i] = $order;
            $i++;
        }

        return $orders;
    }


}