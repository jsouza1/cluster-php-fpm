<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StaticsController extends AbstractController
{
    #[Route('/statics/load')]
    public function load(): Response
    {
        return $this->render('statics/load.html.twig');
    }
}