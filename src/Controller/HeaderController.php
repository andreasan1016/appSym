<?php

namespace App\Controller;

use App\Entity\Header;
use App\Form\HeaderType;
use App\Repository\HeaderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/header")
 */
class HeaderController extends AbstractController
{
    /**
     * @Route("/", name="header_index", methods={"GET"})
     */
    public function index(HeaderRepository $headerRepository): Response
    {
        return $this->render('header/index.html.twig', [
            'headers' => $headerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="header_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $header = new Header();
        $form = $this->createForm(HeaderType::class, $header);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($header);
            $entityManager->flush();

            return $this->redirectToRoute('header_index');
        }

        return $this->render('header/new.html.twig', [
            'header' => $header,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="header_show", methods={"GET"})
     */
    public function show(Header $header): Response
    {
        return $this->render('header/show.html.twig', [
            'header' => $header,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="header_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Header $header): Response
    {
        $form = $this->createForm(HeaderType::class, $header);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('header_index');
        }

        return $this->render('header/edit.html.twig', [
            'header' => $header,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="header_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Header $header): Response
    {
        if ($this->isCsrfTokenValid('delete'.$header->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($header);
            $entityManager->flush();
        }

        return $this->redirectToRoute('header_index');
    }
}
