<?php

namespace App\Controller;

use App\Entity\ParticipationChallenge;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ParticipationChallengeController extends AbstractController
{
    /**
     * @Route("/participation/challenge", name="participation_challenge")
     */
    public function index(): Response
    {
        return $this->render('participation_challenge/index.html.twig', [
            'controller_name' => 'ParticipationChallengeController',
        ]);
    }
}
