<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController{

    public function profile(){
        $security = $this->container->get('security.token_storage');
        $token = $security->getToken();
        if($token){
            /** @var \App\Entity\User $user */
            $user = $token->getUser();
        }
        return $this->render('user/profil.html.twig', [
            'adresses' => $user->getAdresses(),
            'commandes' => $user->getCommandes()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$form = $this->createForm(UserType::class, $user);
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('telephone', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/addAddress", name="add_address", methods={"GET", "POST"})
     */
    public function addAddress(Request $request, User $user): Response
    {
        $adresse = new Adresse();
        $form = $this->createFormBuilder($adresse)
            ->add('nom', TextType::class)
            ->add('prenom', Texttype::class)
            ->add('telephone', Texttype::class)
            ->add('voie', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('ville', TextType::class)
            ->add('pays', TextType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->setNom($form->get('nom')->getData());
            $adresse->setPrenom($form->get('prenom')->getData());
            $adresse->setTelephone($form->get('telephone')->getData());
            $adresse->setVoie($form->get('voie')->getData());
            $adresse->setCodePostal($form->get('codePostal')->getData());
            $adresse->setVille($form->get('ville')->getData());
            $adresse->setPays($form->get('pays')->getData());
            $adresse->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adresse);
            $entityManager->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/addAddress.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="adresse_delete", methods={"DELETE"})
     */
    public function deleteAddress(Request $request, Adresse $adresse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adresse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profil');
    }

    /**
     * @Route("/{id}/edit-address", name="address_edit", methods={"GET","POST"})
     */
    public function editAddress(Request $request, Adresse $adresse): Response
    {
        $form = $this->createFormBuilder($adresse)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('telephone', TextType::class)
            ->add('voie', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('ville', TextType::class)
            ->add('pays', TextType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/editAddress.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView()
        ]);
    }
}