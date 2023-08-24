<?php

namespace App\Controller\Front\Client;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\MailerService;
use App\Services\MaLocalisation;
use App\Services\SmsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Filesystem\Filesystem;


use Hshn\Base64EncodedFile\HttpFoundation\File\Base64EncodedFile;
use Hshn\Base64EncodedFile\HttpFoundation\File\UploadedBase64EncodedFile;

class ApiClientController extends AbstractController
{

    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;


    }
    /**
     * @Route("/api/client", name="api_client")
     */
    public function index(): Response
    {
        return $this->render('api_client/index.html.twig', [
            'controller_name' => 'ApiClientController',
        ]);
    }

    /**
     * @Route("/api/client/checkUserUnique", name="checkUserUnique")
     * @param MailerService $mailerService
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserPasswordEncoderInterface $encoder
     * @param MaLocalisation $maLocalisation
     * @return Response
     * @throws ExceptionInterface
     */
    public function checkUserUnique(MailerService $mailerService,Request $request,NormalizerInterface $normalizable,UserPasswordEncoderInterface $encoder,MaLocalisation $maLocalisation): Response
    {

        $userBD_id = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $userBD_email = $this->getDoctrine()->getRepository(User::class)->findBy(
            ['email' =>$request->get($request->get('email'))]
        );

        if($userBD_id)
        {
            $result=-1;

        }
        else if($userBD_email)
        {
            $result=-2;
        }

        else{


            $result=1;
        }
        $jsonContent=$normalizable->normalize($result,'json',[]);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/client/addUser", name="addUser")
     * @param MailerService $mailerService
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserPasswordEncoderInterface $encoder
     * @param MaLocalisation $maLocalisation
     * @return Response
     * @throws ExceptionInterface
     */
    public function addUser(MailerService $mailerService,Request $request,NormalizerInterface $normalizable,UserPasswordEncoderInterface $encoder,MaLocalisation $maLocalisation): Response
    {
        $em=$this->getDoctrine()->getManager();
        $user=new User();
        $password=$encoder->encodePassword($user,$request->get('password'));
        $adresse=$maLocalisation->MaLocalisation();

        $fileName = $request->get('picture');
        $filePathMobile="C://Users//SeifBS//AppData//Local//Temp";
        $uploads_directory = $this->getParameter('pictures_directory');
        $filesystem = new Filesystem();
        $filesystem->copy($filePathMobile."//".$fileName,$uploads_directory."/$fileName");

        $user->construct($request->get('id'),$request->get('nom'),$request->get('prenom'),$request->get('email'),$password,$request->get('tel'),'NULL',$adresse,'Client',array('ROLE_CLIENT'),$request->get('picture'));

            $em->persist($user);
            $em->flush();
            $result=1;
        $jsonContent=$normalizable->normalize($result,'json',[]);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/client/modify", name="api_clientModify")
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserPasswordEncoderInterface $encoder
     * @param MaLocalisation $maLocalisation
     * @return Response
     * @throws ExceptionInterface
     */
    public function modifyClientApi(Request $request,NormalizerInterface $normalizable,UserPasswordEncoderInterface $encoder,MaLocalisation $maLocalisation): Response
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setTel($request->get('tel'));
        $user->setAdresse($maLocalisation->MaLocalisation());

        if($user->getPicture()!=$request->get('picture'))
        {
            $fileName = $request->get('picture');
            $filePathMobile="C://Users//SeifBS//AppData//Local//Temp";
            $uploads_directory = $this->getParameter('pictures_directory');
            $filesystem = new Filesystem();
            $filesystem->copy($filePathMobile."//".$fileName,$uploads_directory."/$fileName");
            $user->setPicture($request->get('picture'));
        }

        $em->flush();
        $jsonContent=$normalizable->normalize($user,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/client/modifyPassword", name="api_clientModifyPassword")
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws ExceptionInterface
     */
    public function modifyClientPasswordApi(Request $request,NormalizerInterface $normalizable,UserPasswordEncoderInterface $encoder): Response
    {    $User=new User();
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $password=$encoder->encodePassword($User,$request->get('password'));

        $user->setPassword($password);
        $em->flush();
        $jsonContent=$normalizable->normalize($user,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/client/loginCheck", name="api_clientLoginCheck")
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserRepository $userRepository
     * @return Response
     * @throws ExceptionInterface
     */

    public function loginCheck(Request $request,NormalizerInterface $normalizable,UserRepository $userRepository): Response
    {  $result=false;
        $user=new User();
        $User = $this->getDoctrine()->getRepository(User::class)->findBy(
        ['email' =>$request->get('email')]);

        $password=$this->encoder->encodePassword($user,$request->get('password'));
        if($User)
        {
            if($User[0]->getPassword()==$password)
            {
                if($User[0]->getRole()=='Client')
                $result=true;


        }}

        $jsonContent=$normalizable->normalize($result,'json',[]);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/api/client/getUser", name="api_clientgetUser")
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserRepository $userRepository
     * @return Response
     * @throws ExceptionInterface
     */

    public function getUserByEmail(Request $request,NormalizerInterface $normalizable,UserRepository $userRepository): Response
    {
        $user=new User();
        $userEmail = $this->getDoctrine()->getRepository(User::class)->findBy(
            ['email' =>$request->get('email')]
        );

        if($userEmail)
        {
            $user=$userEmail;
        }

        $jsonContent=$normalizable->normalize($user,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/client/forgetPasswordCheck", name="api_forgetPasswordCheck")
     * @param MailerService $mailerService
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserRepository $userRepository
     * @return Response
     * @throws ExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function forgetPasswordCheck(MailerService $mailerService,Request $request,NormalizerInterface $normalizable,UserRepository $userRepository): Response
    {   $result=false;
        $user=new User();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('cin'));


        if($user)
        {
        if($user->getEmail()==$request->get("email"))
        {
            $result=true;

        }}

        $jsonContent=$normalizable->normalize($result,'json',[]);
        return new Response(json_encode($jsonContent));
    }





    /**
     * @Route("/api/client/smsAuthentification", name="smsAuthentification")
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws ExceptionInterface
     */
    public function smsAuthentification(Request $request,NormalizerInterface $normalizable,UserPasswordEncoderInterface $encoder): Response
    {    $User=new User();
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        if($user)
        {

            if($user->getSms()=="Y")
            $user->setSms("N");
            else if($user->getSms()=="N")
            $user->setSms("Y");


            $em->flush();

        }

        $jsonContent=$normalizable->normalize($user,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
 * @Route("/api/client/sendSms", name="sendSms")
 * @param Request $request
 * @param NormalizerInterface $normalizable
 * @param SmsService $smsService
 * @return Response
 * @throws ExceptionInterface
 */
    public function sendSms(Request $request,NormalizerInterface $normalizable,SmsService $smsService): Response
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        if($user)
        {

            $smsService->sendSms(
                "+216".$user->getTel(),
                "Voici votre code de verification".$request->get('verificationCode')
            );

        }

        $jsonContent=$normalizable->normalize($user,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/api/client/testData", name="testData")
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param NormalizerInterface $normalizable
     * @param SmsService $smsService
     * @return Response
     * @throws ExceptionInterface
     */
    public function testData(SerializerInterface $serializer,Request $request,NormalizerInterface $normalizable,SmsService $smsService): Response
    {


        $fileName = $request->get('data');
        $filePathMobile="C://Users//SeifBS//AppData//Local//Temp";
        $uploads_directory = $this->getParameter('pictures_directory');
        $filesystem = new Filesystem();
        $filesystem->copy($filePathMobile."//".$fileName,$uploads_directory."/$fileName");






        $jsonContent=$normalizable->normalize(true,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
}
