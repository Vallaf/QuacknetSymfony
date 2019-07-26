<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 25/07/2019
 * Time: 11:27
 */

namespace App\Controller;


use App\Entity\Duckuser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @return Response
     * @Route("/Hello/{duckname}")
     */
    public function index(Duckuser $duckuser)
    {

dd($duckuser);
        return new Response("Hello ");
    }
}