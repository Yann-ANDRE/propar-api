<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Repository\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class WorkerController extends AbstractController
{
    /**
     * @Route("/worker/get/all", name="worker_get_all", methods={"GET"})
     * @param WorkerRepository $workerRepository
     * @return JsonResponse
     */
    public function getAllWorkers(WorkerRepository $workerRepository)
    {
        return $this->json($workerRepository->findAll(), 200, [], ['groups' => "worker:read"]);
    }

    /**
     * @Route("/worker/get/username", name="worker_get_username", methods={"GET"})
     * @param WorkerRepository $workerRepository
     * @return JsonResponse
     */
    public function getWorkerUsername(WorkerRepository $workerRepository)
    {
        return $this->json($workerRepository->findAllUsername(),200, [], ['groups' => 'worker:read']);
    }

    /**
     * @Route("/worker/get/{id}", name="worker_get_byId", methods={"GET"})
     * @param $id
     * @param WorkerRepository $workerRepository
     * @return JsonResponse
     */
    public function getWorkerById($id, WorkerRepository $workerRepository)
    {
        return $this->json($workerRepository->find($id), 200, [], ['groups' => 'worker:read']);
    }

    /**
     * @Route("/worker/add", name="worker_add", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * @throws Exception
     */
    public function createWorker(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $worker = new Worker();
        $worker->setFirstname($request->query->get('firstname'));
        $worker->setName($request->query->get('name'));
        $worker->setUsername($request->query->get('username'));
        $worker->setPassword($encoder->encodePassword($worker, $request->query->get('password')));
        $worker->setRole($request->query->get('role'));
        $worker->setRecruitmentDate(new \DateTime(null, new \DateTimeZone('Europe/Paris')));

        $em->persist($worker);

        $em->flush();

        return $this->json(['message' => 'Employé ajouté'], 201);
    }

}
