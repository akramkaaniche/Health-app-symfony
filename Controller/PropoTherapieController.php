<?php

namespace App\Controller;

use App\Entity\Proptherapie;
use App\Entity\Therapie;
use App\Form\MailObjectifType;
use App\Form\TherapiePropoType;
use App\Form\TherapieType;
use App\Services\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class PropoTherapieController extends AbstractController
{
    /**
     * @Route("/propo/therapie", name="propo_therapie")
     */
    public function index(): Response
    {
        return $this->render('propo_therapie/index.html.twig', [
            'controller_name' => 'PropoTherapieController',
        ]);
    }



/**
 * @Route("/ajouterPropoTherapie", name="ajouterPropoTherapie")
 */

public function newPropoTherapie(Request $request,GetUser $user)
{

    $PropoTherapie = new PropTherapie();
    $form = $this->createForm(TherapiePropoType::class,$PropoTherapie);
    $PropoTherapie->setIdcoach($user->Get_User());
    $form->add("Ajouter", SubmitType::class);
    $em = $this->getDoctrine()->getManager();

    $form->handleRequest($request);
    if ($form->isSubmitted()&& $form->isValid()) {
        $em->persist($PropoTherapie);
        $em->flush();
        return $this->redirectToRoute('ajouterPropoTherapie');
    }
    return    $this->render("propo_therapie/index.html.twig",['our_form'=>$form->createView()]);

}

/**
 * @Route("/modifierPropoTherapie/{id}", name="modifierPropoTherapie")
 */
public function modifierPropoTherapie(Request $request, $id)
{
    $em=$this->getDoctrine()->getManager();
    $PropoTherapie= $this->getDoctrine()->getRepository(Proptherapie::class)->findAll();

    $res = $em->getRepository(Proptherapie::class)->find($id);
    $form = $this->createForm(TherapiePropoType::class, $res);
    $form->add("Modifier",SubmitType::class
    );

    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
        $em->flush();
        return $this->redirectToRoute('modifierPropoTherapie');
    }
    return $this->render('propo_therapie/modifierPropoTherapie.html.twig', [
        'our_form' => $form->createView()
    ]);
}

/**
 * @Route("/supprimerPropoTherapie/{id}", name="supprimerPropoTherapie" )
 * @Method("DELETE")
 */
public function supprimerPropoTherapie(Proptherapie $id)
{
    $em=$this->getDoctrine()->getManager();
    $em->remove($id);
    $em->flush();
    return $this->redirectToRoute("listPropoTherapie");

}
/**
 * @Route("/listPropoTherapie", name="listPropoTherapie")
 */
public function listPropoTherapie()
{

    $PropoTherapies= $this->getDoctrine()->getRepository(Proptherapie::class)->findAll();
    return $this->render("propo_therapie/listPropoTherapie.html.twig",array('PropoTherapie'=>$PropoTherapies));
}






    /**
     * @Route("/approuverth/{id}", name="approuverth")
     */
    public function approuverth(Proptherapie $id)
    {
        $Propoacts=new Proptherapie();
        $Propoacts= $this->getDoctrine()->getRepository(Proptherapie::class)-> find($id);
        $actapprouver=new Therapie();

        $actapprouver->setDate( $Propoacts->getDate());
        $actapprouver->setSujet( $Propoacts->getSujet());
        $actapprouver->setId( $Propoacts->getId());
        $actapprouver->setIdcoach( $Propoacts->getIdcoach());
        $actapprouver->setNombremax( $Propoacts->getNombremax());
        $actapprouver->setLieu( $Propoacts->getLieu());

        $em = $this->getDoctrine()->getManager();
        $em->persist($actapprouver);
        $em->flush();
        $em1=$this->getDoctrine()->getManager();
        $em1->remove($id);
        $em1->flush();
        return $this->redirectToRoute("listPropoTherapie");



    }











}
