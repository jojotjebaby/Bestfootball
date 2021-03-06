<?php

namespace BF\RestApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BF\SiteBundle\Entity\Video;
use BF\SiteBundle\Form\VideoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class VideoController extends Controller
{
    /**
     * Collection get action
     * @var Request $request
     * @return array
     *
     * @Rest\View()
     */
    public function getAllAction(Request $request)
    {
        

        $repository = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Video');
        $videos = $repository->findAll();

        return array(
            'videos' => $videos,
            );
    }

    /**
     * Get entity instance
     * @var integer $id Id of the video
     * @return Video
     */
    protected function getEntity($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BFSiteBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find video entity with id '.$id);
        }

        return $entity;
    }

    /**
     * Get action
     * @var integer $id Id of the video
     * @return array
     *
     * @Rest\View()
     */
    public function getAction($id)
    {

        $video = $this->getEntity($id);

        return array(
                'video' => $video,
                );
    }

    /**
     * Collection post action
     * @var Request $request
     * @return View|array
     */
    public function postAction(Request $request)
    {

        //we retrieve the data from the JSON that is received.
        $file = $request->files->get('file');
        $json_data = $request->files->get('data');
        $json_data = file_get_contents($json_data);
        $data = json_decode($json_data,true);

        //We stock the data from the JSON in different variables
        $idChallenge = $data['idChallenge'];
        $repetitions = $data['repetitions'];

        //We search the user and challenge into the database (need to add security if these values are not in the database)
       
        $challenge = $this->getDoctrine()->getManager()->getRepository('BFSiteBundle:Challenge')->find($idChallenge);
        if(!$challenge){
            //the challenge does not exist.
            throw $this->createNotFoundException('This challenge does not exist.');
        }
        $user = $this->container->get('security.context')->getToken()->getUser();

        $description = 'A video for the '.$challenge->getTitleFR().' challenge.';
        $title = $challenge->getTitleFR();

        // On crée un objet Video
        $video = new Video();
        $video
            ->setDate(new \Datetime())
            ->setUser($user)
            ->setChallenge($challenge)
            ->setRepetitions($repetitions)
            ->setTitle($title)
            ->setDescription($description)
            ->setType('challenge')
            ->setFile($file)
        ;

        //getting the code for the duel
        $service = $this->container->get('bf_site.randomcode');
        $code = $service->generate('video');
        $video->setCode($code);
        
        $service = $this->container->get('bf_admin.videopoints');
        $service->videoPoints($video);

        //here we convert the video with the watermark
        $exploded = explode('/', $video->getSource());
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://v.bestfootball.fr/test/convert.php?file='.$exploded[3]);
        $retour = curl_exec($curl);
        curl_close($curl);




        return View::create($score,Response::HTTP_CREATED);
    }

    /**
     * Put action
     * @var Request $request
     * @var integer $id Id of the video
     * @return View|array
     */
    public function putAction(Request $request, $id)
    {

        $video = $this->getEntity($id);
        $form = $this->createForm(new VideoType(), $video, array('csrf_protection' => false));
        $json_data = json_decode($request->getContent(),true);//get the response data as array
        $form->submit($json_data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return  View::create(null, Response::HTTP_NO_CONTENT);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete action
     * @var integer $id Id of the video
     * @return View
     */
    public function deleteAction($id)
    {

        $video = $this->getEntity($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        return  View::create(null, Response::HTTP_NO_CONTENT);
    }
}
