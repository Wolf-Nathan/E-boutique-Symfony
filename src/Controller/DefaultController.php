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

        $jeux = $jeuxRepository->findAll();
        $derniersJeux = [];
        for($i = 1; $i<6; $i++){
            if(isset($jeux[ sizeof($jeux) - $i ])) {
                $derniersJeux[] = $jeux[sizeof($jeux) - $i ];
            }
        }
        return $this->render('home/index.html.twig', [
            'title' => 'Accueil',
            'jeux' => $derniersJeux,
            'marques' => $marqueRepository->findAll()
        ]);
    }

}