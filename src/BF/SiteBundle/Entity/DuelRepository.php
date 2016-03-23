<?php

namespace BF\SiteBundle\Entity;

/**
 * DuelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DuelRepository extends \Doctrine\ORM\EntityRepository
{
	public function listDuelsComplete($user)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->where('d.host = :user OR d.guest =:user' )
	       ->setParameter('user', $user)
	     ->andWhere('d.completed = :completed')
	       ->setParameter('completed', '1')
	     ->orderBy('d.beginDate', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function progressDuels($user)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->where('d.host = :user OR d.guest =:user' )
	       ->setParameter('user', $user)
	     ->andWhere('d.completed = :completed')
	       ->setParameter('completed', '0')
	     ->orderBy('d.beginDate', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function wonDuels($user)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->where('d.host = :user OR d.guest =:user' )
	       ->setParameter('user', $user)
	     ->andWhere('d.completed = :completed')
	       ->setParameter('completed', '1')
	     ->andWhere('d.winner = :user')
	       ->setParameter('user', $user)
	     ->orderBy('d.beginDate', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function lostDuels($user)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->where('d.host = :user OR d.guest =:user' )
	       ->setParameter('user', $user)
	     ->andWhere('d.completed = :completed')
	       ->setParameter('completed', '1')
	     ->andWhere('d.winner != :user')
	       ->setParameter('user', $user)
	     ->orderBy('d.beginDate', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function drawDuels($user)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->where('d.host = :user OR d.guest =:user' )
	       ->setParameter('user', $user)
	     ->andWhere('d.completed = :completed')
	       ->setParameter('completed', '1')
	     ->andWhere('d.winner = :null')
	       ->setParameter('null', null)
	     ->orderBy('d.beginDate', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function notFinishedDuels($date)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->Where('d.completed = :completed')
	       ->setParameter('completed', '0')
	     ->andWhere('d.endDate < :date')
	     	->setParameter('date', $date)
	     ->orderBy('d.beginDate', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function checkCode($code)
	{
	  $qb = $this->createQueryBuilder('d');

	  $qb->where('d.code = :code')
	       ->setParameter('code', $code)
	     ->setMaxResults(1)
	  	;

	  return $qb
	    ->getQuery()
	    ->getOneOrNullResult()
	  ;
	}
}
