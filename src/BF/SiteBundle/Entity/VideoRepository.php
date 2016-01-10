<?php

namespace BF\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{
	public function checkChallenge($user, $challenge)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $user)
	     ->andWhere('v.challenge = :challenge')
	       ->setParameter('challenge', $challenge)
	     ->orderBy('v.date', 'DESC')
	     ->setMaxResults(1)
	  	;

	  return $qb
	    ->getQuery()
	    ->getOneOrNullResult()
	  ;
	}
	public function duelHostVideo($host, $duel)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $host)
	     ->andWhere('v.duel = :duel')
	       ->setParameter('duel', $duel)
	  	;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function duelGuestVideo($guest, $duel)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $guest)
	     ->andWhere('v.duel = :duel')
	       ->setParameter('duel', $duel)
	  	;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function videoBefore($user, $challenge)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $user)
	     ->andWhere('v.challenge = :challenge')
	       ->setParameter('challenge', $challenge)
	     ->orderBy('v.date', 'DESC')
	     ->setFirstResult(1)
	     ->setMaxResults(1)
	  	;

	  return $qb
	    ->getQuery()
	    ->getOneOrNullResult()
	  ;
	}
	public function lastVideo($user)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $user)
	     ->andWhere('v.type = :challenge')
	       ->setParameter('challenge', 'challenge')
	     ->orderBy('v.date', 'DESC')
	     ->setMaxResults(1)
	    ;

	  return $qb
	    ->getQuery()
	    ->getOneOrNullResult()
	  ;
	}
	public function listChallenges($user)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $user)
	     ->andWhere('v.type = :challenge')
	       ->setParameter('challenge', 'challenge')
	     ->orderBy('v.date', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function listVideos($user)
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->where('v.user = :user')
	       ->setParameter('user', $user)
	     ->andWhere('v.type = :challenge OR v.type = :freestyle')
	       ->setParameter('challenge', 'challenge')
	       ->setParameter('freestyle', 'freestyle')
	     ->orderBy('v.date', 'DESC')
	  ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
	public function listHomeVideos()
	{
	  $qb = $this->createQueryBuilder('v');

	  $qb->Where('v.type = :challenge OR v.type = :freestyle')
	       ->setParameter('challenge', 'challenge')
	       ->setParameter('freestyle', 'freestyle')
	     ->orderBy('v.date', 'DESC')
	     ->setMaxResults(100)
	    ;

	  return $qb
	    ->getQuery()
	    ->getResult()
	  ;
	}
}
