<?php

namespace App\Controller;

use App\Form\GadoType;
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

    #[Route('/gado/adicionar', name: 'gado_adicionar')]
    public function adicionar(): Response
    {

        $form = $this->createForm(GadoType::class);
        
        $data['titulo'] = 'Adicionar novo gado';
        $data['form'] = $form;

        return $this->renderForm('gado/form.html.twig', $data);
    }
}
