<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Category;
use App\AdminBundle\Entity\News\News;
use App\AdminBundle\Entity\Product\Product;
use App\AdminBundle\Entity\Product\ProductCharacteristic;
use App\AdminBundle\Entity\Product\ProductCharacteristicSection;
use App\AdminBundle\Entity\Product\ProductColor;
use App\AdminBundle\Entity\Product\ProductPhoto;
use App\AdminBundle\Entity\Product\ProductSeo;
use App\AdminBundle\Entity\Product\ProductStatus;
use App\AdminBundle\Entity\SubCategory;
use App\AdminBundle\Form\Product\ProductType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\AdminBundle\Controller
 * @Route("/product")
 */
class ProductController extends BaseController
{
    /**
     * @Route(
     *     "",
     *     name="get-products-action",
     *     methods={"GET"}
     * )
     */
    public function productsAction(): JsonResponse
    {
        $products = $this
            ->getSerializer()
            ->normalize(
                $this
                    ->getDoctrine()
                    ->getRepository(Product::class)
                    ->findBy(array(), ['createdAt' => 'DESC'], 50, null)
            );

        return new JsonResponse($products);
    }

    /**
     * @param int $productId
     * @return JsonResponse
     * @Route(
     *     "/{productId}",
     *     name="get-product-by-id-action",
     *     requirements={"productId"="\d+"},
     *     methods={"GET"}
     * )
     */
    public function productByIdAction(int $productId): JsonResponse
    {
        $product = $this
            ->getSerializer()
            ->normalize(
                $this
                ->getDoctrine()
                ->getRepository(Product::class)
                ->find($productId)
            );

        return new JsonResponse($product);
    }

    /**
     * @param int $productId
     * @return JsonResponse
     * @Route(
     *     "/overviews/{productId}",
     *     name="get-product-overviews-action",
     *     requirements={"productId"="\d+"},
     *     methods={"GET"}
     * )
     */
    public function productOverviewsAction(int $productId): JsonResponse
    {
        $overviews = $this
            ->getSerializer()
            ->normalize(
                $this
                ->getDoctrine()
                ->getRepository(News::class)
                ->findBy(
                    [
                        'isOverview' => true,
                        'product' => $this  ->getDoctrine()
                                            ->getRepository(Product::class)
                                            ->find($productId)
                    ]
                )
            );

        return new JsonResponse($overviews);
    }

