<?php

namespace App\Controller;

use App\Entity\Gado;
use App\Form\GadoType;
use App\Repository\GadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GadoController extends AbstractController
{
    #[Route('/gado', name: 'gado')]
    public function index(GadoRepository $gadoRepository): Response
    {

        $gados = $gadoRepository->findAll();
        $data['gados'] = $gados;
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

    #[Route('/gado/editar/{id}', name: 'gado_editar')]
    public function editar($id, Request $request, EntityManagerInterface $em, GadoRepository $gadoRepository): Response
    {

        $gado = $gadoRepository->find($id);
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->flush();
        }

        $data['titulo'] = 'Editar gado';
        $data['form'] = $form;

        return $this->renderForm('gado/form.html.twig', $data);
    }

    #[Route('/gado/excluir/{id}', name: 'gado_excluir')]
    public function excluir($id, EntityManagerInterface $em, GadoRepository $gadoRepository): Response
    {

        $gado = $gadoRepository->find($id);

        $em->remove($gado);
        $em->flush();

        return $this->redirectToRoute('gado');
    }

}
