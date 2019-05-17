<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\News\News;
use App\AdminBundle\Entity\News\NewsCategory;
use App\AdminBundle\Entity\News\NewsSeo;
use App\AdminBundle\Entity\News\NewsSubCategory;
use App\AdminBundle\Entity\Product\Product;
use App\AdminBundle\Form\News\NewsCategoryType;
use App\AdminBundle\Form\News\NewsType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewsController
 * @package App\AdminBundle\Controller
 * @Route("/news")
 */
class NewsController extends BaseController
{
    /**
     * @Route(
     *     "",
     *     name="get-news-action"
     * )
     */
    public function newsAction(): JsonResponse
    {
        $news = $this
            ->getSerializer()
            ->normalize(
                $this
                ->getDoctrine()
                ->getRepository(News::class)
                ->findBy(array(), ['createdAt' => 'DESC'], 50, null)
            );

        return new JsonResponse($news);
    }

    /**
     * @param int $newsId
     * @return JsonResponse
     * @Route(
     *     "/{newsId}",
     *     requirements={"newsId"="\d+"},
     *     methods={"GET"}
     * )
     */
    public function newsByIdAction(int $newsId): JsonResponse
    {
        $article = $this
            ->getSerializer()
            ->normalize(
                $this
                ->getDoctrine()
                ->getRepository(News::class)
                ->find($newsId)
            );

        return new JsonResponse($article);
    }

    /**
     * @return JsonResponse
     * @Route(
     *     "/overviews",
     *     name="get-overviews-action",
     *     methods={"GET"}
     * )
     */
    public function overviewsAction(): JsonResponse
    {
        $overviews = $this
            ->getSerializer()
            ->normalize(
                $this
                ->getDoctrine()
                ->getRepository(News::class)
                ->findBy(['isOverview' => true])
            );

        return new JsonResponse($overviews);
    }

    /**
     * @param int $overviewId
     * @param int $productId
     * @return JsonResponse
     * @Route(
     *     "/set-product-overview/{overviewId}/{productId}",
     *     name="set-product-overview-action",
     *     requirements={"overviewId"="\d+", "productId"="\d+"},
     *     methods={"GET"}
     * )
     */
    public function setProductOverviewAction(int $overviewId, int $productId): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $overviews = $this
            ->getDoctrine()
            ->getRepository(News::class)
            ->findBy(
                [
                    'isOverview' => true,
                    'product' => $this
                                    ->getDoctrine()
                                    ->getRepository(Product::class)
                                    ->find($productId)
                ]
            );

        if (count($overviews) > 0) {
            foreach ($overviews as $overview) {
                $overview->setProduct(null);
                $em->persist($overview);
                $em->flush();
            }
        }

        $overview = $this->getDoctrine()->getRepository(News::class)->find($overviewId);
        $overview->setProduct(
            $this->getDoctrine()->getRepository(Product::class)->find($productId)
        );

        $em->persist($overview);
        $em->flush();

        return new JsonResponse($this->getSerializer()->normalize($overview));
    }

    /**
     * @param Request $request
     * @Route(
     *     "/add",
     *     name="add-news-action",
     *     methods={"POST"}
     * )
     * @return JsonResponse
     */
    public function addNewsAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var News $news */
            $news = $form->getData();
            $news->setCreatedAt(new \DateTime());
            $news->setIsMain($request->get('isMain'));

            if ($request->files->get('previewImage')) {
                /** @var UploadedFile $file */
                $file = $request->files->get('previewImage');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('news_images_directory'),
                    $fileName
                );

                $news->setPreviewImage($fileName);
            }

            $news->setCategory(
                $this->getDoctrine()
                                   ->getRepository(NewsCategory::class)
                                   ->find($request->get('category_id'))
            );

            if ($request->get('subCategory_id')) {
                $news->setSubCategory(
                    $this
                    ->getDoctrine()
                    ->getRepository(NewsSubCategory::class)
                    ->find($request->get('subCategory_id'))
                );
            }

            $em = $this->getDoctrine()->getManager();

            if ($request->get('isSeo')) {
                $seoInformation = new NewsSeo();
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setNews($news);
                $em->persist($seoInformation);
            }

            $em->persist($news);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($news));
        }

        return new JsonResponse(['error' => 'Something has been happened'], Response::HTTP_BAD_REQUEST);

    }

    /**
     * @param Request $request
     * @param int $newsId
     * @return JsonResponse
     * @Route(
     *     "/edit/{newsId}",
     *     requirements={"newsId"="\d+"},
     *     name="edit-news-action",
     *     methods={"POST"}
     * )
     */
    public function editNewsAction(Request $request, int $newsId): JsonResponse
    {
        $news = $this
            ->getDoctrine()
            ->getRepository(News::class)
            ->find($newsId);
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var News $news */
            $news = $form->getData();
            $news->setIsMain($request->get('isMain'));

            if ($request->files->get('previewImage')) {
                /** @var UploadedFile $file */
                $file = $request->files->get('previewImage');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('news_images_directory'),
                    $fileName
                );

                $news->setPreviewImage($fileName);
            }

            $news->setCategory(
                $this->getDoctrine()
                    ->getRepository(NewsCategory::class)
                    ->find($request->get('category_id'))
            );

            if ($request->get('subCategory_id')) {
                $news->setSubCategory(
                    $this
                        ->getDoctrine()
                        ->getRepository(NewsSubCategory::class)
                        ->find($request->get('subCategory_id'))
                );
            }

            $em = $this->getDoctrine()->getManager();

            if ($request->get('isSeo') && !$request->get('seo_id')) {
                $seoInformation = new NewsSeo();
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setNews($news);
                $em->persist($seoInformation);
            }
            if ($request->get('seo_id')) {
                $seoInformation = $this->getDoctrine()->getRepository(NewsSeo::class)->find($request->get('seo_id'));
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setNews($news);
                $em->persist($seoInformation);
            }

            $em->persist($news);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($news));
        }

        return new JsonResponse(['error' => 'Something has been happened'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @Route(
     *     "/add-category",
     *     name="add-news-category-action",
     *     methods={"POST"}
     * )
     * @return JsonResponse
     */
    public function addNewsCategory(Request $request)
    {
        $category = new NewsCategory();
        $form = $this->createForm(NewsCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new JsonResponse(['message' => 'News category has been successfully saved']);
        }

        return new JsonResponse(['error' => 'Something has been happened']);
    }

    /**
     * @Route(
     *     "/categories",
     *     methods={"GET"},
     *     name="news-categories-action"
     * )
     */
    public function newsCategoryAction()
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository(NewsCategory::class)
            ->findAll();

        $categories = $this->getSerializer()->normalize($categories);

        return new JsonResponse($categories);
    }
}