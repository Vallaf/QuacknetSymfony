<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="quack_home")
     */
    public function index()
    {
        return $this->render('quackhome/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


}
