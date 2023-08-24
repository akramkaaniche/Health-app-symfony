<?php

namespace App\Controller;
use App\Entity\Challenge;
use App\Entity\Participationchallenge;
use App\Entity\Classement;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;



class ClassementsController extends AbstractController
{
      /**
     *@Route("/classementMobile",name="classementMobile")
     */
    public function home(NormalizerInterface $NormalizerInterface): Response
  {
    //récupérer tous les classements de la table classement de la BD
    // et les mettre dans le tableau $articles
    $pos=0;
    $classements= $this->getDoctrine()->getRepository(Classement::class)->ClassementOrderByNbPoints();
   
    foreach($classements as $classement)
    {
      $pos++;
      
      $classement->setPosition($pos);

    }    
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($classement);
    $entityManager->flush();

    $json =$NormalizerInterface->normalize($classements,'json',['groups'=>'classements']);
        return new Response (json_encode($json));

       
  }
}
