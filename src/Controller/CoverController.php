<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CoverController extends AbstractController
{

    /**
     **@Route("/cover", name="cover_list")
     */
    public function CoverList()
        {
            return $this->render('Cover.html.twig');

        }

}

