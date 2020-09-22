<?php

namespace App\Controller\Web;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\ClickRepository;
use App\Repository\LinkRepository;
use App\Service\Shortener\Shortener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkController extends AbstractController
{
    public function index(LinkRepository $linkRepository): Response
    {
        return $this->render('link/index.html.twig', [
            'links' => $linkRepository->findBy(
                [
                    'userId' => $this->getUser()->getId(),
                ],
                [
                    'isFavourite' => 'desc',
                    'createdAt' => 'desc',
                ]
            ),
        ]);
    }

    public function new(Request $request, Shortener $shortener): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $link->setOwner($this->getUser());
            $em->persist($link);

            $link->setUrlPath(
                $shortener->uniqueUrlPath($link)
            );

            $em->flush();

            return $this->redirectToRoute('link_show', [
                'urlPath' => $link->getUrlPath(),
            ]);
        }

        return $this->render('link/new.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
        ]);
    }


    public function show(Link $link, ClickRepository $clickRepository): Response
    {
        $this->denyAccessUnlessGranted('view', $link);

        $clicksTotal = $clickRepository->countTotalByLink($link);
        $uniqueClicksTotal = $clickRepository->uniqueCountTotalByLink($link);

        return $this->render('link/show.html.twig', [
            'link' => $link,
            'clicksTotal' => $clicksTotal,
            'uniqueClicksTotal' => $uniqueClicksTotal,
        ]);
    }

    public function edit(Request $request, Link $link): Response
    {
        $this->denyAccessUnlessGranted('edit', $link);

        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('link_index');
        }

        return $this->render('link/edit.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Link $link): Response
    {
        $this->denyAccessUnlessGranted('delete', $link);

        if ($this->isCsrfTokenValid('delete' . $link->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($link);
            $entityManager->flush();
        }

        return $this->redirectToRoute('link_index');
    }
}
