<?php

namespace App\Controller\Back\ListUsers;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ListCoachsController extends AbstractController
{
    /**
     * @Route("/list/clients", name="list_clients")
     */
    public function index(): Response
    {
        return $this->render('Back/list_coachs/listeClients.html.twig', [
            'controller_name' => 'ListClientsController',
        ]);
    }
    /**
     * @return Response
     * @Route("/coachs",name="lists_coachs")
     */


    public function afficher()
    {

        $User = $this->getDoctrine()->getRepository(User::class)->findBy(
            ['role' => 'CoachV'],
        );






        return $this->render("Back/list_coachs/listeCoachs.html.twig", array('users' => $User));
    }



}
