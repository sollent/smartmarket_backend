<?php

namespace App\ClientBundle\Controller;

use App\AdminBundle\Entity\Category;
use App\AdminBundle\Entity\InfoPage;
use App\AdminBundle\Entity\News\News;
use App\AdminBundle\Entity\News\NewsCategory;
use App\AdminBundle\Entity\News\NewsSubCategory;
use App\AdminBundle\Entity\Product\Product;
use App\AdminBundle\Entity\Product\ProductColor;
use App\AdminBundle\Entity\SubCategory;

/**
 * Class ClientController
 * @package App\ClientBundle\Controller
 */
class ClientController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function catalogPageAction()
    {
        $categorySlugList = $this->getDoctrine()->getRepository(SubCategory::class)->findAll();
        // For the first time we get first category
        $currentCategory = $categorySlugList[0];
        return $this->redirectToRoute('app_client_catalog', [
            'slug' => $currentCategory->getSlug()
        ]);
    }

    /**
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function catalogAction(string $slug)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        /** @var Category $currentCategory */
        $currentCategory = $this->getDoctrine()
            ->getRepository(SubCategory::class)
            ->findOneBy(['slug' => $slug]);

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(['category' => $currentCategory, 'available' => true]);

        $products = $this->getSerializer()->normalize($products);
        return $this->render('@AppClient/default/catalog-page.html.twig', [
            'categories' => $categories,
            'current_category' => $currentCategory,
            'products' => $products
        ]);
    }

    /**
     * @param string $productId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productAction(string $productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        $productOverview = $this
            ->getDoctrine()
            ->getRepository(News::class)
            ->findOneBy(
                [
                    'product' => $product,
                    'isOverview' => true
                ]
            );
        // Bad decision
        $productCharacteristics = $this->getSerializer()->normalize($product->getCharacteristics()[0]);
        $productColors = $this->getDoctrine()->getRepository(ProductColor::class)->findAll();

        if (!$product->getProductColor()) {
            $productColors = null;
        }

        return $this->render('@AppClient/default/product-page.html.twig', [
            'product' => $product,
            'colors' => $productColors,
            'characteristics' => $productCharacteristics,
            'overview' => $productOverview
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsAction()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(NewsCategory::class)->findAll();
        $mainArticle = $this->getDoctrine()->getRepository(News::class)->findOneBy(['isMain' => true]);

        $popularNews = $this
            ->getDoctrine()
            ->getRepository(News::class)
            ->findBy(array(), ['likes' => 'DESC'], 6, null);

        return $this->render('@AppClient/default/news-page.html.twig', [
            'news' => $news,
            'categories' => $categories,
            'currentCategory' => 'all',
            'currentSubCategory' => null,
            'mainArticle' => $mainArticle,
            'popularNews' => $popularNews
        ]);
    }

    /**
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsByCategoryAction(string $slug)
    {
        $categories = $this->getDoctrine()->getRepository(NewsCategory::class)->findAll();

        /** @var NewsCategory $currentCategory */
        $currentCategory = $this
            ->getDoctrine()
            ->getRepository(NewsCategory::class)
            ->findOneBy(
                [
                    'slug' => $slug
                ]
            );

        $subCategory = $this
            ->getDoctrine()
            ->getRepository(NewsSubCategory::class)
            ->findOneBy(
                [
                    'slug' => $slug
                ]
            );

        if ($subCategory) {
            $currentCategory = $subCategory->getParentCategory();
        }

        $findByArray = $subCategory ? ['subCategory' => $subCategory] : ['category' => $currentCategory];

        $news = $this
            ->getDoctrine()
            ->getRepository(News::class)
            ->findBy($findByArray);

        $mainArticle = $this->getDoctrine()->getRepository(News::class)->findOneBy(['isMain' => true]);

        $popularNews = $this
            ->getDoctrine()
            ->getRepository(News::class)
            ->findBy(array(), ['likes' => 'DESC'], 6, null);


        return $this->render('@AppClient/default/news-page.html.twig', [
            'news' => $news,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'currentSubCategory' => $subCategory ?: 'all',
            'mainArticle' => $mainArticle,
            'popularNews' => $popularNews
        ]);
    }

    public function articleAction(int $articleId)
    {
        $article = $this->getDoctrine()->getRepository(News::class)->find($articleId);
        return $this->render('@AppClient/default/article.html.twig', [
            'article' => $article
        ]);
    }

    public function cartAction()
    {
        return $this->render('@AppClient/default/cart-page.html.twig');
    }

    public function contactsAction()
    {
        return $this->render('@AppClient/default/contacts.html.twig');
    }

    public function deliveryAndPaymentAction()
    {
        return $this->render('@AppClient/default/delivery-and-payment.html.twig');
    }

    public function guaranteeAction()
    {
        return $this->render('@AppClient/default/guarantee.html.twig');
    }

    public function aboutUsAction()
    {
        return $this->render('@AppClient/default/about-us.html.twig');
    }

    public function infoPageAction(string $slug)
    {
        $page = $this->getDoctrine()->getRepository(InfoPage::class)->findOneBy(
            [
                'slug' => $slug
            ]
        );
        return $this->render('@AppClient/default/info-page.html.twig', [
            'page' => $page
        ]);
    }

    public function chatPageAction()
    {
        return $this->render('@AppClient/default/chat.html.twig');
    }
}