<?php

namespace App\Controller\Back\Coach;

use App\Entity\User;
use App\Form\Coach\CoachPasswordType;
use App\Services\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordController extends AbstractController
{

    private $encoder;
    private $user;


    public function __construct(UserPasswordEncoderInterface $encoder, GetUser $Get_User)
    {
        $this->encoder = $encoder;
        $this->user = $Get_User->Get_User();

        if($Get_User == null)
        {
            return $this->redirectToRoute('login');
        }
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Coach/Profil/Change_Password", name="change_passwordCoach")
     */


    function modifier(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(CoachPasswordType::class,$this->user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $password = $form->getData()->getPassword();
            $form->getData()->setPassword($this->encoder->encodePassword($this->user, $password));
            $entityManager->flush();
            return $this->redirectToRoute('ProfilCoach');
        }

        return $this->render('Back/Coach/Profil/change_password/changePassword.html.twig',
            ['form_modify' => $form->createView(),
                'User'=>$this->user,
            ]);

    }
}
