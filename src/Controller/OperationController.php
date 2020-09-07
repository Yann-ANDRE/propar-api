<?php

namespace App\Controller;

use App\Repository\OperationRepository;
use App\Repository\WorkerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OperationController extends AbstractController
{
    /**
     * @Route("/worker", name="worker_get_all", methods={"GET"})
     * @param WorkerRepository $workerRepository
     * @return JsonResponse
     */
    public function getAllWorkers(WorkerRepository $workerRepository)
    {
        return $this->json($workerRepository->findAll(), 200, [], ['groups' => "worker:read"]);
    }

    /**
     * @Route("/operation", name="operation_get_all", methods={"GET"})
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     */
    public function getAllOperation(OperationRepository $operationRepository)
    {
        return $this->json($operationRepository->findAll(), 200, [], ['groups' => 'operation:read']);
    }
}
