<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $event = new Event();
            $event->setName($faker->sentence(rand(1, 3)));
            $event->setDescription($faker->text());
            $event->setPrice($faker->numberBetween(10, 50));
            $event->setStartAt(
                $d = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-10 days', '+5 days'))
            );
            $event->setEndAt($d->modify('+'.rand(1, 5).' days'));
            $manager->persist($event);
        }

        $manager->flush();
    }
}
