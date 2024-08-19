<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{


    public function __construct(
        public StudentRepository $studentRepository,
        public EntityManagerInterface $em
    ){}

    #[Route('/students', name: 'student')]
    public function showStudents()
    {
        return $this->render('student/student.html.twig');
    }

    #[Route('/api/students', name: 'api_students')]
    public function getStudents(): Response
    {
        $students = $this->studentRepository->findBy(['deleted' => false]);
        $studentsArray = [];
        foreach ($students as $student) {
            $studentsArray[] = [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'age' => $student->getAge(),
            ];
        }

        return new JsonResponse($studentsArray);
    }

    #[Route('/api/students/create', name: 'api_students_create', methods: ['POST'])]
    public function createStudent(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Instantiate a new Student entity
        $student = new Student();
        $student->setName($data['name']);
        $student->setEmail($data['email']);
        $student->setAge($data['age']);

        // Persist the new student to the database
        $this->em->persist($student);
        $this->em->flush();

        // Convert new student to array
        $studentArray = [
            'id' => $student->getId(),
            'name' => $student->getName(),
            'email' => $student->getEmail(),
            'age' => $student->getAge(),
        ];

        // return the newly created student
        return new JsonResponse($studentArray, Response::HTTP_CREATED);
    }

    #[Route('/api/students/delete/{id}', name: 'api_students_delete', methods: ['DELETE'])]
    public function deleteStudent(Student $student): Response
    {

        // Instead of removing the student, mark it as deleted
        $student->setDeleted(true);
        $this->em->persist($student);
        $this->em->flush();

        return new JsonResponse(['status' => 'Student deleted'], Response::HTTP_NO_CONTENT);
    }

    #[Route] #[Route('/api/students/update/{id}', name: 'api_students_update', methods: ['PUT'])]
    public function updateStudent(Request $request, Student $student): Response
    {
        $data = json_decode($request->getContent(), true);

        // Update the student entity with the new data
        $student->setName($data['name']);
        $student->setEmail($data['email']);
        $student->setAge($data['age']);

        // Persist the updated student to the database
        $this->em->persist($student);
        $this->em->flush();

        // return a proper success response, usually 200
        return new JsonResponse(['status' => 'Student updated'], Response::HTTP_OK);
    }
}
