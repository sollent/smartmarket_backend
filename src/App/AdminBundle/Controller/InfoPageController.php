<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\InfoPage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InfoPageController
 * @package App\AdminBundle\Controller
 * @Route("/info-page")
 */
class InfoPageController extends BaseController
{
    /**
     * @param string $name
     * @return JsonResponse
     * @Route(
     *     "/{name}",
     *     name="get-info-pages-aciton",
     *     methods={"GET"}
     * )
     */
    public function getPagesByNameAction(string $name): JsonResponse
    {
        $pages = $this
            ->getSerializer()
            ->normalize(
                $this->getDoctrine()->getRepository(InfoPage::class)->findOneBy([
                    'slug' => $name
                ])
            );

        return new JsonResponse($pages);
    }

    /**
     * @Route(
     *     "/edit/{name}",
     *     name="edit-beznal-action",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @param string $name
     * @return JsonResponse
     */
    public function editBeznalAction(Request $request, string $name): JsonResponse
    {
        $page = $this->getDoctrine()->getRepository(InfoPage::class)->findOneBy([
            'slug' => $name
        ]);

        $page->setTitle($request->get('title'));
        $page->setContent($request->get('content'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();

        return new JsonResponse($page);
    }
}