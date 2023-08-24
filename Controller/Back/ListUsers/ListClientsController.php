<?php

namespace App\Controller\Back\ListUsers;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListClientsController extends AbstractController
{
    /**
     * @Route("/list/clients", name="list_clients")
     */
    public function index(): Response
    {
        return $this->render('Back/list_clients/listeClients.html.twig', [
            'controller_name' => 'ListClientsController',
        ]);
    }


    /**
     * @return Response
     * @Route("/clients",name="lists_clients")
     */


    public function afficher()
    {

        $User = $this->getDoctrine()->getRepository(User::class)->findBy(
            ['role' => 'Client'],
        );        return $this->render("Back/list_clients/listeClients.html.twig", array('users' => $User));
    }
}
