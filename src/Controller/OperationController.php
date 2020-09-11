<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Operation;
use App\Repository\OperationRepository;
use App\Repository\TypeForOperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/api/operation/get/{id}", name="operation_get_id", methods={"GET"})
     * @param $id
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function getOperationById($id, OperationRepository $operationRepository)
    {
        return $this->json($operationRepository->find($id), 200, ['Access-Control-Allow-Origin' => '*'], ['groups' => 'operation:read']);
    }

    /**
     * @Route("/api/end_operation/{id}", name="api_end_operation", methods={"POST"})
     * @param $id
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function endOperation($id, OperationRepository $operationRepository){
        $operationRepository->endOperation($id);
        return $this->json(['result' => true]);
    }

    /**
     * @Route("/api/take_operation/{id_worker}/{id_op}", name="api_take_operation", methods={"POST"})
     * @param $id_worker
     * @param $id_op
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function takeOperation($id_worker, $id_op, OperationRepository $operationRepository){
        $operationRepository->takeOperation($id_worker, $id_op);
        return $this->json(['result' => true]);
    }

    /**
     * @Route("/api/now_operation_for_worker/{id}", name="now_operation_for_worker", methods={"GET"})
     * @param $id
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function getNowOperationForWorker($id, OperationRepository $operationRepository){
        return $this->json($operationRepository->getNowOperationForWorker($id), 200, [], ['groups' => 'operation:read']);
    }


    /**
     * @Route("/api/get_free_operation", name="get_free_operation", methods={"GET"})
     * @param OperationRepository $operationRepository
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function getFreeOperation(OperationRepository $operationRepository){
        return $this->json($operationRepository->getFreeOperation(), 200, [], ['groups' => 'operation:read']);
    }

    /**
     * @Route("/api/operation/add", name="api_add_operation", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param TypeForOperationRepository $typeForOperationRepository
     * @return JsonResponse
     * @throws Exception
     * @IsGranted("ROLE_USER")
     */
    public function addOperation(Request $request, EntityManagerInterface $entityManager, TypeForOperationRepository $typeForOperationRepository){
        $customerFirstname = $request->get('customerFirstname');
        $customerName = $request->get('customerName');
        $customerPhone = $request->get('customerPhone');
        $startDate = $request->get('startDate');
        $comment = $request->get('comment');
        $typeOp = $request->get('typeOp');
        if (
            isset($customerFirstname) && !empty($customerFirstname) &&
            isset($customerName) && !empty($customerName) &&
            isset($customerPhone) && !empty($customerPhone) &&
            isset($startDate) && !empty($startDate) &&
            isset($comment) && !empty($comment) &&
            isset($typeOp) && !empty($typeOp)
        ){
            $op = new Operation();
            $customer = new Customer();

            $customer->setFirstname($customerFirstname);
            $customer->setName($customerName);
            $customer->setPhone($customerPhone);

            $entityManager->persist($customer);
            $entityManager->flush();

            $opType = $typeForOperationRepository->findOneBy(['label' => $typeOp]);

            $op->setIdCustomer($customer);
            $op->setStartDate(new \DateTime($startDate, new \DateTimeZone('Europe/Paris')));
            $op->setComment($comment);
            $op->setIdOperationType($opType);

            $entityManager->persist($op);

            $entityManager->flush();

            return $this->json(['result' => true]);
        } else {
            return $this->json(['result' => false]);
        }
    }
}
