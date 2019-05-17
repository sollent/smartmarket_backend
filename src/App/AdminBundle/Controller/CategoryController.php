<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Category;
use App\AdminBundle\Form\Category\CategoryType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\AdminBundle\Controller
 * @Route("/category")
 */
class CategoryController extends BaseController
{
    /**
     * @Route(
     *     "",
     *     name="get-categories-action"
     * )
     */
    public function categoriesAction(): JsonResponse
    {
        $categories = $this
            ->getSerializer()
            ->normalize(
                $this
                    ->getDoctrine()
                    ->getRepository(Category::class)
                    ->findAll()
            );

        return new JsonResponse($categories);
    }

    /**
     * @Route(
     *     "/{categoryId}",
     *     name="get-category-by-id",
     *     requirements={"categoryId"="\d+"}
     * )
     * @param int $categoryId
     * @return JsonResponse
     */
    public function categoryByIdAction(int $categoryId): JsonResponse
    {
        $category = $this
            ->getSerializer()
            ->normalize(
                $this
                    ->getDoctrine()
                    ->getRepository(Category::class)
                    ->find($categoryId)
            );

        return new JsonResponse($category);
    }

    /**
     * @param Request $request
     * @Route("/new", methods={"POST"})
     * @return JsonResponse
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($category));
        }

        return new JsonResponse(
            ['error' => 'Some problem has been happened'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param Request $request
     * @param int $categoryId
     * @return JsonResponse
     * @Route(
     *     "/edit/{categoryId}",
     *      methods={"POST"},
     *     requirements={"category_id"="\d+"}
     * )
     */
    public function editCategoryAction(Request $request, int $categoryId): JsonResponse
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryId);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($category));
        }

        return new JsonResponse(
            ['error' => 'Some problem has been happened'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param int $categoryId
     * @return JsonResponse
     * @Route(
     *     "/delete/{categoryId}",
     *     methods={"DELETE"},
     *     requirements={"category_id"="\d+"}
     * )
     */
    public function deleteCategoryAction(int $categoryId): JsonResponse
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryId);

        if (null == $category) {
            return new JsonResponse(
                ['error' => 'Not found category with the same id.'],
                Response::HTTP_NOT_FOUND
            );
        }

        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($category);
            $em->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'error' => 'Some problem with deleting entity. May be you sent incorrect data.',
                    'content' => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(['message' => 'Category has been deleted']);
    }
}