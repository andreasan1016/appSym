<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Form\FriendshipType;
use App\Repository\FriendshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/friendship")
 */
class FriendshipController extends AbstractController
{
    /**
     * @Route("/", name="friendship_index", methods={"GET"})
     */
    public function index(FriendshipRepository $friendshipRepository): Response
    {
        return $this->render('friendship/index.html.twig', [
            'friendships' => $friendshipRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="friendship_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $friendship = new Friendship();
        $form = $this->createForm(FriendshipType::class, $friendship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($friendship);
            $entityManager->flush();

            return $this->redirectToRoute('friendship_index');
        }

        return $this->render('friendship/new.html.twig', [
            'friendship' => $friendship,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="friendship_show", methods={"GET"})
     */
    public function show(Friendship $friendship): Response
    {
        return $this->render('friendship/show.html.twig', [
            'friendship' => $friendship,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="friendship_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Friendship $friendship): Response
    {
        $form = $this->createForm(FriendshipType::class, $friendship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('friendship_index');
        }

        return $this->render('friendship/edit.html.twig', [
            'friendship' => $friendship,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="friendship_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Friendship $friendship): Response
    {
        if ($this->isCsrfTokenValid('delete'.$friendship->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friendship);
            $entityManager->flush();
        }

        return $this->redirectToRoute('friendship_index');
    }
}
