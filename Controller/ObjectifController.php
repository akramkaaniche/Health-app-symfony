<?php

namespace App\Controller;

use App\Entity\Objectif;
use App\Entity\Suivi;
use App\Entity\User;
use App\Form\ObjectifType;
use App\Form\SuiviType;
use App\Repository\CalendarRepository;
use App\Repository\ObjectifRepository;
use App\Repository\SuiviRepository;
use App\Services\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use phpDocumentor\Reflection\Type;
use PhpParser\Builder\Property;

class ObjectifController extends AbstractController
{
    /**
     * @Route("/agenda", name="agenda")
     */
    public function index(ObjectifRepository $calendar)
    {
        $events =$calendar->findAll();
        foreach ($events as $event) {
            $objs[] = [
                'id' => $event->getId(),
                'start' => $event->getDatedebut(),
                'end' => $event->getDateFin(),
                'title' => $event->getDescription(),
                'backgroundColor' => '#FcFc3',
                'borderColor' => '#FFFFc3',
                'textColor' => '#FFFFFF',
                'allDay' => '0'
            ];

        }
        $data = json_encode($objs);
        return $this->render('objectif/Agenda.html.twig', compact('data'));
    }



    /**
     * @Route("/objectifs", name="objectifs")
     */
    public function listObjectifs()
    {

        $res= $this->getDoctrine()->getRepository(Objectif::class)->findAll();
        return $this->render("objectif/index.html.twig",array('objectifs'=>$res));
    }
    /**
     * @Route("/mesObjectifs", name="mesObjectifs")
     */
    public function afficherObjectifs(Request $request)
    {
        $res= $this->getDoctrine()->getRepository(Objectif::class)->findAll();
        if($request->isMethod("POST")){
            $desc =$request->get('description');
            $res= $this->getDoctrine()->getRepository(Objectif::class)->findBy(array('description'=>$desc));
        }

        return $this->render("objectif/afficherObjectif.html.twig",array('objectifs'=>$res));
    }
    /**
     * @Route("/afficherDetailsObjectif/{id}", name="afficherDetailsObjectif")
     */
    public function afficherDetailsObjectif(SuiviRepository $suivRepo, ObjectifRepository $objRepo,Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $objectifsss= $this->getDoctrine()->getRepository(Objectif::class)->find($id);

        $res = $em->getRepository(Objectif::class)->find($id);
        $suivis= $this->getDoctrine()->getRepository(Suivi::class)->findBy(array('idobjectif'=>$id));
        //$suivis = $suivRepo->findAll();
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


        return $this->render('objectif/afficherDetailsObjectif.html.twig', [
            'objectif' => $objectifsss,
            'suiviValeur' => json_encode($suiviValeur),
            'suiviCouleur' => json_encode($suiviCouleur),
            'suiviCount' => json_encode($suiviCount),
            'objCount' => json_encode($objCount),
            'dates' => json_encode($dates)
        ]);
    }


   /* public function add(Request $request)
    {

        $res = new Objectif();
        $objectif = $this->getDoctrine()->getRepository(Objectif::class)->findAll();
        $form = $this->createForm(ObjectifType::class, $res);
        $form->add("Ajouter objectif", SubmitType::class, ['label' => 'Ajouter objectif']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($res);
            $em->flush();
            $this->addFlash('success', 'Objectif ajouté avec succès');
            return $this->redirectToRoute("mesObjectif");
        }
        return $this->render('objectif/ajouterObjectif.html.twig', [
            'form' => $form->createView()
        ]);
    } */

    /**
     * @Route("/modifierObjectif/{id}", name="modifierObjectif")
     */
    public function modifierObjectif(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $objectif= $this->getDoctrine()->getRepository(Objectif::class)->findAll();

        $res = $em->getRepository(Objectif::class)->find($id);
        $form = $this->createForm(ObjectifType::class, $res);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('success', 'Objectif modifié avec succès');
            return $this->redirectToRoute('mesObjectifs');
        }
        return $this->render('objectif/modifierObjectif.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/ajouterObjectif", name="ajouterObjectif")
     */
    public function ajouterObjectif(Request $request, GetUser $user)
    {
        $res= new Objectif();
        $form= $this->createForm(ObjectifType::class,$res);
        $res->setIdclient($user->Get_User());
        $res->setMailchecked(1);
        $res->setImage('default.png');
        $res->setDateFin('2021-05-10');
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($res);
            $em->flush();
            return $this->redirectToRoute("mesObjectifs");
        }
        return  $this->render("objectif/ajouterObjectif.html.twig",array('form'=>$form->createView()));
    }
    /**
     * @Route("/supprimerObjectif/{id}", name="supprimerObjectif" )
     * @Method("DELETE")
     */
    public function supprimerObjectif(Objectif $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("mesObjectifs");

    }

    /**
     * @Route("/triObjectifDesc", name="triObjectifDesc")
     */
    public function triObjectifDesc()
    {

        $res= $this->getDoctrine()->getRepository(Objectif::class)->listObjOrderByDesc();
        return $this->render("objectif/AfficherObjectif.html.twig",array('objectifs'=>$res));
    }

    /**
     * @Route("/triObjectifRep", name="triObjectifRep")
     */
    public function triObjectifRep()
    {

        $res= $this->getDoctrine()->getRepository(Objectif::class)->listObjOrderByRep();
        return $this->render("objectif/AfficherObjectif.html.twig",array('objectifs'=>$res));
    }

    /**
     * @Route("/triObjectifDate", name="triObjectifDate")
     */
    public function triObjectifDate()
    {

        $res= $this->getDoctrine()->getRepository(Objectif::class)->listObjOrderByDate();
        return $this->render("objectif/AfficherObjectif.html.twig",array('objectifs'=>$res));
    }


}
