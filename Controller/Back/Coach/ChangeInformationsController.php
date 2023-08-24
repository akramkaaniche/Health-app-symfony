<?php

namespace App\Controller\Back\Coach;

use App\Form\Coach\CoachAddType;
use App\Services\GetUser;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Coach\CoachModifyType;


class ChangeInformationsController extends AbstractController
{
    private $user;


    public function __construct(GetUser $Get_User)
    {
        $this->user = $Get_User->Get_User();

        if($Get_User == null)
        {
            return $this->redirectToRoute('login');
        }
    }






    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Coach/Profil/Change_informations", name="ProfilCoach")
     */


    function modifier(Request $request)
    {     $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(CoachModifyType::class,$this->user);
        $form->handleRequest($request);
        $file = $form->get('picture')->getData();


        if($form->isSubmitted()&&$form->isValid())

        {

            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('pictures_directory'), $fileName);
                $user->setPicture($fileName);
                $form->getData()->setPicture($fileName);
            }


            $entityManager->flush();
        }

        return $this->render('Back/Coach/Profil/profil.html.twig',
            ['form_modify' => $form->createView(),
                'User'=>$this->user,
            ]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Coach/Profil/Delete", name="delete")
     */
    public function delete()
    {$entityManager = $this->getDoctrine()->getManager();
        $this->redirectToRoute('login');
        $entityManager->remove($this->user);
        $entityManager->flush();

        return $this->redirectToRoute('login');

    }



}

