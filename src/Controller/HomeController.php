<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Poi;
use App\Entity\PoiType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;



class HomeController extends AbstractController
{
    /**
     * @Route("/home/{poi_type}", name="home")
     */
    public function index(Request $request, $poi_type='all')
    {


              $project = $this->getDoctrine()->getRepository(Project::class)->find(1);


              if($poi_type=='all') $poi_list = $this->getDoctrine()->getRepository(Poi::class)->findBy(['project_id'=>1]);
              else $poi_list = $this->getDoctrine()->getRepository(Poi::class)->findBy(['project_id'=>1,'point_type'=>$poi_type]);

              $poi_type_list = $this->getDoctrine()->getRepository(PoiType::class)->findAll();



              $calendar_pois=[];

              foreach ($poi_list as $key => $value) {

                $calendar_pois[$value->getStartDate()->format("d-m")][]=$value;

              }


              /*$entityManager = $this->getDoctrine()->getManager();


              $product = new Project();
              $product->setName('Viatge Xile 2018');
              $product->setLatitude(-33.4377968);
              $product->setLongitude(-70.6504451);
              $product->setDescription('Viatge a Xile el Novembre de 2018');
              // tell Doctrine you want to (eventually) save the Product (no queries yet)
              $entityManager->persist($product);
              // actually executes the queries (i.e. the INSERT query)
              $entityManager->flush();
              $entityManager = $this->getDoctrine()->getManager();
              $product = new PoiType();
              $product->setName('Avió');              $product->setTransport(true);
              $product->setDescription('Transport aeri');
              // tell Doctrine you want to (eventually) save the Product (no queries yet)
              $entityManager->persist($product);
              // actually executes the queries (i.e. the INSERT query)
              $entityManager->flush();*/

             $start    = new \DateTime('31-10-2018');
             $end      = (new \DateTime('24-11-2018'))->modify('+1 day');
             $interval = new \DateInterval('P1D');
             $period   = new \DatePeriod($start, $interval, $end);


             $days=[];

             foreach ($period as $dt) {
               $days[$dt->format("d-m")]=$dt;
             }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'project' => $project,
            'points' => $poi_list,
            'days' => $days,
            'selected_poi_type' => $poi_type,
            'poi_type_list' => $poi_type_list,
            'calendar_pois' => $calendar_pois,
            'week_offset' => $start->format("w")
        ]);
    }


    /**
     * @Route("/poi/list", name="list_poi")
     */

    public function loadPois(){

      $poi_list = $this->getDoctrine()->getRepository(Poi::class)->findPoiLocations(1);
      return new JsonResponse($poi_list);

    }


    /**
     * @Route("/poi/create", name="create_poi")
     */
    public function create_poi(Request $request)
    {


        $poi = new Poi();
        $project = $this->getDoctrine()->getRepository(Project::class)->find(1);


        $form = $this->createFormBuilder($poi)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('start_date', DateTimeType::class)
            ->add('end_date', DateTimeType::class)
            ->add('latitude', TextType::class)
            ->add('longitude', TextType::class)
            ->add('point_type', EntityType::class, array(
                'class' => PoiType::class,
                'choice_label' => 'name',
            ))
            ->add('save', SubmitType::class, array('label' => 'Create POI'))
            ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $poi = $form->getData();
             $poi->setProjectId($project);

             // ... perform some action, such as saving the task to the database
             // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($poi);
             $entityManager->flush();

             return $this->redirectToRoute('home');
         }


         return $this->render('home/create_poi.html.twig', [
             'controller_name' => 'HomeController',
             'project' => $project,
             'form' => $form->createView()
         ]);



    }
}
