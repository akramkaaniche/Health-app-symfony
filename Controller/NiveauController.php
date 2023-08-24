<?php

namespace App\Controller;


use App\Entity\Niveau;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NiveauController extends AbstractController
{
    /**
     *@Route("/niveau/home",name="niveau_list")
     */
  public function home()
  {
    //récupérer tous les niveaux de la table niveau de la BD
    // et les mettre dans le tableau $niveaux
    $niveaux= $this->getDoctrine()->getRepository(Niveau::class)->findAll();
    return  $this->render('niveau/index.html.twig',['niveaux' => $niveaux]);  
  }

  /**
       * @Route("/niveau/new", name="new_niveau")
       * Method({"GET", "POST"})
       */
 
    public function new(Request $request) {
        $niveau = new Niveau();

        $form = $this->createFormBuilder($niveau)
          ->add('titre', TextType::class)
          ->getForm();
          
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $niveau = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($niveau);
          $entityManager->flush();
  
          return $this->redirectToRoute('niveau_list');
        }
        return $this->render('niveau/new.html.twig',['form' => $form->createView()]);
    }






     /**
     * @Route("/niveau/{id}", name="niveau_show")
     */
    public function show($id) {
        $niveau = $this->getDoctrine()->getRepository(Niveau::class)->find($id);  
        return $this->render('niveau/show.html.twig', array('niveau' => $niveau));
      }

       /**
     * @Route("/niveau/edit/{id}", name="edit_niveau")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $niveau = new Niveau();
        $niveau = $this->getDoctrine()->getRepository(Niveau::class)->find($id);
        
        $form = $this->createFormBuilder($niveau)
          ->add('titre', TextType::class)
       
          
         ->getForm();
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('niveau_list');
        }
  
        return $this->render('niveau/edit.html.twig', ['form' => $form->createView()]);
      }

       /**
     * @Route("/niveau/delete/{id}",name="delete_niveau")
     * @Method({"DELETE"})
     */
       public function delete(Request $request, $id) {
        $niveaux = $this->getDoctrine()->getRepository(Niveau::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($niveaux);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('niveau_list');
      }
}
