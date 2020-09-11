<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Repository\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class WorkerController extends AbstractController
{
    /**
     * @Route("/api/worker/get/all", name="worker_get_all", methods={"GET"})
     * @param WorkerRepository $workerRepository
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function getAllWorkers(WorkerRepository $workerRepository)
    {
        return $this->json($workerRepository->findAll(), 200, [], ['groups' => "worker:read"]);
    }

    /**
     * @Route("/api/worker/get", name="api_worker_get", methods={"GET"})
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    public function getWorker(){
        return $this->json($this->getUser(), 200, [], ['groups' => 'worker:read']);
    }

    /**
     * @Route("/api/worker/add", name="api_worker_add", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * @throws Exception
     * @IsGranted("ROLE_USER")
     */
    public function addWorker(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder){
        $workerFirstname = $request->get('workerFirstname');
        $workerName = $request->get('workerName');
        $workerUsername = $request->get('workerUsername');
        $workerPassword = $request->get('workerPassword');
        $workerPasswordConfirm = $request->get('workerPasswordConfirm');
        $workerRole = $request->get('workerRole');

        if (
            isset($workerFirstname) && !empty($workerFirstname) &&
            isset($workerName) && !empty($workerName) &&
            isset($workerUsername) && !empty($workerUsername) &&
            isset($workerPassword) && !empty($workerPassword) &&
            isset($workerPasswordConfirm) && !empty($workerPasswordConfirm) &&
            isset($workerRole) && !empty($workerRole) &&
            $workerPassword == $workerPasswordConfirm
        ){
            $worker = new Worker();

            $worker->setFirstname($workerFirstname);
            $worker->setName($workerName);
            $worker->setUsername($workerUsername);
            $worker->setPassword($encoder->encodePassword($worker, $workerPassword));
            $worker->setRole($workerRole);
            $worker->setRecruitmentDate(new \DateTime(null, new \DateTimeZone('Europe/Paris')));

            $entityManager->persist($worker);
            $entityManager->flush();

            return $this->json(['result' => true]);
        } else {
            return $this->json(['result' => false]);
        }
    }

}
