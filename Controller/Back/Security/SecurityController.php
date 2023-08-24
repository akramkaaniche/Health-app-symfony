<?php

namespace App\Controller\Back\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/LoginBack", name="loginBack")
     */
    public function login(Request $request,AuthenticationUtils $utils): Response
    {
        $error=$utils->getLastAuthenticationError();
        $last_id=$utils->getLastUsername();
        return $this->render('Back/Security/login.html.twig', [
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
