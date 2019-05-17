<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Category;
use App\AdminBundle\Entity\SubCategory;
use App\AdminBundle\Entity\SubCategorySeo;
use App\AdminBundle\Form\Category\SubCategoryType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubCategoryController
 * @package App\AdminBundle\Controller
 * @Route("/sub-category")
 */
class SubCategoryController extends BaseController
{
    /**
     * @param Request $request
     * @param int $categoryId
     * @Route(
     *     "/new/{categoryId}",
     *     name="new-sub-category-action",
     *     methods={"POST"},
     *     requirements={"categoryId"="\d+"}
     * )
     * @return JsonResponse
     */
    public function newSubCategoryAction(Request $request, int $categoryId)
    {
        $subCategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted()) {
            /** @var SubCategory $subCategory */
            $subCategory = $form->getData();
            $subCategory->setParentCategory(
                $this->getDoctrine()->getRepository(Category::class)->find($categoryId)
            );

            if ($request->get('isSeo') && !$request->get('seo_id')) {
                $seoInformation = new SubCategorySeo();
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setSubCategory($subCategory);
                $em->persist($seoInformation);
            }
            if ($request->get('seo_id')) {
                /** @var SubCategorySeo $seoInformation */
                $seoInformation = $this->getDoctrine()->getRepository(SubCategorySeo::class)->find($request->get('seo_id'));
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setSubCategory($subCategory);
                $em->persist($seoInformation);
            }

            $em->persist($subCategory);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize(
                $this->getDoctrine()->getRepository(SubCategory::class)->find($subCategory->getId())
            ));
        }

        return new JsonResponse(
            ['error' => 'Some problem has been happened'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param Request $request
     * @param int $subCategoryId
     * @Route(
     *     "/edit/{subCategoryId}",
     *     name="edit-sub-category-action",
     *     methods={"POST"},
     *     requirements={"subCategoryId"="\d+"}
     * )
     * @return JsonResponse
     */
    public function editSubCategoryAction(Request $request, int $subCategoryId)
    {
        $subCategory = $this->getDoctrine()->getRepository(SubCategory::class)->find($subCategoryId);
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted()) {
            $subCategory = $form->getData();

            if ($request->get('isSeo') && !$request->get('seo_id')) {
                $seoInformation = new SubCategorySeo();
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setSubCategory($subCategory);
                $em->persist($seoInformation);
            }
            if ($request->get('seo_id')) {
                /** @var SubCategorySeo $seoInformation */
                $seoInformation = $this->getDoctrine()->getRepository(SubCategorySeo::class)->find($request->get('seo_id'));
                $seoInformation ->setTitle($request->get('seoTitle'))
                    ->setDescription($request->get('seoDescription'))
                    ->setSubCategory($subCategory);
                $em->persist($seoInformation);
            }

            $em->persist($subCategory);
            $em->flush();

            return new JsonResponse($this->getSerializer()->normalize($subCategory));
        }

        return new JsonResponse(
            ['error' => 'Some problem has been happened'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param int $subCategoryId
     * @Route(
     *     "/delete/{subCategoryId}",
     *     name="delete-sub-category-action",
     *     methods={"DELETE"},
     *     requirements={"subCategoryId"="\d+"}
     * )
     * @return JsonResponse
     */
    public function deleteSubCategoryAction(int $subCategoryId): JsonResponse
    {
        $subCategory = $this->getDoctrine()->getRepository(SubCategory::class)->find($subCategoryId);

        if (null == $subCategory) {
            return new JsonResponse(
                ['error' => 'Not found category with the same id.'],
                Response::HTTP_NOT_FOUND
            );
        }

        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($subCategory);
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