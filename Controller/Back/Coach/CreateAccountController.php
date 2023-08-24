<?php

namespace App\Controller\Back\Coach;

use App\Entity\User;
use App\Form\Coach\CoachAddType;
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
     * @Route("/Coach/CreateAccount", name="CoachCreateAccount")
     */


    function ajouter(Request $request)
    {
        $user = new User();

        $form = $this->createForm(CoachAddType::class, $user);



        $user->setRole("CoachV");
        $user->setRoles(array('ROLE_COACH'));
        $form->getData()->setAdresse("NULL");
        $form->setData($form->getData());

        $user->setAdresse('');

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
        return $this->render('Back/Coach/CreateAccount/createAccount.html.twig',
            ['form' => $form->createView()
            ]);


    }
}
