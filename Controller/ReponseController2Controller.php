<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Repentraide;
use App\Entity\Entraide;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\normalizeInterface;


class ReponseController2Controller extends AbstractController
{
    /**
     * @Route("/reponse/controller2", name="reponse_controller2")
     */
    public function index(): Response
    {
        return $this->render('reponse_controller2/index.html.twig', [
            'controller_name' => 'ReponseController2Controller',
        ]);
    }


    /**
     * @Route("/AllReplies", name="AllReplies")
     */

    public function AllReplies(NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Repentraide::class);
        $reponses = $repository->findAll();
        $jsonContent = $Normalizer->normalize($reponses, 'json', ['groups' => 'post:read']);
        return $this->render('reponse/allRepliesJSON.html.twig',
            ['data' => $jsonContent,
            ]);

        //return new Response(json_encode($jsonContent));
    }





//recuperation d'une reponse selon son id
    /**
     * @Route("/Reply/{id_question}", name="Reply")
     */

    public function RepId(Request $request,NormalizerInterface $Normalize,$id_question)
    {
        $em = $this->getDoctrine()->getManager();
        $ent = $em->getRepository(Entraide::class)->find($id_question);
        $reponse = $em->getRepository(Repentraide::class)->findBy(array( 'idQuestion'=>$ent));
        $jsonContent = $Normalize->normalize($reponse, 'json', ['groups'=>'post:read']);

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/getQuesionById/{id}", name="question")
     */
    public function getQuestionById(Request $request, $id, NormalizerInterface $Normalize)
    {
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(Entraide::class)->find($id);


        $jsonContent = $Normalize->normalize($question,'json', ['groups'=>'post:read']);

        return new Response(json_encode($jsonContent));

    }

    //Ajout d'un etudiant

  /**
     * @Route("/addReplyJSON/new/{id}/{user}", name="addReplyJSON")
     */

   public function addReplyJSON(Request $request, NormalizerInterface  $Normalizer, Entraide $id, User $user)
    {
        $em= $this->getDoctrine()->getManager();
        $entraide=$em->getRepository(Entraide::class)->find($id);
        $reponse = new Repentraide();
        $reponse->setIdQuestion($entraide);
        $reponse->setReponse($request->get('reponse'));
        $user1=$em->getRepository(User::class)->find($user);
        $reponse->setIdUser($user1);
        $reponse->setCreatedAt(new \DateTime('now'));


        $em->persist($reponse);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reponse, 'json', ['groups'=>'post:read']);
        return
            new Response(json_encode($jsonContent));;


    }
    //addReplyJSON/new?id_question=49&reponse=testajoutreply&id_user=
    //87654312
    //Argument 1 passed to App\Entity\Repentraide::setIdQuestion() must be an instance of App\Entity\Entraide, string given

    /**
     * @Route("/addQuestionJson/{user}", name="addQuestionJson")
     */

    public function addQuestionJson(Request $request, NormalizerInterface  $Normalizer,User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $reponse = new Entraide();
        $reponse->setQuestion($request->get('question'));
        $reponse->setCategorie($request->get('categorie'));
        $reponse->setEmail("nour");
        $user1=$em->getRepository(User::class)->find($user);
        if($user1)
        $reponse->setIdUser($user1);

        $reponse->setDate(new \DateTime('now'));

        $em->persist($reponse);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reponse, 'json', ['groups'=>'post:read']);
        return
            new Response(json_encode($jsonContent));;


    }

    //modification d'un etudiant
    /**
     * @Route("/updateReplyJSON/{id}", name="updateReplyJSON")
     */

    public function updateReplyJSON(Request $request, NormalizerInterface $Normalizer, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $reponse= $em->getRepository(Repentraide::class)->find($id);

        $reponse->setReponse($request->get('reponse'));
       // $reponse->setCreatedAt($request->get('created_at'));
      //  $reponse->setIdQuestion($request->get('id_question'));
      //  $reponse->setIdUser($request->get('id_user'));

        $em->flush();
        $jsonContent = $Normalizer->normalize($reponse, 'json', ['groups'=>'post:read']);
        return
            new Response("modification faite avec suuces");



    }

    /**
     * @Route("/updateQuestionJSON/{id}", name="updateQuestionJSON")
     */

    public function updateQuestionJSON(Request $request, NormalizerInterface $Normalizer, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $reponse= $em->getRepository(Entraide::class)->find($id);

        $reponse->setQuestion($request->get('question'));
        $reponse->setCategorie($request->get('categorie'));
        // $reponse->setCreatedAt($request->get('created_at'));
        //  $reponse->setIdQuestion($request->get('id_question'));
        //  $reponse->setIdUser($request->get('id_user'));

        $em->flush();
        $jsonContent = $Normalizer->normalize($reponse, 'json', ['groups'=>'post:read']);
        return
            new Response("modification faite avec suuces");



    }

    //suppression d'un etudiant

    /**
     * @Route("/deleteReplyJSON/{id}", name="deleteReplyJSON")
     */
    public function deleteReplyJSON(Request $request, NormalizerInterface $Normalizer, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $reponse= $em->getRepository(Repentraide::class)->find($id);
        $em->remove($reponse);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reponse, 'json', ['groups'=>'post:read']);
         return
            new Response("suppression faite avec suuces");

    }

    /**
     * @Route("/deleteQuestionJSON/{id}", name="deleteQuestionJSON")
     */
    public function deleteQuestionJSON(Request $request, NormalizerInterface $Normalizer, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $question= $em->getRepository(Entraide::class)->find($id);
        $em->remove($question);
        $em->flush();
        $jsonContent = $Normalizer->normalize($question, 'json', ['groups'=>'post:read']);
        return
            new Response("suppression faite avec suuces");

    }

    /**
     * @Route("/AllQuestions", name="AllQuestions")
     */

    public function AllQuestions(NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Entraide::class);
        $reponses = $repository->findAll();
        $jsonContent = $Normalizer->normalize($reponses, 'json', ['groups' => 'post:read']);
       // return $this->render('reponse/allRepliesJSON.html.twig',
        //    ['data' => $jsonContent,
        //    ]);

        return new Response(json_encode($jsonContent));
    }



}






