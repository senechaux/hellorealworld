<?php

namespace App\DataFixtures;

use App\Entity\Phweep;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $phweep = new Phweep();
            $phweep->setMessage($faker->text);
            $manager->persist($phweep);
        }

        $manager->flush();
    }
}
