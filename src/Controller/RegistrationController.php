<?php

namespace App\Controller;

use App\Entity\Duckuser;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    // passe objet request de type request et ajouter les namespaced
    {
        $user = new Duckuser();
        $form = $this->createForm(RegistrationFormType::class, $user); //
        $form->handleRequest($request); //annalyse la request

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $photoFile = $form['photo']->getData();
            if ($photoFile) {
                $photoFileName = $fileUploader->upload($photoFile);
                $user->setPhoto('/image/'.$photoFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user); //faire persister dans le temps le user
            $entityManager->flush(); // do it flush dans la bdd

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
