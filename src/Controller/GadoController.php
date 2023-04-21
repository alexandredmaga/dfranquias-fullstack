<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GadoController extends AbstractController
{
    #[Route('/gado', name: 'app_gado')]
    public function index(): Response
    {
        return $this->render('gado/index.html.twig', [
            'controller_name' => 'GadoController',
        ]);
    }
}
