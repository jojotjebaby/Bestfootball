<?php

namespace BF\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge');
        $listChallenges = $repository->findBy(array(),array('date' => 'desc'),5,0);

        $repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge');
        $latestChallenge = $repository->findBy(array(),array('date' => 'desc'),1,0);

        $repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Video');
        $listVideos = $repository->findBy(array(),array('date' => 'desc'),5,0);

        $repository = $this->getDoctrine()->getManager()->getRepository('BFUserBundle:User');
        $listUsers = $repository->findBy(array(),array('points' => 'desc'),10,0);


        return $this->render('BFSiteBundle:Home:index.html.twig', array(
          'listChallenges' => $listChallenges,
          'listVideos' => $listVideos,
          'listUsers' => $listUsers,
          'latestChallenge' => $latestChallenge
        ));
    }
    public function challengesAction()
    {
    	$repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge');
        $listChallenges = $repository->findBy(array(),array('date' => 'desc'));

        //Here we get the 3 videos with the most repetitions

        foreach ($listChallenges as $challenge) {
          // $advert est une instance d'Advert dans notre exemple
          $repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Video');
          $listVideos = $repository->findBy(array('challenge' => $challenge),array('repetitions' => 'desc'),3,0);
        }

		return $this->render('BFSiteBundle:Home:challenges.html.twig', array(
	      'listChallenges' => $listChallenges,
          'listVideos' => $listVideos,
	    ));
    }
    public function challengeViewAction($id)
    {
    	$repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge');
    	$challenge = $repository->find($id);
    	$repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Video');
        $listVideos = $repository->findBy(
            array('challenge' => $challenge),
            array('repetitions' => 'desc'),
            5,
            0);

		return $this->render('BFSiteBundle:Home:challengeView.html.twig', array(
	      'listVideos' => $listVideos,
	      'challenge'  => $challenge,
	    ));
    }
    public function rankingAction()
    {

        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $user = $this->container->get('security.context')->getToken()->getUser();
            $country = $user->getCountry();

            $repository = $this->getDoctrine()->getManager()->getRepository('BFUserBundle:User');
            $listUsersGlobal = $repository->findBy(array(),array('points' => 'desc'),10,0);
            $listUsersCountry = $repository->findBy(array('country' => $country),array('points' => 'desc'),10,0);


            return $this->render('BFSiteBundle:Home:ranking.html.twig',array(
                'listUsersGlobal' => $listUsersGlobal,
                'listUsersCountry' => $listUsersCountry,
                'country' => $country
                ));
        }
        else{
            $repository = $this->getDoctrine()->getManager()->getRepository('BFUserBundle:User');
            $listUsersGlobal = $repository->findBy(array(),array('points' => 'desc'),10,0);
           


            return $this->render('BFSiteBundle:Home:ranking.html.twig',array(
                'listUsersGlobal' => $listUsersGlobal,
                ));





        }
        
    }
    public function aboutAction()
    {
		return $this->render('BFSiteBundle:Home:about.html.twig');
    }
    public function rulesAction()
    {
    	return $this->render('BFSiteBundle:Home:rules.html.twig');
    }
    public function contactAction()
    {
		return $this->render('BFSiteBundle:Home:contact.html.twig');
    }
}
