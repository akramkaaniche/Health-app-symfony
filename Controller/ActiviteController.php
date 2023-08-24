<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Participationactivte;
use App\Entity\Propoact;
use App\Entity\Therapie;
use App\Data\SearchData;
use App\Form\ActivitePropoType;
use App\Form\SearchForm;

use App\Entity\User;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Services\GetUser;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ActiviteController extends AbstractController
{
    /**
     * @Route("/activite", name="activite")
     */
    public function index(): Response
    {

        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',

        ]);
    }

    /**
     * @Route("/ajouterActivite", name="ajouterActivite")
     */

    public function newActivite(Request $request)
    {

        $Activite = new Activite();
        $form = $this->createForm(ActiviteType::class,$Activite);
        $form->add("Ajouter", SubmitType::class);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $em->persist($Activite);
            $em->flush();
            return $this->redirectToRoute("listActivite");
        }
        return    $this->render("Activite/index.html.twig",['our_form'=>$form->createView()]);

    }

    /**
     * @Route("/modifierActivite/{id}", name="modifierActivite")
     */
    public function modifierActivite(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $Activite= $this->getDoctrine()->getRepository(Activite::class)->findAll();

        $res = $em->getRepository(Activite::class)->find($id);
        $form = $this->createForm(ActiviteType::class, $res);
        $form->add("Modifier",SubmitType::class
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listActivite');
        }
        return $this->render('Activite/modifierActivite.html.twig', [
            'our_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimerActivite/{id}", name="supprimerActivite" )
     * @Method("DELETE")
     */
   public function supprimerActivite(Activite $id)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listActivite");

    }
    /**
     * @Route("/listActivite", name="listActivite")
     */
    public function listActivite()
    {

        $Activites= $this->getDoctrine()->getRepository(Activite::class)->findAll();
        return $this->render("Activite/listActivite.html.twig",array('Activite'=>$Activites));
    }












    /**
     * @Route("/ajouterPropoact", name="newPropoact")
     */

    public function newPropoact(Request $request)
    {

        $Propoact = new Propoact();
        $form = $this->createForm(ActivitePropoType::class,$Propoact);
        $form->add("Ajouter", SubmitType::class);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $em->persist($Propoact);
            $em->flush();
            return $this->redirectToRoute("ajouterPropoact");
        }
        return    $this->render("Activite/ajouterpropoact.html.twig",['our_form'=>$form->createView()]);

    }

    /**
     * @Route("/modifierPropoact/{id}", name="modifierPropoact")
     */
    public function modifierPropoact(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $Propoact= $this->getDoctrine()->getRepository(Propoact::class)->findAll();

        $res = $em->getRepository(Propoact::class)->find($id);
        $form = $this->createForm(ActiviteType::class, $res);
        $form->add("update",SubmitType::class
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listPropoact');
        }
        return $this->render('Activite/modifierPropoact.html.twig', [
            'our_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimerPropoact/{id}", name="supprimerPropoact" )
     * @Method("DELETE")
     */
    public function supprimerPropoact(Propoact $id)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listPropoact");

    }
    /**
     * @Route("/listPropoact", name="listPropoact")
     */
    public function listPropoact()
    {

        $Propoacts= $this->getDoctrine()->getRepository(Propoact::class)->findAll();
        return $this->render("Activite/listPropoact.html.twig",array('Propoact'=>$Propoacts));
    }



    /**
     * @Route("/listactclient", name="listactclient")
     */
    public function listactclient()
    {

        $Propoacts= $this->getDoctrine()->getRepository(Activite::class)->findAll();
        $Propoact= $this->getDoctrine()->getRepository(Therapie::class)->findAll();

        return $this->render("Activite/afficherclientActivite.html.twig",array('actclient'=>$Propoacts,'thclient'=>$Propoact));
    }

    /**
     * @Route("/detailactclient/{id}", name="detailactclient")
     */
    public function detailactclient(Activite $id,GetUser $userr)
    {
        $s = $this->getDoctrine()->getRepository(Activite::class)->find($id);
        $user=new User();
       $user->setId($userr->Get_User());
       $u = $this->getDoctrine()->getRepository(User::class)->find($user);


            $r = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$s,'idClient'=>$u));

        $Propoacts= $this->getDoctrine()->getRepository(Activite::class)-> findBy(['id'=>$id->getId()]);
        return $this->render("activite/detailactclient.html.twig",array('actclient'=>$Propoacts ,'clientdet'=>$r));

    }

    /**
     * @Route("/approuveract/{id}", name="approuveract")
     */
    public function approuveract(Propoact $id)
    {
        $Propoacts=new Propoact();
        $Propoacts= $this->getDoctrine()->getRepository(Propoact::class)-> find($id);
        $actapprouver=new Activite();

        $actapprouver->setDate( $Propoacts->getDate());
        $actapprouver->setDescription( $Propoacts->getDescription());
        $actapprouver->setDuree( $Propoacts->getDuree());
        $actapprouver->setId( $Propoacts->getId());
        $actapprouver->setIdcoach( $Propoacts->getIdcoach());
        $actapprouver->setNombremax( $Propoacts->getNombremax());
        $actapprouver->setLieu( $Propoacts->getLieu());
        $actapprouver->setType( $Propoacts->getType());

        $em = $this->getDoctrine()->getManager();
            $em->persist($actapprouver);
            $em->flush();
        $em1=$this->getDoctrine()->getManager();
        $em1->remove($id);
        $em1->flush();
        return $this->redirectToRoute("listPropoact");



    }

    /**
     * @Route("/Like/{idact}/{iduser}", name="Like")
     * @param $idact
     * @param $iduser
     * @param SessionInterface $session
     * @return Response
     */
    public function Like($idact,$iduser,SessionInterface $session) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $Activite = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        //$u = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $u=new User();
        $u->setId("12341231");
        if ($Activite->isLikedBy($u))
        {
            $x = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$Activite,'User'=>$u,'aime'=>'like'));
            $em ->remove($x);
            $em ->flush();
            return $this->json([
                'code'=>200,
                'likes'=>$this->getDoctrine()->getRepository(Participationactivte::class)->count(['idActivite'=>$Activite,'value'=>'like']),
                'dislikes'=>$this->getDoctrine()->getRepository(Participationactivte::class)->count(['idActivite'=>$Activite,'value'=>'dislike']),
                'idact'=>$idact
            ],200);
        }
        elseif ($Activite->isDisLikedBy($u))
        {
            $x = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$Activite,'User'=>$u,'value'=>'dislike'));
            $x->setValue('like');
            $em ->flush();
            return $this->json([
                'code'=>200,
                'likes' => $this->getDoctrine()->getRepository(Participationactivte::class)->count(['idActivite'=>$Activite,'value'=>'like']),
                'dislikes'=>$this->getDoctrine()->getRepository(Participationactivte::class)->count(['idActivite'=>$Activite,'value'=>'dislike']),
                'idact'=>$idact , 'path'=>$session->get('path'),'texte'=>$session->get('texte'),
            ],200);
        }
        $l = new Participationactivte();
        $l->setValue('like');
        $l->setUser($u);
        $l->setActivite($Activite);
        $em->persist($l);
        $em->flush();
        return $this->json([
            'code' => 200,
            'likes' => $this->getDoctrine()->getRepository(Participationactivte::class)->count(['idActivite'=>$Activite,'value'=>'like']),
            'dislikes'=>$this->getDoctrine()->getRepository(Participationactivte::class)->count(['idActivite'=>$Activite,'value'=>'dislike']),
            'idact'=>$idact, 'path'=>$session->get('path'),'texte'=>$session->get('texte'),
        ],200);

    }
    /**
     * @Route("/AjouterNote/{idact}/{iduser}/{v}", name="AjouterNote")
     */
    public function AjouterNote($idact,GetUser $user,$v,SessionInterface $session)
    {
        $s = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$s,'idClient'=>$u));
            $r->setRating($v);
            $em->flush();
            //return $this->json(['moyenne'=>$s->NoteSujetMoyenne(),'note'=>$v],200);
            return $this->redirectToRoute("listactclient");

        }
     /*   else
        {
            $em = $this->getDoctrine()->getManager();
            $note = new Participationactivte();
            $note->setIdClient($u);
            $note->setIdActivite($s);
            $note->setRating($v);
            $em->persist($note);
            $em->flush();
           // return $this->json(['moyenne'=>$s->NoteSujetMoyenne(),'note'=>$v],200);
            return $this->redirectToRoute("article");

        }*/

    }
    /**
     * @Route("/aimerAct/{idact}/{iduser}/{v}", name="aimerAct")
     */
    public function aimerAct($idact,GetUser $user,$v,SessionInterface $session)
    {
        $s = $this->getDoctrine()->getRepository(Activite::class)->find($idact);
        $u = $this->getDoctrine()->getRepository(User::class)->find($user->Get_User());
        {
            $em = $this->getDoctrine()->getManager();

            $r = $this->getDoctrine()->getRepository(Participationactivte::class)->findOneBy(array('idActivite'=>$s,'idClient'=>$u));
            $r->setAime($v);
            $em->flush();
            //return $this->json(['moyenne'=>$s->NoteSujetMoyenne(),'note'=>$v],200);
            return $this->redirectToRoute("listactclient");

        }}
    /**
     * @Route("/searchAct", name="searchAct")
     */

    public function searchAct(ActiviteRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $commande=$repository->rechercher($data);
        return $this->render("activite/findclientActivite.html.twig",array('actclient'=>$commande));

    }

    /**
     * @Route("/filtreAct", name="filtreAct")
     */

    public function filtreAct(ActiviteRepository $repository , Request $request)
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $articles = $repository->findSearch($data);
        return $this->render('activite/filterclientActivite.html.twig', [
            'actclient' => $articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // Configuration for the BotMan WebDriver
        $config = [];

        // Create BotMan instance
        $botman = BotManFactory::create($config);

        // Give the bot some things to listen for.
        $botman->hears('(hello|hi|hey)', function (BotMan $bot) {
            $bot->reply('Hello!');
        });
        $botman->hears('(therapie)', function (BotMan $bot) {
            $bot->reply('Une thérapie de groupe désigne une psychothérapie collective durant laquelle un ou plusieurs thérapeutes traitent plusieurs patients ensemble, réunis en groupe. Le traitement en groupe révélerait des effets positifs qui ne seraient pas obtenus lors de sessions individuelles.');
        });
        $botman->hears('(plus)', function (BotMan $bot) {
            $bot->reply('tu peux rejoindre dés maintenant');
        });

        // Set a fallback
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand.');
        });

        // Start listening
        $botman->listen();

        return new Response();
    }

    /**
     * @Route("/listactclient", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('activite/afficherclientActivite.html.twig');
    }

    /**
     * @Route("/chatframe", name="chatframe")
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('chat_frame.html.twig');
    }




}
