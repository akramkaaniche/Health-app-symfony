<?php

namespace App\Controller;

use App\Entity\Participationtherapie;
use App\Entity\Therapie;
use App\Entity\User;
use App\Form\TherapieType;
use App\Services\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class TherapieController extends AbstractController
{
    /**
     * @Route("/Therapie", name="Therapie")
     */
    public function index(): Response
    {
        return $this->render('therapie/index.html.twig', [
            'controller_name' => 'TherapieController',
        ]);
    }

    /**
     * @Route("/ajouterTherapie", name="ajouterTherapie")
     */

    public function newTherapie(Request $request)
    {

        $Therapie = new Therapie();
        $form = $this->createForm(TherapieType::class,$Therapie);
        $form->add("Ajouter", SubmitType::class);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $em->persist($Therapie);
            $em->flush();
            return $this->redirectToRoute("listTherapie");
        }
        return    $this->render("therapie/index.html.twig",['our_form'=>$form->createView()]);

    }

    /**
     * @Route("/modifierTherapie/{id}", name="modifierTherapie")
     */
    public function modifierTherapie(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $Therapie= $this->getDoctrine()->getRepository(Therapie::class)->findAll();

        $res = $em->getRepository(Therapie::class)->find($id);
        $form = $this->createForm(TherapieType::class, $res);
        $form->add("Modifier",SubmitType::class
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listTherapie');
        }
        return $this->render('therapie/modifierTherapie.html.twig', [
            'our_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimerTherapie/{id}", name="supprimerTherapie" )
     * @Method("DELETE")
     */
    public function supprimerTherapie(Therapie $id)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listTherapie");

    }
    /**
     * @Route("/listTherapie", name="listTherapie")
     */
    public function listTherapie()
    {

        $Therapies= $this->getDoctrine()->getRepository(Therapie::class)->findAll();
        return $this->render("therapie/listTherapie.html.twig",array('Therapie'=>$Therapies));
    }







    /**
     * @Route("/listthclient", name="listthclient")
     */
    public function listthclient()
    {

        $Propoacts= $this->getDoctrine()->getRepository(Therapie::class)->findAll();
        return $this->render("Activite/afficherclientActivite.html.twig",array('thclient'=>$Propoacts));
    }

    /**
     * @Route("/detailthclient/{id}", name="detailthclient")
     */
    public function detailthclient(Therapie $id)
    {

        $Propoacts= $this->getDoctrine()->getRepository(Therapie::class)-> findBy(['id'=>$id->getId()]);
        return $this->render("therapie/detailthclient.html.twig",array('thclient'=>$Propoacts));
    }


/**
* @Route("/AjouterNoteth/{idact}/{iduser}/{v}", name="AjouterNoteth")
*/
    public function AjouterNoteth($idact,GetUser $user,$v,SessionInterface $session)
    {
        $s = $this->getDoctrine()->getRepository(Therapie::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationtherapie::class)->findOneBy(array('idTherapie'=>$s,'idClient'=>$u));
            $r->setRating($v);
            $em->flush();
            //return $this->json(['moyenne'=>$s->NoteSujetMoyenne(),'note'=>$v],200);
            return $this->redirectToRoute("listactclient");

        }
        /*   else
           {
               $em = $this->getDoctrine()->getManager();
               $note = new Participationactivte();
               $note->setIdClient($u);
               $note->setIdActivite($s);
               $note->setRating($v);
               $em->persist($note);
               $em->flush();
              // return $this->json(['moyenne'=>$s->NoteSujetMoyenne(),'note'=>$v],200);
               return $this->redirectToRoute("article");

           }*/

    }
    /**
     * @Route("/aimerth/{idact}/{iduser}/{v}", name="aimerth")
     */
    public function aimerth($idact,GetUser $user,$v,SessionInterface $session)
    {
        $s = $this->getDoctrine()->getRepository(Therapie::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationtherapie::class)->findOneBy(array('idTherapie'=>$s,'idClient'=>$u));
            $r->setAime($v);
            $em->flush();
            //return $this->json(['moyenne'=>$s->NoteSujetMoyenne(),'note'=>$v],200);
            return $this->redirectToRoute("listactclient");

        }}




}
