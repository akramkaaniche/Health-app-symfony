<?php

namespace App\Controller\Back\Coach;


    use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;



class CoachController extends AbstractController
{
    /**
     * @Route("/Coach", name="Coach")
     */
    public function index(): Response
    {
        return $this->render('Back/Coach/login.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }










}
