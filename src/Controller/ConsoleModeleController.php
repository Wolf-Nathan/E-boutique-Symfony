<?php

namespace App\Controller;

use App\Entity\ConsoleModele;
use App\Form\ConsoleModeleType;
use App\Repository\ConsoleModeleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consoleModele")
 */
class ConsoleModeleController extends AbstractController
{
    /**
     * @Route("/", name="console_modele_index", methods={"GET"})
     */
    public function index(ConsoleModeleRepository $consoleModeleRepository): Response
    {
        return $this->render('console_modele/index.html.twig', [
            'console_modeles' => $consoleModeleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="console_modele_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $consoleModele = new ConsoleModele();
        $form = $this->createForm(ConsoleModeleType::class, $consoleModele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consoleModele);
            $entityManager->flush();

            return $this->redirectToRoute('console_modele_index');
        }

        return $this->render('console_modele/new.html.twig', [
            'console_modele' => $consoleModele,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="console_modele_show", methods={"GET"})
     */
    public function show(ConsoleModele $consoleModele): Response
    {
        return $this->render('console_modele/show.html.twig', [
            'console_modele' => $consoleModele,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="console_modele_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConsoleModele $consoleModele): Response
    {
        $form = $this->createForm(ConsoleModeleType::class, $consoleModele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('console_modele_index');
        }

        return $this->render('console_modele/edit.html.twig', [
            'console_modele' => $consoleModele,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="console_modele_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ConsoleModele $consoleModele): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consoleModele->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consoleModele);
            $entityManager->flush();
        }

        return $this->redirectToRoute('console_modele_index');
    }
}
