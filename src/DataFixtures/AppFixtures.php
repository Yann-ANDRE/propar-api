<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Operation;
use App\Entity\TypeForOperation;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $worker = new Worker();
        $worker->setFirstname('Yann');
        $worker->setName('André');
        $worker->setUsername('yann_andre');
        $worker->setPassword($this->encoder->encodePassword($worker, 'password'));
        $worker->setRole('Expert');
        $worker->setRecruitmentDate(new \DateTime(null, new \DateTimeZone('Europe/Paris')));

        $manager->persist($worker);

        $typeLabel = ['Petite', 'Moyenne', 'Grande'];
        $typePrice = [3000, 5000, 10000];
        for ($i = 0; $i < 3; $i++){
            $type = new TypeForOperation();
            $type->setLabel($typeLabel[$i]);
            $type->setPrice($typePrice[$i]);

            $manager->persist($type);
        }

        $manager->flush();


//        $faker = Factory::create('fr_FR');
//
//        $opLabel = ['Petite', 'Moyenne', 'Grande'];
//        $opPrice = [3000, 5000, 10000];
//        $wRole = ['Apprenti', 'Senior', 'Expert'];
//        for ($i = 0; $i < 3; $i++){
//            $typeOp = new TypeForOperation();
//            $typeOp->setLabel($opLabel[$i]);
//            $typeOp->setPrice($opPrice[$i]);
//
//            $manager->persist($typeOp);
//
//            for ($j = 0; $j < mt_rand(5, 10); $j++){
//                $customer = new Customer();
//                $customer->setFirstname($faker->firstName);
//                $customer->setName($faker->lastName);
//                $customer->setPhone($faker->phoneNumber);
//
//                $manager->persist($customer);
//
//                for ($k = 0; $k < mt_rand(5, 10); $k++){
//                    $worker = new Worker();
//
//                    $worker->setFirstname($faker->firstName);
//                    $worker->setName($faker->lastName);
//                    $worker->setUsername($faker->userName);
//                    $worker->setPassword($this->encoder->encodePassword($worker, 'password'));
//                    $worker->setRole($wRole[(mt_rand(0, 2))]);
//                    $worker->setRecruitmentDate(new \DateTime());
//
//                    $manager->persist($worker);
//
//                    for ($l = 0; $l < mt_rand(5, 10); $l++){
//                        $operation = new Operation();
//                        $operation->setStartDate($faker->dateTime);
//                        $operation->setComment($faker->paragraph);
//                        $operation->setIdWorker($worker);
//                        $operation->setIdCustomer($customer);
//                        $operation->setIdOperationType($typeOp);
//
//                        $manager->persist($operation);
//
//                    }
//                }
//            }
//        }
//
//        $manager->flush();
    }
}
