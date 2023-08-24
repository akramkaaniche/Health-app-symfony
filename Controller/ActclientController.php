<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Participationactivte;
use App\Entity\Therapie;
use App\Entity\User;
use App\Services\GetUser;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use anlutro\BulkSms\Laravel\BulkSms;
class ActclientController extends AbstractController
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
     * @Route("/rejoindreact/{id}", name="rejoindreact")
     */
    public function rejoindreact(Activite $id,GetUser $userr)
    {
        $Propoacts=new Activite();
        $Propoacts= $this->getDoctrine()->getRepository(Activite::class)-> find($id);
        $actrejoindre=new participationactivte();
$user=new User();
$user->setId($userr->Get_User()->getId());
        $actrejoindre->setIdActivite($Propoacts);
        $actrejoindre->setIdClient($user);

        $em = $this->getDoctrine()->getManager();
        $em->merge($actrejoindre);
        $em->flush();

        return $this->redirectToRoute("listactclient");



    }
    /**
     * @Route("/AddLike/{idact}/{iduser}", name="addLike")
     */
    public function addLike($idact,$iduser)
    {
        $c = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $x = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$c,'User'=>$u,'value'=>'dislike'));
        $em = $this->getDoctrine()->getManager();
        if (empty($x))
        {
            $l = new Participationactivte();
            $l->setIdActivite($c);
            $l->setIdClient($u);
            $l->setAime('like');
            $em->persist($l);
            $em->flush();
        }
        else
        {
            $em->remove($x);
            $l = new Participationactivte();
            $l->setIdActivite($c);
            $l->setIdClient($u);
            $l->setAime('like');
            $em->persist($l);
            $em->flush();
        }
        return $this->redirectToRoute("listactclient");
    }



    /**
     * @Route("/DeleteLike/{idact}/{iduser}", name="DeleteLike")
     */
    public function DeleteLike($idact,$iduser)
    {
        $c = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $l = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$c,'User'=>$u,'value'=>'like'));
        $em = $this->getDoctrine()->getManager();
        $em->remove($l);
        $em->flush();
        return $this->redirectToRoute("listactclient");
    }
    /**
     * @Route("/AddDislike/{idact}/{iduser}", name="addDislike")
     */
    public function addDislike($idact,$iduser)
    {
        $c = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $x = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$c,'User'=>$u,'value'=>'like'));
        $em = $this->getDoctrine()->getManager();
        if (empty($x))
        {
            $l = new Participationactivte();
            $l->setIdActivite($c);
            $l->setIdClient($u);
            $l->setAime('dislike');
            $em->persist($l);
            $em->flush();
        }
        else
        {
            $em->remove($x);
            $l = new Participationactivte();
            $l->setIdActivite($c);
            $l->setIdClient($u);
            $l->setAime('dislike');
            $em->persist($l);
            $em->flush();
        }
        return $this->redirectToRoute("listactclient");
    }

    /**
     * @Route("/DeleteDislike/{idact}/{iduser}", name="DeleteDislike")
     */
    public function DeleteDislike($idact,$iduser)
    {
        $c = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $l = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$c,'User'=>$u,'value'=>'dislike'));
        $em = $this->getDoctrine()->getManager();
        $em->remove($l);
        $em->flush();
        return $this->redirectToRoute("listactclient");
    }
    /**
     * @Route("/notif", name="notif")
     */
    public function notif(FlashyNotifier $flashy)
    {


        $flashy->success('Event created!', 'http://your-awesome-link.com');

        return $this->redirectToRoute('about');
    }
    /**
     * @Route("/about", name="about")
     */
    public function about()
    {


        $Propoacts= $this->getDoctrine()->getRepository(Activite::class)->findAll();
        $Propoact= $this->getDoctrine()->getRepository(Therapie::class)->findAll();

        return $this->render("Activite/afficherclientActivite.html.twig",array('actclient'=>$Propoacts,'thclient'=>$Propoact));  }




}
