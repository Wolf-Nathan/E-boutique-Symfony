<?php

namespace App\Controller;

use App\Repository\JeuxRepository;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{

    /**
     * @return Response
     */
    public function index(Request $request)
    {
        $session = $request->getSession();
        /** @var \App\Entity\Jeux[] $jeux */
        $jeux = $session->get('jeux');
        $totalJeux = 0;
        $totalPrixJeux = 0;
        if($jeux) {
            foreach ($jeux as $jeu) {
                $totalJeux++;
                $totalPrixJeux = $totalPrixJeux + $jeu->getPrix();
            }
        }

        /** @var \App\Entity\ConsoleModele[] $consoles */
        $consoles = $session->get('consoles');
        $totalConsole = 0;
        $totalPrixConsole = 0;
        if($consoles) {
            foreach ($consoles as $console) {
                $totalConsole++;
                $totalPrixConsole = $totalPrixConsole + $console->getPrix();
            }
        }

        $totalArticles = $totalJeux + $totalConsole;
        $totalPrix = $totalPrixConsole + $totalPrixJeux;

        return $this->render('panier/index.html.twig', [
            'jeux' => $jeux,
            'consoles' => $consoles,
            'totalJeux' => $totalJeux,
            'totalConsole' => $totalConsole,
            'totalPrixJeux' => $totalPrixJeux,
            'totalPrixConsole' => $totalPrixConsole,
            'totalArticles' => $totalArticles,
            'totalPrix' => $totalPrix
        ]);
    }
}