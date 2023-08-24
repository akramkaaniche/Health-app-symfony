<?php

namespace App\Controller\Back\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/HomeBack", name="HomeBack")
     */
    public function index(): Response
    {
        return $this->render('Back/Home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
