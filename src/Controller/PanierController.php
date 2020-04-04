<?php

namespace App\Controller;

use App\Entity\Console;
use App\Repository\JeuxRepository;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Jeux;
use App\Entity\ConsoleModele;
use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\CommandeLine;

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
        $jeuxQuantity = $session->get('jeuxQuantity');
        $totalJeux = 0;
        $totalPrixJeux = 0;
        if($jeux) {
            foreach ($jeux as $jeu) {
                $totalJeux = $totalJeux + $jeuxQuantity[$jeu->getId()];
                $prix = $jeu->getPrix() * $jeuxQuantity[$jeu->getId()];
                $totalPrixJeux = $totalPrixJeux + $prix;
            }
        }

        /** @var \App\Entity\ConsoleModele[] $consoles */
        $consoles = $session->get('consoles');
        $consolesQuantity = $session->get('consolesQuantity');
        $totalConsole = 0;
        $totalPrixConsole = 0;
        if($consoles) {
            foreach ($consoles as $console) {
                $totalConsole = $totalConsole + $consolesQuantity[$console->getId()];
                $prix = $console->getPrix() * $consolesQuantity[$console->getId()];
                $totalPrixConsole = $totalPrixConsole + $prix;
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
            'totalPrix' => $totalPrix,
            'jeuxQuantity' => $jeuxQuantity,
            'consolesQuantity' => $consolesQuantity,
        ]);
    }

    /**
     * @Route("/{id}/jeux-en-moins", name="jeux_panier_delete", methods={"GET", "POST"})
     */
    public function removeGame(Request $request, Jeux $jeux){
        $jeuId = $jeux->getId();
        $session = $request->getSession();
        /** @var \App\Entity\Jeux[] $jeuxInCart */
        $jeuxInCart = $session->get('jeux');
        $jeuxQuantity = $session->get('jeuxQuantity');
        if(is_array($jeuxInCart)) {
            if(isset($jeuxInCart[$jeuId])) {
                $jeuxQuantity[$jeuId]--;
                if (!$jeuxQuantity[$jeuId]) {
                    unset($jeuxInCart[$jeuId]);
                    unset($jeuxQuantity[$jeuId]);
                }
            }
        }
        $session->set('jeux', $jeuxInCart);
        $session->set('jeuxQuantity', $jeuxQuantity);
        $session->save();
        return $this->index($request);
    }

    /**
     * @Route("/{id}/jeux-en-plus", name="jeux_panier_add", methods={"GET", "POST"})
     */
    public function addGame(Request $request, Jeux $jeux){
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
        return $this->index($request);
    }

    /**
     * @Route("/panier/validation-etape-1", name="panier_step_one", methods={"GET", "POST"})
     */
    public function validCartStepOne(){
        $security = $this->container->get('security.token_storage');
        $token = $security->getToken();
        if($token){
            /** @var \App\Entity\User $user */
            $user = $token->getUser();
        }
        return $this->render('panier/valid_step_one.html.twig', [
            'adresses' => $user->getAdresses()
        ]);
    }

    /**
     * @Route("/panier/validation-etape-2/{id}", name="panier_step_two", methods={"GET", "POST"})
     */
    public function validCartStepTwo(Request $request, Adresse $adresse)
    {
        $security = $this->container->get('security.token_storage');
        $token = $security->getToken();
        if ($token) {
            /** @var \App\Entity\User $user */
            $user = $token->getUser();

            // Recuperation des articles pour creer les lignes de commandes.
            $session = $request->getSession();
            $jeux = $session->get('jeux');
            $jeuxQuantity = $session->get('jeuxQuantity');
            $consoles = $session->get('consoles');
            $consolesQuantity = $session->get('consolesQuantity');
            if($jeux || $consoles) {

                // Creation de la commande.
                $commande = new Commande();
                $commande->setValid(true);
                $commande->setDate(new \DateTime);
                $commande->setUser($user);
                $commande->setAdresse($adresse);

                // Ajout de la commande en base.
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commande);
                $entityManager->flush();


                if ($jeux) {
                    foreach ($jeux as $jeu) {
                        if ($jeu instanceof \App\Entity\Jeux) {
                            $commandeLine = new CommandeLine();
                            //$entityManager->persist($commandeLine);
                            $commandeLine->setCommande($commande);
                            $commandeLine->setJeu($jeu);
                            //$quantite = $jeuxQuantity[$jeu->getId()];
                            $commandeLine->setQuantite($jeuxQuantity[$jeu->getId()]);
                            $commandeLine->setConsole(null);

                            // Ajout de la ligne de commande en base.
                            $entityManager->merge($commandeLine);
                            $entityManager->flush();
                        }
                    }
                    //$this->commandeLineJeux($jeux, $jeuxQuantity, $commande);
                }
                if ($consoles) {
                    foreach ($consoles as $console) {
                        $commandeLine = new CommandeLine();
                        $commandeLine->setCommande($commande);
                        $commandeLine->setConsole($console);
                        $commandeLine->setQuantite($consolesQuantity[$console->getId()]);
                        $commandeLine->setJeu(null);

                        // Ajout de la ligne de commande en base.
                        $entityManager->merge($commandeLine);
                        $entityManager->flush();
                    }
                }
                $session->set('jeux', null);
                $session->set('jeuxQuantity', null);
                $session->set('consoles', null);
                $session->set('consolesQuantity', null);
                return $this->render('panier/valid_step_two.html.twig', [
                    'commande' => $commande,
                    'commandeId' => $commande->getId()
                ]);
            }
        }
        return $this->render('panier/valid_step_two.html.twig', [
            'commande' => null,
            'commandeId' => null
        ]);
    }

    /**
     * @Route("/{id}/console-en-moins", name="console_panier_delete", methods={"GET", "POST"})
     */
    public function removeConsole(Request $request, ConsoleModele $consoleModele){
        $consoleModeleId = $consoleModele->getId();
        $session = $request->getSession();
        /** @var \App\Entity\Jeux[] $jeuxInCart */
        $consolesInCart = $session->get('consoles');
        $consolesQuantity = $session->get('consolesQuantity');
        if(is_array($consolesInCart)) {
            if(isset($consolesInCart[$consoleModeleId])) {
                $consolesQuantity[$consoleModeleId]--;
                if (!$consolesQuantity[$consoleModeleId]) {
                    unset($consolesInCart[$consoleModeleId]);
                    unset($consolesQuantity[$consoleModeleId]);
                }
            }
        }
        $session->set('consoles', $consolesInCart);
        $session->set('consolesQuantity', $consolesQuantity);
        $session->save();
        return $this->index($request);
    }

    /**
     * @Route("/{id}/console-en-plus", name="console_panier_add", methods={"GET", "POST"})
     */
    public function addConsole(Request $request, ConsoleModele $consoleModele){
        $consoleModeleId = $consoleModele->getId();
        $session = $request->getSession();
        if(!$session->isStarted()){
            $session->start();
        }
        $consolesSession = $session->get('consoles');
        $consolesQuantity = $session->get('consolesQuantity');
        if($consolesSession){
            if(isset($consolesQuantity[$consoleModeleId])) {
                $consolesQuantity[$consoleModeleId]++;
            }
            else {
                $consolesSession[$consoleModeleId] = $consoleModele;
                $consolesQuantity[$consoleModeleId] = 1;
            }
        }
        else {
            $consolesSession = array(
                $consoleModeleId => $consoleModele
            );
            $jeuxQuantity = array(
                $consoleModeleId => 1
            );

        }
        $session->set('consoles', $consolesSession);
        $session->set('consolesQuantity', $consolesQuantity);
        $session->save();
        return $this->index($request);
    }
}