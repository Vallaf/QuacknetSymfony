<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\CommentType;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{
    /**
     * @Route("/", name="quack_index", methods={"GET"})
     */
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quack_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $quack = new Quack();
        $form = $this->createForm(QuackType::class, $quack);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quack->setAuthor($this->getUser());
            $quack->setCreatedAt(new \DateTime('now', (new \DateTimeZone('Europe/Paris'))));
            $photoFile = $form['photo']->getData();
            if ($photoFile) {
                $photoFileName = $fileUploader->upload($photoFile);
                $quack->setPhoto('/image/' . $photoFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_show", methods={"GET"})
     */
    public function show(Quack $quack): Response
    {
        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    /**
     * @Route("/{quack}/edit", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('quack_edit', $quack);
        $form = $this->createForm(QuackType::class, $quack);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quack->setCreatedAt(new \DateTime('now', (new \DateTimeZone('Europe/Paris'))));
            $photoFile = $form['photo']->getData();
            if ($photoFile) {
                $photoFileName = $fileUploader->upload($photoFile);
                $quack->setPhoto('/image/' . $photoFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{parent}/comment/new", name="quack_newcomment", methods={"GET","POST"})
     */
    public function newcomment(Request $request, Quack $parent = null): Response
    {
        $quack = new Quack();
        $quack->setParent($parent);
        $form = $this->createForm(CommentType::class, $quack);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quack->setAuthor($this->getUser());
            $quack->setCreatedAt(new \DateTime('now', (new \DateTimeZone('Europe/Paris'))));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/newcomment.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{quack}", name="quack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quack $quack): Response
    {
        $this->denyAccessUnlessGranted('quack_edit', $quack);

        if ($this->isCsrfTokenValid('delete' . $quack->getId(), $request->request->get('_token'))) {
            $this->denyAccessUnlessGranted('quack_edit', $quack);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_index');
    }
}
