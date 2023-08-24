<?php

namespace App\Controller;

use App\Entity\Objectif;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ObjectifApiController extends AbstractController
{
    /**
     * @Route("/objectif/api", name="objectif_api")
     */
    public function index(): Response
    {
        return $this->render('objectif_api/index.html.twig', [
            'controller_name' => 'ObjectifApiController',
        ]);
    }

    /**
     * @Route("/api/mesObjectifs", name="/api/mesObjectifs")
     */
    public function listObjectifs(NormalizerInterface $Normalizer)
    {

        $res= $this->getDoctrine()->getRepository(Objectif::class);
        $objectifs= $res->findAll();
        $jsonContent = $Normalizer->normalize($objectifs, 'json', ['groups'=>'post:read']);
        return new Response((json_encode($jsonContent)));
    }
    /**
     * @Route("/api/ajouterObjectif", name="/api/ajouterObjectif")
     */
    public function ajouterObjectif(Request $request, NormalizerInterface $normalizer)
    {
        $objectif= new Objectif();
        $em = $this->getDoctrine()->getManager();
        $objectif->setDescription($request->get('description'));
        $objectif->setReponse($request->get('reponse'));
        $objectif->setDatedebut($request->get('dateDebut'));
        $objectif->setDuree($request->get('duree'));
        $em->persist($objectif);
        $em->flush();
        $jsonContent = $normalizer->normalize($objectif, 'json', ['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/modifierObjectif/{id}", name="/api/modifierObjectif")
     */
    public function modifierObjectif(Request $request, $id, NormalizerInterface $normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $objectif = $em->getRepository(Objectif::class)->find($id);
        $objectif->setDescription($request->get('description'));
        $objectif->setReponse($request->get('reponse'));
        $objectif->setDatedebut($request->get('dateDebut'));
        $objectif->setDuree($request->get('duree'));
        $em->flush();
        $jsonContent =$normalizer->normalize($objectif, 'json',['groups'=>'post:read']);
        return new Response("Objectif modifie avec succes".json_encode($jsonContent));
    }

    /**
     * @Route("/api/supprimerObjectif/{id}", name="/api/supprimerObjectif" )
     */
    public function supprimerObjectif(Objectif $id, Request $request, NormalizerInterface $normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $objectif= $em->getRepository(Objectif::class)->find($id);
        $em->remove($objectif);
        $em->flush();
        $jsonContent = $normalizer->normalize($objectif, 'json',['groups'=>'post:read']);
        return new Response("Objectif supprime avec succes".json_encode($jsonContent));
    }
}
