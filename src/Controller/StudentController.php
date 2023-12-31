<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
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
    public function fetchStudents(ManagerRegistry $Mr)
    {
        $repo = $Mr->getRepository(Student::class);
        $result = $repo->findAll();
        return $this->render('student/test.html.twig', [
            'response' => $result
        ]);
    }
    #[Route('/fetchs', name: 'fetchs')]
    public function fetchTwoStudents(StudentRepository $repo)
    {
        $result = $repo->findAll();
        return $this->render('student/test.html.twig', [
            'response' => $result
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addStudent(ManagerRegistry $Mr, ClassroomRepository $repo)
    {
        $s = new Student();
        $c = $repo->find(1);
        $s->setName("tesssst");
        $s->setAge(33);
        $s->setCalssroom($c);
        $s->setEmail('test');
        $em = $Mr->getManager();
        $em->persist($s);
        $em->flush();
        return new Response('added');
    }
    #[Route('/addtwo', name: 'addtwo')]
    public function addStudenttwo(ManagerRegistry $mr, Request $req)
    {
        $s = new Student();
        //$s->setName('mmed');
        $form = $this->createForm(StudentType::class, $s);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em = $mr->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetchs');
        }
        return $this->render('student/add.html.twig', [
            'f' => $form->createView()
        ]);
    }
    #[Route('/delete/{id}', name: 'remove')]
    public function remove(ManagerRegistry $mr, Request $req, $id, StudentRepository $repo)
    {
        $em = $mr->getManager();
        $st = $repo->find($id);
        if ($st != null) {
            $em->remove($st);
            $em->flush();
            return $this->redirectToRoute('fetchs');
        } else {
            return new Response("error id doesn't exist");
        }
    }


    #[Route('/update/{id}', name: 'update')]
    public function updateStudent(ManagerRegistry $mr, Request $req, $id, StudentRepository $repo)
    {
        $s = $repo->find($id);
        $form = $this->createForm(StudentType::class, $s);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em = $mr->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetchs');
        }
        return $this->renderForm('student/update.html.twig', [
            'f' => $form
        ]);
    }
    #[Route('/dql', name: 'dql')]
    public function dqlStudnet(EntityManagerInterface $em, Request $request, StudentRepository $repo)
    {
        $result = $repo->findAll();

        if ($request->isMethod('post')) {
            $req = $em->createQuery("select s from App\Entity\Student  s where s.name=?1 "); //select name from student 
            //dd('post');
            $value = $request->get('test');
            $req->setParameter('1', $value);
            $result = $req->getResult();
            // dd($value);
        }


        return $this->render(
            'student/searchStudent.html.twig',
            [
                "students" => $result
            ]
        );
    }



    #[Route('/dqltwo', name: 'dql')]
    public function dqlStudnetrepo(Request $request, StudentRepository $repo)
    {
        $result = $repo->findAll();

        if ($request->isMethod('post')) {
            $value = $request->get('test');
            
            $result=$repo->fechStudentByName($value);
            dd($result);
        }

        return $this->render(
            'student/searchStudent.html.twig',
            [
                "students" => $result
            ]
        );
    }
    #[Route('/joindql', name: 'joindql')]
    public function dqljoin(StudentRepository $repo,EntityManagerInterface $em)
    {
       $result=$repo->fechAffectedStudent();
        //dd($result[0][1]) avec getResult();
        dd($result);
    }

    #[Route('/qb', name: 'qb')]
    public function qb(StudentRepository $repo)
    {
       $result=$repo->listdesetudiants();
        //dd($result[0][1]) avec getResult();
        dd($result);
    }
    #[Route('/qbtwo', name: 'qbtwobyklass')]
    public function qbbyklass(StudentRepository $repo)
    {
       $result=$repo->listdesetudiantsbyClass('3A14');
        //dd($result[0][1]) avec getResult();
        dd($result);
    }
}
