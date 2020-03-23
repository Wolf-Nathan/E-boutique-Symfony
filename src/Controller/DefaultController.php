<?php

namespace App\Controller;

use App\Repository\JeuxRepository;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController{

    public function index(JeuxRepository $jeuxRepository, MarqueRepository $marqueRepository){

        return $this->render('home/index.html.twig', [
            'title' => 'Accueil',
            'jeux' => $jeuxRepository->findAll(),
            'marques' => $marqueRepository->findAll()
        ]);
    }
}