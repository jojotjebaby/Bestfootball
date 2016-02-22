<?php

namespace BF\SiteBundle\Entity;

/**
 * PredictionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PredictionRepository extends \Doctrine\ORM\EntityRepository
{
	public function checkPredict($user, $challenge)
	{
	  $qb = $this->createQueryBuilder('p');

	  $qb->where('p.voter = :user')
	       ->setParameter('user', $user)
	     ->andWhere('p.challenge = :challenge')
	       ->setParameter('challenge', $challenge)
	     ->setMaxResults(1)
	  	;

	  return $qb
	    ->getQuery()
	    ->getOneOrNullResult()
	  ;
	}
}