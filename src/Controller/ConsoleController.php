<?php

namespace App\Controller;

use App\Entity\Console;
use App\Form\ConsoleType;
use App\Repository\ConsoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/console")
 */
class ConsoleController extends AbstractController
{
    /**
     * @Route("/", name="console_index", methods={"GET"})
     */
    public function index(ConsoleRepository $consoleRepository): Response
    {
        return $this->render('console/index.html.twig', [
            'consoles' => $consoleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="console_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $console = new Console();
        $form = $this->createForm(ConsoleType::class, $console);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($console);
            $entityManager->flush();

            return $this->redirectToRoute('console_index');
        }

        return $this->render('console/new.html.twig', [
            'console' => $console,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="console_show", methods={"GET"})
     */
    public function show(Console $console): Response
    {
        return $this->render('console/show.html.twig', [
            'console' => $console,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="console_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Console $console): Response
    {
        $form = $this->createForm(ConsoleType::class, $console);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('console_index');
        }

        return $this->render('console/edit.html.twig', [
            'console' => $console,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="console_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Console $console): Response
    {
        if ($this->isCsrfTokenValid('delete'.$console->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($console);
            $entityManager->flush();
        }

        return $this->redirectToRoute('console_index');
    }
}
