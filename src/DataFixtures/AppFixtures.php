<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $event->setName('Concert 1');
        $event->setDescription('Lorem');
        $event->setPrice(10);
        $event->setStartAt(new \DateTimeImmutable('2022-08-28 11:38:45'));
        $event->setEndAt(new \DateTimeImmutable('2022-08-29 11:38:45'));
        $manager->persist($event);

        $event = new Event();
        $event->setName('Concert 2');
        $event->setDescription('Lorem');
        $event->setPrice(20);
        $event->setStartAt(new \DateTimeImmutable('2022-08-30 11:38:45'));
        $event->setEndAt(new \DateTimeImmutable('2022-09-02 11:38:45'));
        $manager->persist($event);

        $event = new Event();
        $event->setName('Concert 3');
        $event->setDescription('Lorem');
        $event->setPrice(30);
        $event->setStartAt(new \DateTimeImmutable('2022-09-02 11:38:45'));
        $event->setEndAt(new \DateTimeImmutable('2022-09-03 11:38:45'));
        $manager->persist($event);

        $manager->flush();
    }
}
