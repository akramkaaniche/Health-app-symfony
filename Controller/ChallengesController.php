<?php

namespace App\Controller;
use App\Entity\Challenge;
use App\Entity\Participationchallenge;
use App\Entity\Classement;

use App\Services\GetUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ChallengesController extends AbstractController
{
    /**
     * @Route("/challengesMobile", name="challengesMobile")
     */
    public function homeClientMobile(NormalizerInterface $NormalizerInterface): Response
    {
        $challenges= $this->getDoctrine()->getRepository(Challenge::class)->findBy(['type'=>'valide']);
        $json =$NormalizerInterface->normalize($challenges,'json',['groups'=>'challenges']);
        return new Response (json_encode($json));
    }

    /**
    * @Route("/MyChallengesMobiles/{userId}", name="MyChallengesMobiles")
    */
    public function MesChallengesMobile(NormalizerInterface $NormalizerInterface,String $userId)//string $user
    {

   
      $participations= $this->getDoctrine()->getRepository(Participationchallenge::class)->findBy(['idClient' => $userId ]);//$user
      $challengerejoints=array ();
      foreach($participations as $participation)
      {
        $challengerejoint= $this->getDoctrine()->getRepository(Challenge::class)-> findOneBy(['id' => $participation->getIdChallenge()]);
       
       
        array_push($challengerejoints,$challengerejoint);
      }
        $json =$NormalizerInterface->normalize($challengerejoints,'json',['groups'=>'challenges']);
        return new Response (json_encode($json));
        
                    
    } 

    /**
    * @Route("/JsonfinirChallenge/{id}/{user}", name="JsonfinirChallenge")
    */
    public function finirChallenge(Challenge $ch,NormalizerInterface $normalizer,string $user)//,string $user
    {
     
       $id=$ch->getId();

      
     // $participation=new Participationchallenge();
      $challenge= $this->getDoctrine()->getRepository(Challenge::class)-> find($id);
      $niveau=$challenge->getIdNiveau();
      $cl= $this->getDoctrine()->getRepository(Classement::class)-> findOneBy(['idClient' => $user , 'idNiveau'=> $niveau ]);
      $nb=$cl->getNbPoints()+25;
      $participation= $this->getDoctrine()->getRepository(Participationchallenge::class)->findOneBy(['idChallenge' => $id,'idClient' => $user]);//,'idClient' => '87654321'] 
      
       
     $entityManager = $this->getDoctrine()->getManager();
     $entityManager->remove($participation);
     $entityManager->flush();
      
      

      $nb2=$challenge->getNbParticipants()-1;
      $challenge->setNbParticipants($nb2);
      $entityManager3 = $this->getDoctrine()->getManager();
      $entityManager3->persist($challenge);
      $entityManager3->flush();


      $cl->setNbPoints($nb);
      $entityManager2 = $this->getDoctrine()->getManager();
      $entityManager2->persist($cl);
      $entityManager2->flush();

      
      $json =$normalizer->normalize($challenge,'json');
      $this->redirectToRoute("MyChallengesMobiles");
        return new Response (json_encode($json));

                    
    } 
     /**
     * @Route("/JsonrejoindreChallenge/{id}/{user}", name="JsonrejoindreChallenge")
     */
    public function rejoindreChallenge(Challenge $id,NormalizerInterface $normalizer,String $user)//user
    {
        $challenge=new Challenge();
        
        $participation=new Participationchallenge();
        $challenge= $this->getDoctrine()->getRepository(Challenge::class)-> find($id);
        $niveau=$challenge->getIdNiveau();
        
        //$user=$userr->Get_User()->getId();
       
        $participation->setIdChallenge($challenge->getId());
        $participation->setIdClient($user);
        $participation->setEtat('joined');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($participation);
        $entityManager->flush();
        $cl= $this->getDoctrine()->getRepository(Classement::class)-> findOneBy(['idClient' => $user , 'idNiveau'=> $niveau  ]);
        $nb=$challenge->getNbParticipants()+1;
        

        if($cl)
        {

          $challenge->setNbParticipants($nb);
          $entityManager3 = $this->getDoctrine()->getManager();
          $entityManager3->persist($challenge);
          $entityManager3->flush();
        }
        else{
          $cl =new Classement();
          $cl->setIdClient($user);
          $cl->setIdNiveau($challenge->getIdNiveau());
          $cl->setPosition(0);
          $cl->setNbPoints(0);
          $entityManager2 = $this->getDoctrine()->getManager();
          $entityManager2->persist($cl);
          $entityManager2->flush();
          $challenge->setNbParticipants($nb);
          $entityManager3 = $this->getDoctrine()->getManager();
          $entityManager3->persist($challenge);
          $entityManager3->flush();

        }
        $this->redirectToRoute("challengesMobile");
        $json =$normalizer->normalize($challenge,'json');

        
        return new Response (json_encode($json));
    }  

   
}
