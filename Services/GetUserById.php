<?php


namespace App\Services;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetUserById extends AbstractController
{   private $user;
    public function getUserById($id,UserRepository $rep) :User
    {
    $this->user=new User();

        $entityManager = $this->getDoctrine()->getManager();
        $this->user =$rep->find($id);





        return $this->user;
    }
}