<?php

namespace App\Controller;



use App\Entity\Entraide;
use App\Form\EntraideType;
use App\Repository\EntraideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormView;



class EntraideController extends AbstractController
{


    /**
     * @Route("/entraide", name="entraide")
     */
    public function index(): Response
    {
        return $this->render('entraide/index.html.twig', [
            'controller_name' => 'EntraideController',
        ]);
    }

    /**
     * @Route("/ajouterentraide", name="ajouterentraide")
     */
    public function ajouterentraide(Request $request)
    {
        $res = new entraide();
        $form = $this->createForm(EntraideType::class, $res);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($res);
            $em->flush();
            return $this->redirectToRoute("afficherentraidefront");
        }
        return $this->render("entraide/ajouterentraide.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/afficherentraide", name="afficherentraide")
     */
    public function afficherentraideback()
    {

        $res = $this->getDoctrine()->getRepository(Entraide::class)->findAll();
        return $this->render("entraide/afficherentraideback.html.twig", array('entraides' => $res));
    }

    /**
     * @Route("/afficherentraidefront", name="afficherentraidefront")
     */
    public function afficherentraidefront()
    {

        $res = $this->getDoctrine()->getRepository(Entraide::class)->findAll();
        return $this->render("entraide/listequestion.html.twig", array('entraides' => $res));
    }

    /**
     * @Route("/supprimerentraide/{id}", name="supprimerentraide" )
     * @Method("DELETE")
     */
    public function supprimerEntraide(Entraide $id)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("afficherentraide");

    }

    /**
     * @Route("/supprimerentraidefront", name="supprimerentraidefront" )
     * @Method("DELETE")
     */
    public function supprimerentraidefront( Request $request)
    {

        $idQ=$request->query->get('idQuestion');
        $em=$this->getDoctrine()->getManager();
        $qs=$this->getDoctrine()->getRepository(Entraide::class)->findOneBy(['id'=>$idQ]);

         $em->remove($qs);
        $em->flush();
        return $this->redirectToRoute("afficherentraidefront");
    }


    /**
     * @Route("/modifierentraide/{id}", name="modifierentraide")
     * * @Method("UPDATE")
     */
    public function modifierentraide( $id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $res1 = $this->getDoctrine()->getRepository(Entraide::class)->findAll();

        $res = $em->getRepository(Entraide::class)->find($id);

        $form=$this->createForm(EntraideType::class, $res);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
           $em->flush();
            return $this->redirectToRoute('afficherentraidefront');
        }

        return $this->render('Entraide/modifierentraide.html.twig', [
            'form'=> $form->createView()
    ]);
    }

    /**
     * @Route("/rechercheparCategorie", name="rechercheparCategorie")
     * * @Method("POST")

     */

    public function rechercheparCategorie(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $entraide= $em->getRepository(Entraide:: class)->findAll();

        if($request->isMethod("POST"))
        {
            $categorie = $request->get('categorie');
            $entraide= $em->getRepository("Entraide::class")->findBy(array('categorie'=>$categorie));
        }
        return $this->render("entraide/listequestion.html.twig",array('entraides'=>$entraide));

    }
    /**
     * @Route("/rechercherCategorie", name="rechercherCategorie")
     */

    public function rechercherCategorie(EntraideRepository $repository, Request $request)
    {
        $data=$request->get('search');
        $entraide=$repository->rechercher($data);
        return $this->render("entraide/listereponse.html.twig",array('entraide'=>$entraide));

    }


    }
