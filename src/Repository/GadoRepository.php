<?php

namespace App\Repository;

use App\Entity\Gado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gado>
 *
 * @method Gado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gado[]    findAll()
 * @method Gado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gado::class);
    }

    public function save(Gado $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gado $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPossibiliadeDeAbate() 
    {
        return $this->createQueryBuilder('g')
            ->where('g.estado = true')
            ->andWhere('g.leite < 40 or g.nascimento < :data or (g.peso/15) > 18 or (g.leite < 70 and g.racao > (50/7))')
            ->setParameter('data', date('Y-m-d', strtotime('-5 year')))
            ->orderBy('g.id')
            ->getQuery()
            ->getResult();
    }


    public function findByEstado($value): array
    {
       return $this->createQueryBuilder('g')
            ->andWhere('g.estado = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findTotalDeLeiteProduzido() 
    {
        return $this->createQueryBuilder('g')
            ->where('g.estado = :estado')
            ->select('SUM(g.leite)')
            ->setParameter('estado', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findRacaoNecessaria() 
    {
        return $this->createQueryBuilder('g')
            ->where('g.estado = :estado')
            ->select('SUM(g.racao)')
            ->setParameter('estado', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findCaracteristicasDoGado()
    {
        return $this->createQueryBuilder('g')
            ->where('g.nascimento >= :data and g.racao > 500')
            ->andWhere('g.estado = :estado')
            ->select('COUNT(g.id)')
            ->setParameter('estado', true)
            ->setParameter('data', date('Y-m-d', strtotime('-5 year')))
            ->getQuery()
            ->getSingleScalarResult();
    }

//    public function findOneBySomeField($value): ?Gado
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
