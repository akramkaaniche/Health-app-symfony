<?php

namespace App\Controller\Email;


use App\Services\SmsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

//FOR SMS

use Twilio\Rest\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


//



class EmailController extends AbstractController
{




    /**
     * @Route("/sms", name="sms")
     * @param Request $request
     * @param Client $twilioClient
     * @return mixed
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function sms(SmsService $smsService)
    {
        $smsService->sendSms(
            "+21695227678",
            "Salut Test"

        );

        return new Response();
    }










}
