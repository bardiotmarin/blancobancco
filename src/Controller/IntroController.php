<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IntroController extends AbstractController
{

    /**
     * @Route("/", name="intro-video")
     */
    public function IntroVideo(){
        return $this->render('video.html.twig');
    }
}