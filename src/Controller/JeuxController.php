<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Jeux;
use App\Form\JeuxType;
use App\Repository\JeuxRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jeux")
 */
class JeuxController extends AbstractController
{
    /**
     * @Route("/", name="jeux_index", methods={"GET"})
     */
    public function index(JeuxRepository $jeuxRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('jeux/index.html.twig', [
            'jeux' => $jeuxRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'filtre' => null
        ]);
    }

    /**
     * @Route("/new", name="jeux_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jeux = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jeux);
            $entityManager->flush();

            return $this->redirectToRoute('jeux_index');
        }

        return $this->render('jeux/new.html.twig', [
            'jeux' => $jeux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeux_show", methods={"GET"})
     */
    public function show(Jeux $jeux): Response
    {
        return $this->render('jeux/show.html.twig', [
            'jeux' => $jeux,
            'ajout' => false
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jeux_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Jeux $jeux): Response
    {
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jeux_index');
        }

        return $this->render('jeux/edit.html.twig', [
            'jeux' => $jeux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeux_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Jeux $jeux): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jeux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jeux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jeux_index');
    }

    /**
     * @Route("/{id}/panier", name="jeux_panier", methods={"GET", "POST"})
     */
    public function addToCart(Request $request, Jeux $jeux){
        $jeuId = $jeux->getId();
        $session = $request->getSession();
        if(!$session->isStarted()){
            $session->start();
        }
        $jeuxSession = $session->get('jeux');
        $jeuxQuantity = $session->get('jeuxQuantity');
        if($jeuxSession){
            if(isset($jeuxQuantity[$jeuId])) {
                $jeuxQuantity[$jeuId]++;
            }
            else {
                $jeuxSession[$jeuId] = $jeux;
                $jeuxQuantity[$jeuId] = 1;
            }
        }
        else {
            $jeuxSession = array(
                $jeuId => $jeux
            );
            $jeuxQuantity = array(
                $jeuId => 1
            );

        }
        $session->set('jeux', $jeuxSession);
        $session->set('jeuxQuantity', $jeuxQuantity);
        $session->save();
        return $this->render('jeux/show.html.twig', [
            'jeux' => $jeux,
            'ajout' => true
        ]);
    }


}
