<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    //    /**
    //     * @return Student[] Returns an array of Student objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Student
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function fechStudentByName($name)
    {
        $em = $this->getEntityManager();
        $req = $em->createQuery("select s from App\Entity\Student  s where s.name=?1");
        $req->setParameter('1', $name);
        $result = $req->getResult();
        return $result;
    }
    public function fechAffectedStudent()
    {
        $em = $this->getEntityManager();
        $req = $em->createQuery("select s.name t,c.name from App\Entity\Student  s join s.calssroom c where c.name='3A13'");
        $result = $req->getResult();
        return $result;
    }
    public function listdesetudiants()
    {
        $condition = true;
        $req = $this->createQueryBuilder('st') //findall() select *
            ->select('st.name')
            ->join("st.calssroom", "c")

            ->addSelect('c.name as classename')
            ->where("c.name='3A13'");
        if ($condition) {
            $req->orderBy('st.name ', 'DESC');
        }
            //->where("st.name='ali'")
        ;
        $preresult = $req->getQuery();
        $result = $preresult->getResult();
        return $result;
    }
    public function listdesetudiantsbyClass($klasse)
    {
        $req = $this->createQueryBuilder('st') //findall() select *
            ->select('st.name')
            ->join("st.calssroom", "c")
            ->addSelect('c.name as classename')
            ->where("c.name=:var")
            ->setParameter('var', $klasse)
            ->orderBy('st.name ', 'ASC');
            //->where("st.name='ali'")
        ;
        $preresult = $req->getQuery();
        $result = $preresult->getResult();
        return $result;
    }
}
