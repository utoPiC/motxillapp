<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PoiController extends AbstractController
{
    /**
     * @Route("/poi", name="poi")
     */
    public function index()
    {
        return $this->render('poi/index.html.twig', [
            'controller_name' => 'PoiController',
        ]);
    }
}
