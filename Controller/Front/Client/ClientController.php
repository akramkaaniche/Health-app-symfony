<?php

namespace App\Controller\Front\Client;


    use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;



class ClientController extends AbstractController
{
    /**
     * @Route("/Client", name="Client")
     */
    public function index(): Response
    {
        return $this->render('Front/Client/login.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }










}
