<?php

namespace App\Controller;

use App\Entity\Duckuser;
use App\Form\DuckuserType;
use App\Repository\DuckuserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\CsrfFormLoginBundle\Form\UserLoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;

/**
 * @Route("/duckuser")
 */
class DuckuserController extends AbstractController
{

    /**
     * @route("/register", name="duckuser_register",  methods={"GET","POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //build the form
        $duckuser = new Duckuser();
        $form = $this->createForm(DuckuserType::class, $duckuser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        // encode password
        $password = $passwordEncoder->encodePassword($duckuser,$duckuser->getPassword());
        $duckuser->setPassword();

        //enregistrer nouveau duck
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duckuser);
            $entityManager->flush();

            return $this->redirectToRoute('duckuser_register');
        }
        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );

    }
    /**
     * @Route("/", name="duckuser_index", methods={"GET"})
     */
    public function index(DuckuserRepository $ducktableRepository): Response
    {
        return $this->render('duckuser/index.html.twig', [
            'duckusers' => $ducktableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="duckuser_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $duckuser = new Duckuser();
        $form = $this->createForm(DuckuserType::class, $duckuser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duckuser);
            $entityManager->flush();

            return $this->redirectToRoute('duckuser_index');
        }

        return $this->render('duckuser/new.html.twig', [
            'duckuser' => $duckuser,
            'form' => $form->createView(),
        ]);
    }

    /**
 * @Route("/{id}", name="duckuser_show", methods={"GET"})
 */
    public function show(Duckuser $duckuser): Response
    {
        return $this->render('duckuser/show.html.twig', [
            'duckuser' => $duckuser,
        ]);
    }
    /**
     * @Route("/account/{id}", name="duckuser_account", methods={"GET"})
     */
    public function showAccounnt(Duckuser $duckuser): Response
    {
        return $this->render('accountUser/account.html.twig', [
            'duckuser' => $duckuser,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="duckuser_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duckuser $duckuser): Response
    {
        $form = $this->createForm(DuckuserType::class, $duckuser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('duckuser_index');
        }

        return $this->render('duckuser/edit.html.twig', [
            'duckuser' => $duckuser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="duckuser_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Duckuser $duckuser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duckuser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($duckuser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('duckuser_index');
    }
}
