<?php

namespace App\Controller\Back\Admin;

use App\Form\Admin\AdminModifyType;
use App\Services\GetUser;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
     * @Route("/Admin/Profil/Change_informations", name="ProfilAdmin")
     */


    function modifier(Request $request)
    {     $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(AdminModifyType::class,$this->user);
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

        return $this->render('Back/Admin/Profil/profil.html.twig',
            ['form_modify' => $form->createView(),
                'User'=>$this->user,
            ]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Admin/Profil/Delete", name="delete")
     */
    public function delete()
    {$entityManager = $this->getDoctrine()->getManager();
        $this->redirectToRoute('login');
        $entityManager->remove($this->user);
        $entityManager->flush();

        return $this->redirectToRoute('login');

    }



}

