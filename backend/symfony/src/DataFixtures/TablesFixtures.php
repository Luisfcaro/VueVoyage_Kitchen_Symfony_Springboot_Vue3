<?php

namespace App\DataFixtures;

use App\Entity\Tables;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TablesFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Crear datos de prueba para Tables
        for ($i = 0; $i < 10; $i++) {
            $table = new Tables();
            $table->setNumTable($faker->randomNumber());
            $table->setIdRest($faker->randomNumber());
            $table->setCapacityTable($faker->randomNumber());
            $table->setStatusTable($faker->randomElement(['available', 'occupied', 'reserved']));
            
            $manager->persist($table);
        }

        $manager->flush();
    }

}
