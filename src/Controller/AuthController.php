<?php

namespace App\Controller;

use App\Entity\Worker;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth/register", name="auth_register", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     * @return void
     * @throws Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $worker = new Worker();
        $worker->setFirstname($request->get('firstname'));
        $worker->setName($request->get('name'));
        $worker->setUsername($request->get('username'));
        $worker->setPassword($encoder->encodePassword($worker, $request->get('password')));
        $worker->setRole($request->get('role'));
        $worker->setRecruitmentDate(new \DateTime(null, new \DateTimeZone('Europe/Paris')));

        $em->persist($worker);
        $em->flush();
    }

    /**
     * @Route("login_check", name="login_check", methods={"POST"})
     */
    public function login(){

    }
}
