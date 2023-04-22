<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GadoController extends AbstractController
{
    #[Route('/gado', name: 'gado')]
    public function index(): Response
    {

        $data['titulo'] = 'Gerenciar bovinos';

        return $this->render('gado/index.html.twig', $data);
    }
}
