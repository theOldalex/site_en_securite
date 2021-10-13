<?php

namespace App\Controller;

use App\Entity\Z5600;
use App\Form\Z56001Type;
use App\Repository\Z5600Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/z5600")
     */
class Z5600Controller extends AbstractController
{
    /**
     * @Route("/z5600", name="z5600")
     */
    public function index(Z5600Repository $z5600Repository): Response
    {
        return $this->render('z5600/z5600.html.twig', [
            'z5600s' => $z5600Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="z5600_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $z5600 = new Z5600();
        $form = $this->createForm(Z56001Type::class, $z5600);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($z5600);
            $entityManager->flush();

            return $this->redirectToRoute('z5600', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('z5600/new.html.twig', [
            'z5600' => $z5600,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="z5600_show", methods={"GET"})
     */
    public function show(Z5600 $z5600): Response
    {
        return $this->render('z5600/show.html.twig', [
            'z5600' => $z5600,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="z5600_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Z5600 $z5600): Response
    {
        $form = $this->createForm(Z56001Type::class, $z5600);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('z5600', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('z5600/edit.html.twig', [
            'z5600' => $z5600,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="z5600_delete", methods={"POST"})
     */
    public function delete(Request $request, Z5600 $z5600): Response
    {
        if ($this->isCsrfTokenValid('delete'.$z5600->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($z5600);
            $entityManager->flush();
        }

        return $this->redirectToRoute('z5600', [], Response::HTTP_SEE_OTHER);
    }
}
