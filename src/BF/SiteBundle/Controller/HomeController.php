<?php

namespace BF\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction(request $request)
    {
        //if the user is connected we redirect him to the logged page
        if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED') || $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirect($this->generateUrl('bf_site_logged_home'));
        }
        elseif( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')){
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
    }
    public function challengesAction(request $request)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)
            ->add('user', 'entity_typeahead', array(
                    'class' => 'BFUserBundle:User',
                    'render' => 'username',
                    'route' => 'bf_site_search',
                    ))
            ->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }
        $listChallenges = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge')->findBy(array(),array('date' => 'desc'));

		return $this->render('BFSiteBundle:Challenge:challenges.html.twig', array(
	      'listChallenges' => $listChallenges,
          'search' => $search->createView(),
	    ));
    }
    public function partnerChallengesAction(request $request)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)
            ->add('user', 'entity_typeahead', array(
                    'class' => 'BFUserBundle:User',
                    'render' => 'username',
                    'route' => 'bf_site_search',
                    ))
            ->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }

        $listChallenges = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge')->findBy(array('partner' => '1'),array('date' => 'desc'));

        return $this->render('BFSiteBundle:Challenge:challengespartner.html.twig', array(
          'listChallenges' => $listChallenges,
          'search' => $search->createView(),
            
        ));
    }
    public function challengeViewAction($id,request $request)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)
            ->add('user', 'entity_typeahead', array(
                    'class' => 'BFUserBundle:User',
                    'render' => 'username',
                    'route' => 'bf_site_search',
                    ))
            ->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }

    	$challenge = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge')->find($id);
        $listVideos = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Video')->findBy(
            array('challenge' => $challenge),
            array('date' => 'desc'),
            5,
            0);
        $rankUsers = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Video')->findBy(
            array('challenge' => $challenge),
            array('repetitions' => 'desc'),
            5,
            0);

		return $this->render('BFSiteBundle:Challenge:challengeView.html.twig', array(
	      'listVideos' => $listVideos,
	      'challenge'  => $challenge,
          'rankUsers' => $rankUsers,
          'search' => $search->createView(),
	    ));
    }
    public function rankingAction(request $request,$country,$state)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)
            ->add('user', 'entity_typeahead', array(
                    'class' => 'BFUserBundle:User',
                    'render' => 'username',
                    'route' => 'bf_site_search',
                    ))
            ->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }

        if($country == 'global'){ //the global ranking of all the users
            $ranking = $this->getDoctrine()->getManager()->getRepository('BFUserBundle:User')->findBy(array(),array('points' => 'desc'));
            $rankingGirls =$this->getDoctrine()->getManager()->getRepository('BFUserBundle:User')->findBy(array('gender' => 'Female'),array('points' => 'desc'));
            $listCountries = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Country')->findall();
        }
        else{ 
            if($state == 'country'){//rankings for country
                $country = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Country')->findOneByName($country);
                $listCountries = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Country')->findall();
                $ranking = $this->getDoctrine()->getManager()->getRepository('BFUserBundle:User')->countryRanking($country);
                $rankingGirls =$this->getDoctrine()->getManager()->getRepository('BFUserBundle:User')->countryRankingGirls($country);
                
            }
            else{ //ranking for state
                $state = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:State')->findOneByName($state);
                $ranking = $this->getDoctrine()->getManager()->getRepository('BFUserBundle:User')->stateRanking($state);
                $rankingGirls =$this->getDoctrine()->getManager()->getRepository('BFUserBundle:User')->stateRankingGirls($state);
                $listCountries = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Country')->findall();
            }
        }
        //rankings for state
            return $this->render('BFSiteBundle:Home:ranking.html.twig',array(
              'search' => $search->createView(),
              'ranking' => $ranking,
              'rankingGirls' => $rankingGirls,
              'listCountries' => $listCountries,
              'country' => $country,
              'state' => $state,
            ));   
    }
    public function aboutAction(request $request)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)
            ->add('user', 'entity_typeahead', array(
                    'class' => 'BFUserBundle:User',
                    'render' => 'username',
                    'route' => 'bf_site_search',
                    ))
            ->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }

		return $this->render('BFSiteBundle:Home:about.html.twig', array(
              'search' => $search->createView(),
            ));
    }
    public function rulesAction(request $request)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)
            ->add('user', 'entity_typeahead', array(
                    'class' => 'BFUserBundle:User',
                    'render' => 'username',
                    'route' => 'bf_site_search',
                    ))
            ->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }

    	return $this->render('BFSiteBundle:Home:rules.html.twig', array(
              'search' => $search->createView(),
            ));
    }
    public function contactAction(request $request)
    {
        //all the code for the user search function.
        $defaultData = array('user' => null );
        $search = $this->createFormBuilder($defaultData)->add('user', 'entity_typeahead', array('class' => 'BFUserBundle:User','render' => 'username','route' => 'bf_site_search',))->getForm(); 
        $search->handleRequest($request);
        if ($search->isValid()) {
            $data = $search->getData();
            $user = $data['user'];
            $username = $user->getUsername();
            return $this->redirect($this->generateUrl('bf_site_profile', array('username' => $username)));
        }
        //the code for the proposition
        $data = array();
            $form = $this->createFormBuilder($data)->add('name', 'text')->add('email', 'email')->add('reason', 'choice',array('choices' => array('propose a challenge'   => 'propose a challenge','a problem with the site' => 'a problem with the site','Partnership'   => 'Partnership',)))->add('message', 'textarea')->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            // $data is a simply array with your form fields
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
                    ->setSubject('A new challenge proposition')
                    ->setFrom('noreply@bestfootball.fr')
                    ->setTo('joris.hart@ezwebcreation.fr')
                    ->setBody(
                        $this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                            'Emails/contact.html.twig',
                            array('text' => $data['message'], 'name' => $data['name'], 'email' => $data['email'], 'reason' => $data['reason'])
                        ),
                        'text/html'
                    )
            ;
            $this->get('mailer')->send($message);
            $this->addFlash('success', 'Your message has been send. Thank you.');
            return $this->redirect($this->generateUrl('bf_site_homepage'));
        }
        return $this->render('BFSiteBundle:Home:contact.html.twig', array(
              'search' => $search->createView(),
              'form' => $form->createView(),
            ));
    }
}
