<?php

namespace App\Controller;

use App\Entity\Map;
use App\Form\MapType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(Request $request,FlashyNotifier $flashy): Response
    { $map= new Map();
        $form= $this->createForm(MapType::class,$map);

        $form->handleRequest($request);
        $translator = new Translator('fr_FR');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [
            'Event Location' => 'la localisation de l activite !',
            'done'=>'success',
            'fail'=>'echec',

        ], 'fr_FR');
        $flashy->success($translator->trans('Event Location'), 'http://127.0.0.1:8000/listactclient');
        return $this->render('map.html.twig', [
            'MapForm'=>$form->createView(), 'map'=>$map
        ]);
    }

}
