<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/fetch', name: 'fetch')]
    public function fetchStudents(ManagerRegistry $Mr){
$repo=$Mr->getRepository(Student::class);
$result=$repo->findAll();
return $this->render('student/test.html.twig',[
    'response'=>$result
]);

    }
    #[Route('/fetchs', name: 'fetchs')]
public function fetchTwoStudents(StudentRepository $repo){
$result=$repo->findAll();
return $this->render('student/test.html.twig',[
'response'=>$result
]);
}

#[Route('/add', name: 'add')]
public function addStudent(ManagerRegistry $Mr){
$s=new Student();
$s->setName("Ashish");
$s->setAge(33);
$s->setEmail('test');
$em=$Mr->getManager();
$em->persist($s);
$em->flush();
return new Response('added');
}
}