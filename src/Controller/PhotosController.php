<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PhotosController extends AbstractController
{
    /**
     *@Route("/photo", name="photos_list")
     */
    public function Photos()
    {
        return $this->render("photo.html.twig");
    }
}