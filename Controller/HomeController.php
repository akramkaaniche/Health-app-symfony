<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\User;

use App\Services\GetUser;
use Doctrine\DBAL\Types\TextType;
use Hshn\Base64EncodedFile\HttpFoundation\File\Base64EncodedFile;
use Hshn\Base64EncodedFile\HttpFoundation\File\UploadedBase64EncodedFile;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticleType;
use App\Form\CommentaireType;



use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Import the PDF Parser class
 */
use Smalot\PdfParser\Parser;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

$filesystem = new Filesystem();

try {
    $filesystem->mkdir(sys_get_temp_dir().'/'.random_int(0, 1000));
} catch (IOExceptionInterface $exception) {
    echo "An error occurred while creating your directory at ".$exception->getPath();
}

class HomeController extends AbstractController
{
    /**
     * @Route("/home1", name="home1")
     */
    public function index(): Response
    {
        return $this->render('article/article.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

       

    /**
     * @Route("/ajouterarticle", name="ajouterarticle")
     */
    public function ajouterarticle(Request $request,GetUser $userr)

    {

        $article = new Article();
        $article->setIdUser($userr->Get_User()->getUsername());
        $article->setDate("27/04/2021");
        $form = $this->createForm(ArticleType::class, $article);


        $form->add("ajouter", SubmitType::class);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file =$article->getArticle();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $article->setArticle($filename);
            $em->persist($article);
            $em->flush();
            return
                $this->redirectToRoute("listArticle1");
        }
        return $this->render("article/home.html.twig",['format' => $form->createView()] );


    }




    /**
     * @Route("/modifierArticle/{id}", name="modifierArticle")
     */
    public function modifierArticle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $res = $em->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $res);
        $form->add("update", SubmitType::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file =$Article->getArticle();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $Article->setArticle($filename);
            $em->flush();
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('listArticle1');
        }
        return $this->render('article/modifierArticle.html.twig', [
            'format' => $form->createView()
        ]);
    }



    /**
     * @Route("/modifierArticleback/{id}", name="modifierArticleback")
     */
    public function modifierArticleback(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $res = $em->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $res);
        $form->add("update", SubmitType::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file =$Article->getArticle();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $Article->setArticle($filename);
            $em->flush();
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('listArticle');
        }
        return $this->render('article/modifierArticleback.html.twig', [
            'format' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimerArticle/{id}", name="supprimerArticle" )
     * @Method("DELETE")
     */
    public function supprimerArticle(Article $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();

        return $this->redirectToRoute("listArticle");

    }
    /**
     * @Route("/supprimerfront/{id}", name="supprimerfront" )
     * @Method("DELETE")
     */
    public function supprimerfront(Article $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();

        return $this->redirectToRoute("listArticle1");

    }

    /**
     * @Route("/approuver1/{id}", name="approuver1" )
     *
     */
    public function approuver1(Article $id)
    {   $em = $this->getDoctrine()->getManager();
        $filesystem = new Filesystem();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $res = $em->getRepository(Article::class)->find($id);
        $res->setApprouver(1);
        $filesystem->copy('../public/uploads/'.$res->getArticle(), '../public/uploads1/'.$res->getArticle());

        $em->flush();
        $this->addFlash('success', 'Article ');
        return $this->redirectToRoute("listArticle");
    }
    /**
     * @Route("/listArticle1", name="listArticle")
     */
    public function listArticleapp()
    {

        $Articles = $this->getDoctrine()->getRepository(Article::class)->findBy(array('approuver'=> 1));
        return $this->render("article/listArticle.html.twig", array('Article' => $Articles));


    }





    /**
     * @Route("/listArticle", name="listArticle")
     */
    public function listArticle()
    {

        $Articles = $this->getDoctrine()->getRepository(Article::class)->findBy(array('approuver'=> 0));
        return $this->render("article/listArticle.html.twig", array('Article' => $Articles));
    }
    /**
     * @Route("/listecommentaire", name="listecommentaire")
     */
    public function listecommentaire()
    {

        $Articles = $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return $this->render("article/listecommentaire.html.twig", array('Commentaire' => $Articles));
    }

//listearticle1 by id

    /**
     *  @Route("/listArticle1", name="listArticle1")
     */
    public function listArticle1(Request $request, PaginatorInterface $pagination,GetUser $userr)
    {
        $Articleapp = $this->getDoctrine()->getRepository(Article::class)->findBy(array('approuver'=> 1));
        $art1= $pagination->paginate($Articleapp,$request->query->getInt('page',1),4);

        $u = $this->getDoctrine()->getRepository(User::class)->find($userr->Get_User()->getId());
        $Articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['idUser'=>$u]);
        $art2= $pagination->paginate($Articles,$request->query->getInt('page',1),4);



        return $this->render("article/listArticle1.html.twig", ['Article' => $art2, 'Articleapp' => $art1]);
    }


    /**
     * @Route("/ajouterarticlecoach", name="ajouterarticlecoach")
     */
    public function ajouterarticlecoach(Request $request,GetUser $userr)

    {

        $article = new Article();
        $article->setIdUser($userr->Get_User()->getId());
        $article->setDate("27/04/2021");
        $form = $this->createForm(ArticleType::class, $article);


        $form->add("ajouter", SubmitType::class);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file =$article->getArticle();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $article->setArticle($filename);
            $em->persist($article);
            $em->flush();
            return
                $this->redirectToRoute("listarticlecoach");
        }
        return $this->render("article/homecoach.html.twig",['format' => $form->createView()] );


    }
    /**
     * @Route("/modifierArticlecoach/{id}", name="modifierArticlecoach")
     */
    public function modifierArticlecoach(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Article = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $res = $em->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $res);
        $form->add("update", SubmitType::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file =$Article->getArticle();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $Article->setArticle($filename);
            $em->flush();
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('listArticle');
        }
        return $this->render('article/modifierArticlecoach.html.twig', [
            'format' => $form->createView()
        ]);
    }
    /**
     * @Route("/supprimercoach/{id}", name="supprimercoach" )
     * @Method("DELETE")
     */
    public function supprimercoach(Article $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();

        return $this->redirectToRoute("listarticlecoach");

    }
    /**
     * @Route ("/articledetailcoach/{id}",name="articledetailcoach")
     */
    public function detailarticlecoach(Article $id,Request $request,GetUser $userr,)

    {   $Commentaire1= new Commentaire();
        $Commentaire1->setDate("27/04/2021");
        $Commentaire1->setIdUser($userr->Get_User());

        $Articledetail = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $Commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(['idArticle'=>$id->getId()]);
        $Commentaire1->setIdArticle($Articledetail);
        $Commentaire2=$this->getDoctrine()->getRepository(Commentaire::class)->findBy(['idArticle'=>$id->getId(),'idUser'=>$userr->Get_User()]);
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile('../public/uploads1/' . $Articledetail->getArticle());
        $text = $pdf->getText();

        $form = $this->createForm(CommentaireType::class, $Commentaire1);
        $form->add("add", SubmitType::class);
        $em = $this->getDoctrine()->getManager();
        $a=$Commentaire1->getIdArticle();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($Commentaire1);
            $em->flush();

            return $this->redirectToRoute('articledetailcoach',['id' => $a->getId()]);
        }

        return $this->render("article/article1.html.twig", [ 'Commentaire' => $Commentaire,'com'=>$Commentaire2,'Article' => $text, 'format' => $form->createView()]);
    }

    /**
     * @Route("/supprimercomcoach/{id}", name="supprimercomcoach" )
     * @Method("DELETE")
     */
    public function supprimercomcoach(Commentaire $id)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();
        $this->addFlash('success', 'Article supprimé avec succès');
        return $this->redirectToRoute("articledetailcoach",['id' => $id->getIdArticle()->getId()]);

    }
    /**
     *  @Route("/listarticlecoach", name="listarticlecoach")
     */
    public function listarticlecoach(Request $request, PaginatorInterface $pagination,GetUser $userr)
    {
        $Articleapp = $this->getDoctrine()->getRepository(Article::class)->findBy(array('approuver'=> 1));
        $art1= $pagination->paginate($Articleapp,$request->query->getInt('page',1),4);
        $u = $this->getDoctrine()->getRepository(User::class)->find($userr->Get_User()->getId());
        $Articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['idUser'=>$u]);

        $art2= $pagination->paginate($Articles,$request->query->getInt('page',1),4);
        return $this->render("article/listarticlecoach.html.twig", ['Article' => $art2, 'Articleapp' => $art1]);
    }




    /**
     * @Route("/listarticles1", name="showarticlesTN")
     */

    public function listTriearticleN(ArticleRepository $repository)
    {
        $Articles = $this->getDoctrine()->getRepository(Article::class)->listOrderByName();
        return $this->render("article/listArticle1.html.twig", array('Article' => $Articles));

    }
    /**
     * @Route("/listeArticlesTC", name="showarticlesTC")
     */

    public function listTriearticleC(ArticleRepository $repository)
    {
        $Articles = $this->getDoctrine()->getRepository(Article::class)->listOrderByCategories();
        return $this->render("article/listArticle1.html.twig", array('Article' => $Articles));

    }

    /**
     * @Route ("/rechercheart",name="rechercheart")
     */
    public function rechercher(ArticleRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $article=$repository->SearchName($data);
        return $this->render('article/listArticle1.html.twig',array('Article'=>$article));
    }





    /**
     * @Route ("/articledetail/{id}",name="articledetail")
     */
    public function detailarticle(Article $id,Request $request,GetUser $userr,)

    {   $Commentaire1= new Commentaire();
        $Commentaire1->setDate("27/04/2021");
        $Commentaire1->setIdUser($userr->Get_User()->getUsername());

        $Articledetail = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $Commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(['idArticle'=>$id->getId()]);
        $Commentaire1->setIdArticle($Articledetail);
        $Commentaire2=$this->getDoctrine()->getRepository(Commentaire::class)->findBy(['idArticle'=>$id->getId(),'idUser'=>$userr->Get_User()]);
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile('../public/uploads1/' . $Articledetail->getArticle());
        $text = $pdf->getText();

        $form = $this->createForm(CommentaireType::class, $Commentaire1);
        $form->add("add", SubmitType::class);
        $em = $this->getDoctrine()->getManager();
        $a=$Commentaire1->getIdArticle();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($Commentaire1);
            $em->flush();

            return $this->redirectToRoute('articledetail',['id' => $a->getId()]);
        }

        return $this->render("article/article.html.twig", [ 'Commentaire' => $Commentaire,'com'=>$Commentaire2,'Article' => $text, 'format' => $form->createView()]);
    }
    /**
     * @Route("/modifierCOM/{id}", name="modifierCOM")
     */
    public function modifiercom(Request $request, Commentaire $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Commentaire = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $res = $em->getRepository(Commentaire::class)->find($id);
        $form = $this->createForm(CommentaireType::class, $res);
        $form->add("update", SubmitType::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em->flush();
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('back');
        }
        return $this->render('article/article.html.twig', [
            'format' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimercomm/{id}", name="supprimercomm" )
     * @Method("DELETE")
     */
    public function supprimercom(Commentaire $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $this->addFlash('success', 'Article supprimé avec succès');
        return $this->redirectToRoute("listecommentaire");

    }
    /**
     * @Route("/supprimercommfront/{id}", name="supprimercommfront" )
     * @Method("DELETE")
     */
    public function supprimercomfront(Commentaire $id)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();
        $this->addFlash('success', 'Article supprimé avec succès');
        return $this->redirectToRoute("articledetail",['id' => $id->getIdArticle()->getId()]);

    }

    /**
     * @Route ("/rechercheartback",name="rechercheartback")
     */
    public function rechercherback(ArticleRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $article=$repository->SearchName($data);
        return $this->render('article/listArticle.html.twig',array('Article'=>$article));
    }
    /**
     * @Route ("/rechercheCOM",name="rechercheCOM")
     */
    public function rechercherCOM(CommentaireRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $article=$repository->Search($data);
        return $this->render('article/listecommentaire.html.twig',array('Commentaire'=>$article));
    }

    /**
     * @Route ("/liste",name="listearticle")
     */
    public function liste(SerializerInterface $serializerInterface)
    {
        $aricle = $this->getDoctrine()->getRepository(Article::class)->findBy(['approuver' => 1]);
        $json = $serializerInterface->serialize($aricle, 'json', ['groups' => 'article']);
        return new Response($json);
    }
    /* /**
      * @Route ("/add",name="add_article")
      *//*
   /* public function addarticl(Request $request,SerializerInterface $serializer)
    {  $em = $this->getDoctrine()->getManager();

        $content=$request->getContent();
        $data=$serializer->deserialize($content,Article::class,'json');
        $em->persist($data);
        $em->flush();
        return new Response('articled added ');
    }*/
    /**
     * @Route("/add" , name="add_article")
     */
    public function addarticle(Request $request, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $article->setTitre($request->get('titre'));
        $article->setTheme($request->get('theme'));
        $article->setNomAuteur($request->get('nomauteur'));
        $article->setDate($request->get('date'));
        $article->setArticle($request->get('article'));
        $article->setIdUser($request->get('iduser'));
        $article->setApprouver($request->get('approuver'));
        $em->persist($article);
        $em->flush();
        $jsonContent = $normalizer->normalize($article, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/update/{id}" , name="update")
     */
    public function update(Request $request, NormalizerInterface $normalizer, Article $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setTitre($request->get('titre'));
        $id->setTheme($request->get('theme'));
        $id->setNomAuteur($request->get('nomauteur'));
        $id->setDate($request->get('date'));
        $id->setArticle($request->get('article'));
        $id->setIdUser($request->get('iduser'));

        $em->persist($id);
        $em->flush();
        $jsonContent = $normalizer->normalize($id, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deletearticle/{id}", name="deletearticle" )
     * @Method("DELETE")
     */
    public function deletearticle(Article $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        $jsonContent = $normalizer->normalize($id, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/adda" , name="adda")
     */
    public function adda(Request $request, SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $data = $serializer->deserialize($content, Article::class, 'json');
        $parameters = json_decode($content, true);

        $uploads_directory = $this->getParameter('upload_directory');
        $filename = md5(uniqid()) . '.' . 'pdf';
        $file = new UploadedBase64EncodedFile(new Base64EncodedFile($parameters['file']));
        $file->move(
            $uploads_directory,
            $filename
        );
        //$user=$this->getDoctrine()->getRepository(User::class)->find($parameters['u']);
        //  $cat=$this->getDoctrine()->getRepository(EventCategory::class)->find($parameters['cat']);
        $data->setIdUser($parameters['iduser']);
        $data->setArticle($filename);
        $data->setTitre($parameters['titre']);
        $data->setTheme($parameters['theme']);
        $data->setNomAuteur($parameters['nomauteur']);
        $data->setDate($parameters['date']);
        $data->setApprouver($parameters['approuver']);


        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new Response($parameters['iduser']);
    }


    /**
     * @Route("/pdftotext/{id}" , name="pdftotext")
     */
    public function pdftotext(Request $request, article $id,NormalizerInterface $normalizer)
    {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile('../public/uploads1/' . $id->getArticle());
        $text = $pdf->getText();
        $text = str_replace("\n", "", $text);
        $text = str_replace("\t", "", $text);
        // $text = str_replace("\\t", "\t", $text);
        $jsonContent = $normalizer->normalize($text, 'json', ['groups' => 'post:read']);
        $response = new Response();

        $response->setContent(json_encode([
            'text' => json_encode($jsonContent,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR)
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/favo/{idarticle}/{iduser}" , name="favo")
     */
    public function favo( $idarticle ,$iduser)
    {
        $article1= new Article();


        $article=$this->getDoctrine()->getRepository(Article::class)->findBy(['id'=>$idarticle]);
        foreach($article as $i => $i_value) {
            $article1->setApprouver(2);
            $article1->setIdUser($iduser);
            $article1->setArticle($i_value->getArticle());
            $article1->setTitre($i_value->getTitre());
            $article1->setTheme($i_value->getTheme());
            $article1->setNomAuteur($i_value->getNomAuteur());
            $article1->setDate($i_value->getDate());}

        $em = $this->getDoctrine()->getManager();

        $em->persist($article1);
        $em->flush();

        return new Response('favo');
    }
    /**
     * @Route ("/listefavo/{id}",name="listefavo")
     */
    public function listefavo(SerializerInterface $serializerInterface, $id)
    {
        $aricle = $this->getDoctrine()->getRepository(Article::class)->findBy(['approuver' => 2,'idUser'=>$id]);
        $json = $serializerInterface->serialize($aricle, 'json', ['groups' => 'article']);
        return new Response($json);
    }



}
