<?php

namespace App\Controller\Front\Client;

use App\Entity\User;
use App\Form\Client\ClientAddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

use Gedmo\Sluggable\Util\Urlizer;




class CreateAccountController extends AbstractController
{


    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;


    }



    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Client/CreateAccount", name="ClientCreateAccount")
     */


    function ajouter(Request $request)
    {
        $user = new User();

        $form = $this->createForm(ClientAddType::class, $user);



        $user->setRole("Client");
        $user->setRoles(array('ROLE_CLIENT'));
        $user->setSpecialite('');
        $form->getData()->setSpecialite("NULL");
        $form->setData($form->getData());

        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {



            $file = $form->get('picture')->getData();

            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('pictures_directory'), $fileName);
                $user->setPicture($fileName);
            }
            else{
                $user->setPicture('default.jpg');

            }

            $password = $form->getData()->getPassword();


            $form->getData()->setPassword($this->encoder->encodePassword($user, $password));


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('loginFront');
        }
        return $this->render('Front/Client/CreateAccount/createAccount.html.twig',
            ['form' => $form->createView()
            ]);


    }
}