    /**
     * @param Request $request
     * @Route(
     *     "/new",
     *      methods={"POST"},
     *     name="new-product-action"
     * )
     * @return JsonResponse
     */
    public function newProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Product $product */
            $product = $form->getData();
            /** @var UploadedFile $file */
            $file = $request->files->get('previewPhoto');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('product_images_directory'),
                $fileName
            );
            if ($request->get('discountStatus')) {
                $product
                    ->setDiscountStatus($request->get('discountStatus'))
                    ->setDiscountPercentValue($request->get('discountPercentValue'));
            }

            $em = $this->getDoctrine()->getManager();

            $product
                ->setCategory($this->getDoctrine()
                    ->getRepository(SubCategory::class)
                    ->find($request->get('subCategory_id'))
                )
                ->setPreviewPhoto($fileName)
                ->setAvailable((bool)$request->get('available'))
                ->setCreatedAt(new \DateTime());
            if ($request->get('productStatus_id')) {
                $product->setProductStatus(
                    $this->getDoctrine()
                        ->getRepository(ProductStatus::class)
                        ->find($request->get('productStatus_id'))
                );
            }
            if ($request->get('isSeo') && !$request->get('seo_id')) {
                $seoInformation = new ProductSeo();
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setImagesAlt($request->get('seoImagesAlt'))
                    ->setProduct($product);
                $em->persist($seoInformation);
            }
            if ($request->get('seo_id')) {
                /** @var ProductSeo $seoInformation */
                $seoInformation = $this->getDoctrine()->getRepository(ProductSeo::class)->find($request->get('seo_id'));
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setImagesAlt($request->get('seoImagesAlt'))
                    ->setProduct($product);
                $em->persist($seoInformation);
            }

            $em->persist($product);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($product));
        }

        return new JsonResponse(
            ['error' => 'Some problem has been happened'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param Request $request
     * @param int $productId
     * @return JsonResponse
     * @Route(
     *     "/edit/{productId}",
     *     requirements={"productId"="\d+"},
     *     name="edit-product-action",
     *     methods={"POST"}
     * )
     */
    public function editProductAction(Request $request, int $productId): JsonResponse
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Product $product */
            $product = $form->getData();

            if ($request->files->get('previewPhoto')) {
                /** @var UploadedFile $file */
                $file = $request->files->get('previewPhoto');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('product_images_directory'),
                    $fileName
                );
                $product->setPreviewPhoto($fileName);
            }

            $product
                ->setDiscountStatus($request->get('discountStatus') ? : false)
                ->setDiscountPercentValue($request->get('discountPercentValue') ? : 0);
            $product
                ->setCategory($this->getDoctrine()
                    ->getRepository(SubCategory::class)
                    ->find($request->get('subCategory_id'))
                )
                ->setAvailable((bool)$request->get('available'))
                ->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();

            if ($request->get('productStatus_id')) {
                $product->setProductStatus(
                    $this->getDoctrine()
                        ->getRepository(ProductStatus::class)
                        ->find($request->get('productStatus_id'))
                );
            }

            if ($request->get('isSeo') && !$request->get('seo_id')) {
                $seoInformation = new ProductSeo();
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setImagesAlt($request->get('seoImagesAlt'))
                    ->setProduct($product);
                $em->persist($seoInformation);
            }
            if ($request->get('seo_id')) {
                /** @var ProductSeo $seoInformation */
                $seoInformation = $this->getDoctrine()->getRepository(ProductSeo::class)->find($request->get('seo_id'));
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setImagesAlt($request->get('seoImagesAlt'))
                    ->setProduct($product);
                $em->persist($seoInformation);
            }

            $em->persist($product);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($product));
        }

        return new JsonResponse(
            ['error' => 'Some problem has been happened'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param Request $request
     * @param int $productId
     * @Route(
     *     "/add/characteristics/{productId}",
     *     methods={"POST"},
     *     requirements={"productId"="\d+"},
     *     name="new-product-characteristics-action"
     * )
     * @return JsonResponse
     */
    public function newProductCharacteristics(Request $request, int $productId)
    {
        $characteristics = $request->get('characteristics');

        try {
            $this->saveProductCharacteristic($characteristics, $productId);
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'message' => 'Something error with exception.',
                    'error' => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(['message' => 'Product characteristics has been successfully saved']);
    }

    /**
     * @param Request $request
     * @param int $productId
     * @return JsonResponse
     * @Rest\Route(
     *     "/add/photos/{productId}",
     *     methods={"POST"},
     *     requirements={"productId"="\d+"},
     *     name="new-product-photos-action"
     * )
     */
    public function newProductPhotosAction(Request $request, int $productId): JsonResponse
    {
        if (!$request->files->get('images')) {
            return new JsonResponse(['message' => 'There are no some images']);
        }

        foreach ($request->files->get('images') as $image) {
            $productPhoto = new ProductPhoto();
            /** @var UploadedFile $image */
            $fileName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('product_images_directory'),
                $fileName
            );

            $productPhoto
                ->setImage($fileName)
                ->setProduct($this->getProduct($productId));

            $em = $this->getDoctrine()->getManager();
            $em->persist($productPhoto);
        }

        $em->flush();

        return new JsonResponse(['message' => 'Product photos have been successfully saved']);
    }

    /**
     * @param array $characteristics
     * @param int $productId
     */
    private function saveProductCharacteristic(array $characteristics, int $productId)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($characteristics as $characteristicSection) {
            $productCharacteristicSection = new ProductCharacteristicSection();
            $productCharacteristicSection
                ->setName($characteristicSection['property'])
                ->setProduct($this->getProduct($productId));

            $em->persist($productCharacteristicSection);

            foreach ($characteristicSection['values'] as $characteristic) {
                $productCharacteristic = new ProductCharacteristic();
                $productCharacteristic
                    ->setParentSection($productCharacteristicSection)
                    ->setName($characteristic['key'])
                    ->setValue($characteristic['value']);

                $em->persist($productCharacteristic);
            }
        }

        $em->flush();
    }

    /**
     * @Route(
     *     "/statuses",
     *     name="get-product-statuses-action",
     *     methods={"GET"}
     * )
     */
    public function productStatusesAction(): JsonResponse
    {
        $productStatuses = $this
            ->getSerializer()
            ->normalize(
                $this
                ->getDoctrine()
                ->getRepository(ProductStatus::class)
                ->findAll()
            );

        return new JsonResponse($productStatuses);
    }

    /**
     * @param int $productId
     * @return JsonResponse
     * @Route(
     *     "/photos/{productId}",
     *     name="get-product-photos-action",
     *     requirements={"productId"="\d+"},
     *     methods={"GET"}
     * )
     */
    public function productPhotosAction(int $productId): JsonResponse
    {
        $photos = $this
            ->getDoctrine()
            ->getRepository(ProductPhoto::class)
            ->findBy(
                [
                    'product' => $this
                                    ->getDoctrine()
                                    ->getRepository(Product::class)
                                    ->find($productId)
                ]
            );

        return new JsonResponse($this->getSerializer()->normalize($photos));
    }

    /**
     * @param Request $request
     * @param int $productId
     * @return JsonResponse
     * @Route(
     *     "/delete-photos/{productId}",
     *     name="delete-product-photos-action",
     *     requirements={"productId"="\d+"},
     *     methods={"POST"}
     * )
     */
    public function deleteProductPhotosAction(Request $request, int $productId): JsonResponse
    {
        $images = json_decode($request->get('deletedImages'));
        $fileSystem = new Filesystem();

        $em = $this->getDoctrine()->getManager();

        foreach ($images as $image) {
            $productImage = $this
                ->getDoctrine()
                ->getRepository(ProductPhoto::class)
                ->find($image);
            $fileSystem->remove($this->getParameter('product_images_directory') . '/' . $productImage->getImage());
            $em->remove($productImage);
        }

        $em->flush();

        return new JsonResponse(['message' => 'Photos have been successfully deleted']);
    }

//    /**
//     * @Route(
//     *     "/categories"
//     * )
//     */
//    public function getCategories()
//    {
//        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
//        dump($this->getSerializer()->normalize($categories));
//        exit();
//    }

    /**
     * @param int $productId
     * @return Product
     */
    private function getProduct(int $productId): Product
    {
        return $this->getDoctrine()->getRepository(Product::class)->find($productId);
    }

}
