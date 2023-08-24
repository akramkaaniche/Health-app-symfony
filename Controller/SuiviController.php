<?php

namespace App\Controller;

use App\Entity\Suivi;
use App\Entity\Objectif;
use App\Form\SuiviType;
use App\Repository\ObjectifRepository;
use App\Repository\SuiviRepository;
use App\Services\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class SuiviController extends AbstractController
{
    /**
     * @Route("/suivi", name="suivi")
     */
    public function index(): Response
    {
        return $this->render('suivi/index.html.twig', [
            'controller_name' => 'SuiviController',
        ]);
    }

    /**
     * @Route("/suiviObjectif/{id}", name="suiviObjectif")
     */
    public function suiviObjectif(Request $request, $id, GetUser $user)
    {
        $res= new Suivi();
        $objectif= $this->getDoctrine()->getRepository(Objectif::class)->find($id);
        $res->setIdobjectif($objectif);
        $res->setIdclient($user->Get_User());
        $form= $this->createForm(SuiviType::class,$res);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($res);
            $em->flush();
            return $this->redirectToRoute("mesObjectifs");
        }
        return  $this->render("objectif/suiviObjectif.html.twig", [
            'form' => $form->createView(),
            'objectif' => $objectif

        ]);
    }

    /**
     * @Route("/statObjectif", name="statObjectif")
     */
    public function statistiques(SuiviRepository $suivRepo, ObjectifRepository $objRepo,Request $request)
    {
        $suivis = $suivRepo->findAll();
        $suiviCount=[];
        $suiviValeur=[];
        $suiviCouleur=[];
        foreach ($suivis as $suivi){
            $suiviValeur[] = $suivi->getValeur();
            $suiviCount[] =$suivi->getDate();
            $suiviCouleur[] = $suivi->getColor();
        }

        $objectifs = $objRepo->countByDate();
        $dates =[];
        $objCount=[];

        foreach ($objectifs as $objectif){
            $dates[]= $objectif['datedebut'];
            $objCount[] = $objectif['count'];
        }

        return $this->render('suivi/stats.html.twig', [
            'suiviValeur' => json_encode($suiviValeur),
            'suiviCouleur' => json_encode($suiviCouleur),
            'suiviCount' => json_encode($suiviCount),
            'objCount' => json_encode($objCount),
            'dates' => json_encode($dates)
        ]);
    }
    /**
     * @Route("/supprimerSuivis/{id}", name="supprimerSuivis" )
     * @Method("DELETE")
     */
    public function supprimerSuivis(Objectif $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $res= $this->getDoctrine()->getRepository(Suivi::class)->findBy(array('idobjectif'=>$id));
        $em=$this->getDoctrine()->getManager();
        foreach($em as $suivi)
        {
            $em->remove($suivi);
        }
        $em->flush();
        return $this->redirectToRoute("mesObjectifs");

    }
}
