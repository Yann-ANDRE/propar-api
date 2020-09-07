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
     * @Route("/operation/list/all", name="operation_list_all", methods={"GET"})
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     */
    public function getAllOperation(OperationRepository $operationRepository)
    {
        return $this->json($operationRepository->findAll(), 200, ['Access-Control-Allow-Origin' => '*'], ['groups' => 'operation:read']);
    }

    /**
     * @Route("/operation/list/end", name="operation_list_end", methods={"GET"})
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     */
    public function getEndOperation(OperationRepository $operationRepository){
        return $this->json($operationRepository->findEndOperation(), 200, ['Access-Control-Allow-Origin' => '*'], ['groups' => 'operation:read']);
    }

    /**
     * @Route("/operation/list/now", name="operation_list_now", methods={"GET"})
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     */
    public function getNowOperation(OperationRepository $operationRepository)
    {
        return $this->json($operationRepository->findNowOperation(), 200, ['Access-Control-Allow-Origin' => '*'], ['groups' => 'operation:read']);
    }

    /**
     * @Route("/operation/get/{id}", name="operation_get_id", methods={"GET"})
     * @param $id
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     */
    public function getOperationById($id, OperationRepository $operationRepository)
    {
        return $this->json($operationRepository->find($id), 200, ['Access-Control-Allow-Origin' => '*'], ['groups' => 'operation:read']);
    }
}
