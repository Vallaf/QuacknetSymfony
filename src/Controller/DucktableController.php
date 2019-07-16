<?php

namespace App\Controller;

use App\Entity\Ducktable;
use App\Form\DucktableType;
use App\Repository\DucktableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ducktable")
 */
class DucktableController extends AbstractController
{
    /**
     * @Route("/", name="ducktable_index", methods={"GET"})
     */
    public function index(DucktableRepository $ducktableRepository): Response
    {
        return $this->render('ducktable/index.html.twig', [
            'ducktables' => $ducktableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ducktable_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ducktable = new Ducktable();
        $form = $this->createForm(DucktableType::class, $ducktable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ducktable);
            $entityManager->flush();

            return $this->redirectToRoute('ducktable_index');
        }

        return $this->render('ducktable/new.html.twig', [
            'ducktable' => $ducktable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ducktable_show", methods={"GET"})
     */
    public function show(Ducktable $ducktable): Response
    {
        return $this->render('ducktable/show.html.twig', [
            'ducktable' => $ducktable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ducktable_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ducktable $ducktable): Response
    {
        $form = $this->createForm(DucktableType::class, $ducktable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ducktable_index');
        }

        return $this->render('ducktable/edit.html.twig', [
            'ducktable' => $ducktable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ducktable_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ducktable $ducktable): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ducktable->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ducktable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ducktable_index');
    }
}
