<?php

namespace App\Controller;

use App\Entity\Gado;
use App\Form\GadoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        
        $gado = new Gado(); 

        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //adicionar novo gado
            $em->persist($gado);
            $em->flush();
        }

        $data['titulo'] = 'Adicionar novo gado';
        $data['form'] = $form;

        return $this->renderForm('gado/form.html.twig', $data);
    }
}
