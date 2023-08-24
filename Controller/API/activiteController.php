<?php

namespace App\Controller\API;

use App\Entity\Activite;
use App\Entity\Participationtherapie;
use App\Entity\Participationactivte;

use App\Entity\Therapie;
use App\Entity\User;
use App\Repository\ActiviteRepository;
use App\Services\GetUser;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use MercurySeries\FlashyBundle\FlashyNotifier;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use anlutro\BulkSms\Laravel\BulkSms;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class activiteController extends AbstractController
{
    /**
     * @Route("/actclient", name="actclient")
     */
    public function index(): Response
    {
        return $this->render('actclient/index.html.twig', [
            'controller_name' => 'ActclientController',
        ]);
    }


    /**
     * @Route("/api/listTherapieapi", name="listTherapieapi")
     */
    public function listTherapieapi(NormalizerInterface $normalizer)
    {

        $Therapies= $this->getDoctrine()->getRepository(Therapie::class)->findAll();
        $data=$normalizer->normalize($Therapies,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));

       // return $this->render("therapie/listTherapie.html.twig",array('Therapie'=>$Therapies));
    }


    /**
     * @Route("/api/deleteTherapieapi/{id]", name="deleteTherapieapi")
     */
    public function deleteTherapieapi(NormalizerInterface $normalizer,Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $therapie=$em->getRepository(Therapie::class)->find($id);
        $em->remove( $therapie);
        $em->flush();
        $data=$normalizer->normalize($therapie,'json',['groups'=>'post:read']);
        return new Response("supprimé avec succe".json_encode($data));

    }
    /**
     * @Route("/api/updateTherapieapi/{id]", name="updateTherapieapi")
     */
    public function updateTherapieapi(NormalizerInterface $normalizer,Request $request,$id)
    {

        $em=$this->getDoctrine()->getManager();
        $therapie=$em->getRepository(Therapie::class)->find($id);
        $therapie->setId($request->get('id'));
        $therapie->setSujet($request->get('sujet'));
        $therapie->setDate($request->get('date'));
        $therapie->setLieu($request->get('lieu'));
        $therapie->setNombremax($request->get('nombremax'));
        $therapie->setIdcoach($request->get('idcoach'));
        printf($request->get('idcoach'));

        $em->flush();
        $data=$normalizer->normalize($therapie,'json',['groups'=>'post:read']);
        return new Response("modifié avec succe".json_encode($data));

    }

    /**
     * @Route("/api/therapieidapi/{id}", name="therapieidapi")
     */
    public function therapieidapi(NormalizerInterface $normalizer,Request $request,Therapie $id)
    {

        $em=$this->getDoctrine()->getManager();
        $therapie=$em->getRepository(Therapie::class)->find($id);
        $Propoacts= $this->getDoctrine()->getRepository(Therapie::class)-> findBy(['id'=>$id->getId()]);

        $data=$normalizer->normalize($Propoacts,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));

    }
    /**
     * @Route("/api/ajouterTherapieapi", name="ajouterTherapieapi")
     */
    public function ajouterTherapieapi(NormalizerInterface $normalizer,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $therapie=new Therapie();
        $therapie->setId($request->get('id'));
        $therapie->setSujet($request->get('sujet'));
        $therapie->setDate($request->get('date'));
        $therapie->setLieu($request->get('lieu'));
        $therapie->setNombremax($request->get('nombremax'));
        $therapie->setIdcoach($request->get('idcoach'));
$em->persist($therapie);
        $em->flush();
        $data=$normalizer->normalize($therapie,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));

    }

    /**
     * @Route("/api/rejoindreactapi/{id}/{user}", name="rejoindreactapi")
     */
    public function rejoindreactapi(Therapie $id,user $user,NormalizerInterface $normalizer,Request $request)
    {
        $Propoacts= $this->getDoctrine()->getRepository(Therapie::class)-> findBy(['id'=>$id->getId()]);
        $actrejoindre=new participationtherapie();


        $actrejoindre->setIdTherapie($id->getId());
        $actrejoindre->setIdClient($user);

        $em = $this->getDoctrine()->getManager();
        $em->merge($actrejoindre);
        $em->flush();

        $data=$normalizer->normalize($actrejoindre,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));


    }



    /**
     * @Route("/api/listActiviteapi", name="listActiviteapi")
     */
    public function listActiviteapi(NormalizerInterface $normalizer)
    {

        $Activites= $this->getDoctrine()->getRepository(Activite::class)->findAll();

        $data=$normalizer->normalize($Activites,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));    }



    /**
     * @Route("/api/rejoindreacttapi/{id}/{user}", name="rejoindreacttapi")
     */
    public function rejoindreacttapi(Activite $id,user $user,NormalizerInterface $normalizer,Request $request)
    {
        $Propoacts= $this->getDoctrine()->getRepository(Activite::class)-> findBy(['id'=>$id->getId()]);
        $actrejoindre=new Participationactivte();


        $actrejoindre->setIdActivite($id);
        $actrejoindre->setIdClient($user);

        $em = $this->getDoctrine()->getManager();
        $em->merge($actrejoindre);
        $em->flush();

        $data=$normalizer->normalize($actrejoindre,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));


    }


    /**
     * @Route("/api/actidapi/{id}", name="actidapi")
     */
    public function actidapi(NormalizerInterface $normalizer,Request $request,Activite $id)
    {

        $em=$this->getDoctrine()->getManager();
        $therapie=$em->getRepository(Activite::class)->find($id);
        $Propoacts= $this->getDoctrine()->getRepository(Activite::class)-> findBy(['id'=>$id->getId()]);

        $data=$normalizer->normalize($Propoacts,'json',['groups'=>'post:read']);
        return new Response(json_encode($data));

    }

    /**
     * @Route("/api/AjouterNoteapi/{idact}/{v}/{user}", name="AjouterNoteapi")
     */
    public function AjouterNoteapi($idact,user $user,$v,SessionInterface $session,NormalizerInterface $normalizer,Request $request)
    {
        $s = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        //$u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());

        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$s,'idClient'=>$user));
            $r->setRating($v);
            $em->flush();
            $data=$normalizer->normalize( $r,'json',['groups'=>'post:read']);
            return new Response(json_encode($data));

        }}
        /**
         * @Route("/api/AjouterNotethapi/{idact}/{v}/{user}", name="AjouterNotethapi")
         */
        public function AjouterNotethapi($idact,user $user,$v,SessionInterface $session,NormalizerInterface $normalizer,Request $request)
    {
        $s = $this->getDoctrine()->getRepository(Therapie::class)->find($idact);

      //  $u = $this->getDoctrine()->getRepository(User::class)->find($userr);
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationtherapie::class)->findOneBy(array('idTherapie'=>$s,'idClient'=>$user->getId()));
            $r->setRating($v);
            $em->flush();
            $data=$normalizer->normalize( $r,'json',['groups'=>'post:read']);
            return new Response(json_encode($data));
        }
    }

    /**
     * @Route("/api/aimerActapi/{idact}/{v}/{userr}", name="aimerActapi")
     */
    public function aimerActapi($idact,user $userr,$v,SessionInterface $session,NormalizerInterface $normalizer,Request $request)
    {
        $s = $this->getDoctrine()->getRepository(Activite::class)->find($idact);

     //   $u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$s,'idClient'=>$userr));
            $r->setAime($v);
            $em->flush();
            $data=$normalizer->normalize( $r,'json',['groups'=>'post:read']);
            return new Response(json_encode($data));

        }}
    /**
     * @Route("/api/aimerthapi/{idact}/{v}/{user}", name="aimerthapi")
     */
    public function aimerthapi($idact,user $user,$v,SessionInterface $session,NormalizerInterface $normalizer,Request $request)
    {
        $s = $this->getDoctrine()->getRepository(Therapie::class)->find($idact);

      //  $u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationtherapie::class)->findOneBy(array('idTherapie'=>$s,'idClient'=>$user->getId()));
            $r->setAime($v);
            $em->flush();
            $data=$normalizer->normalize( $r,'json',['groups'=>'post:read']);
            return new Response(json_encode($data));

        }}


    /**
     * @Route("/api/supprimerPropoactapi/{id}/{user}", name="supprimerPropoactapi" )
     *
     */
    public function supprimerPropoact($id,user $user,NormalizerInterface $normalizer,Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $r = $this->getDoctrine()->getRepository(Participationtherapie::class)->findOneBy(array('idTherapie'=>$id,'idClient'=>$user->getId()));

        $em->remove($r);
        $em->flush();
    }
}
