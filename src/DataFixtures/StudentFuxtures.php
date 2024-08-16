<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFuxtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $student = new Student();
        $student->setName('John Doe');
        $student->setAge(20);
        $student->setEmail('John@mail.ru');

        $manager->persist($student);
        $manager->flush();

        $student = new Student();
        $student->setName('Max Rein');
        $student->setAge(31);
        $student->setEmail('MaxRein@mail.ru');

        $manager->persist($student);
        $manager->flush();
    }
}