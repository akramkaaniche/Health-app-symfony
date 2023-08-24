<?php

namespace App\Controller;

use App\Entity\Repentraide;
use App\Form\RepentraideType;
use App\Entity\Entraide;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;





class ReponseController extends AbstractController
{
    /**
     * @Route("/reponse", name="reponse")
     */
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }


    /**
     * @Route("/ajouterreponse/{idQuestion}", name="ajouterreponse")
     */
    public function ajouterreponse(Request $request, $idQuestion): Response
    {
        $res = new repentraide();
        $res->setCreatedAt(new \DateTime());

        $user= $this->getDoctrine()->getRepository(User::class)-> find(12345673);
        $res->setIdUser($user);
        $question= $this->getDoctrine()->getRepository(Entraide::class)-> find($idQuestion);
        $res->setIdQuestion($question);
        $form = $this->createForm(RepentraideType::class, $res);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($res);
            $em->flush();
            return $this->redirectToRoute("ajouterentraide");
        }
        return $this->render("reponse/index.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/list", name="listeReponse")
     */
    public function listReponse(Request $request)
    {

        $idQ=$request->query->get('idQuestion');
        $qs=$this->getDoctrine()->getRepository(Entraide::class)->findOneBy(['id'=>$idQ]);
        $res1= $this->getDoctrine()->getRepository(Repentraide::class)->findBy(['idQuestion'=>$idQ]);
        $res = new repentraide();
        $res->setCreatedAt(new \DateTime());
        $user= $this->getDoctrine()->getRepository(User::class)-> find(12345673);
        $res->setIdUser($user);
        $question= $this->getDoctrine()->getRepository(Entraide::class)-> find($idQ);
        $res->setIdQuestion($question);
        $form = $this->createForm(RepentraideType::class, $res);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($res);
            $em->flush();
            return $this->redirectToRoute("listeReponse",['idQuestion'=>$idQ]);
        }
        return $this->render("listeReponse.html.twig",array('listerep'=>$res1,'qs'=>$qs,'form'=>$form->createView() ));
    }


    /**
     * @Route("/supprimerreponsefront", name="supprimerreponsefront" )
     * @Method("DELETE")
     */
    public function supprimerreponsefront(Request $request)
    {

        $idR=$request->query->get('id');
        $em=$this->getDoctrine()->getManager();
        $qs=$this->getDoctrine()->getRepository(Repentraide::class)->findOneBy(['id'=>$idR]);
        $em->remove($qs);
        $em->flush();
        return $this->redirectToRoute("listeReponse");
    }

    /**
     * @Route("/modifierreponse/{id}", name="modifierreponse")
     * * @Method("UPDATE")
     */
    public function modifierreponse( $id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $res1 = $this->getDoctrine()->getRepository(Repentraide::class)->findAll();

        $res = $em->getRepository(Repentraide::class)->find($id);

        $form=$this->createForm(RepentraideType::class, $res);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('listeReponse');
        }

        return $this->render('Reponse/modifiereponse.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/afficherreponse", name="afficherreponse")
     */
    public function afficherreponseback()
    {

        $res = $this->getDoctrine()->getRepository(Repentraide::class)->findAll();
        return $this->render("reponse/afficherreponseback.html.twig", array('repentraides' => $res));
    }

    /**
     * @Route("/supprimerreponse/{id}", name="supprimerreponse" )
     * @Method("DELETE")
     */
    public function supprimerReponse(Repentraide $id)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("afficherreponse");

    }

}
