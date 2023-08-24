<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        return $this->render('contact/index.html.twig');
    }

    /**
     * @Route("/affichercontact", name="affichercontact")
     */
    public function affichercontact()
    {

        $res = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        return $this->render("contact/index.html.twig", array('contacts' => $res));
    }

    /**
     * @Route("/ajoutercontact", name="ajoutercontact")
     */
    public function ajouterContact(Request $request)
    {
        $res = new contact();
        $form = $this->createForm(ContactType::class, $res);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($res);
            $em->flush();
            return $this->redirectToRoute("ajoutercontact");
        }
        return $this->render("contact/addc.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/supprimerContact/{id}", name="supprimerContact" )
     * @Method("DELETE")
     */
    public function supprimerContact(Contact $id)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("affichercontact");

    }
}
