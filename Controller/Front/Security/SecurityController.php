<?php

namespace App\Controller\Front\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\GetUserById;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $user;


    /**
     * @Route("/Login", name="loginFront")
     */
    public function login(Request $request,AuthenticationUtils $utils): Response
    { $this->user= new User();
        $error=$utils->getLastAuthenticationError();
        $last_id=$utils->getLastUsername();






        return $this->render('Front/Security/login.html.twig', [
            'error' => $error,
            'last_id'=> $last_id

        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){


    }

}
