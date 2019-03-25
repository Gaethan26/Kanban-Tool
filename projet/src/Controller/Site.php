<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Site extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="Accueil")
     */
    public function getAccueil(){
        return $this->render('site/accueil.html.twig',array(
            'accueil' => true,
        ));
    }
}