<?php

namespace App\Controller;

use App\Entity\Gado;
use App\Form\GadoType;
use App\Repository\GadoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GadoController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(GadoRepository $gadoRepository): Response
    {

        $data['titulo'] = 'Home';
        
        $data['leite'] = $gadoRepository->findTotalLeiteProduzido();
        $data['racao'] = $gadoRepository->findRacaoNecessaria();
        $data['consumo'] = $gadoRepository->findConsumoGado();
        
        $data['pesados'] = $gadoRepository->findGadosMaisPesados();
        $data['abatidos'] = $gadoRepository->findTotalGadosAbatidos();
        $data['maiorProdutor'] = $gadoRepository->findMaiorProdutorLeite();
        $data['maisVelho'] = $gadoRepository->findMaiorProdutorLeite();


        return $this->render('gado/index.html.twig', $data);
    }

    #[Route('/gado/listar', name: 'gado_listar')]
    public function listar(GadoRepository $gadoRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $data['titulo'] = 'Gerenciar bovinos';

        $query = $gadoRepository->findAll();
        
        $data['gados'] = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            7
        );

        return $this->render('gado/listar.html.twig', $data);
    }

    #[Route('/gado/adicionar', name: 'gado_adicionar')]
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        
        $gado = new Gado(); 

        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            
            $codigo = $gado->getCodigo();
            $existeCodigo = $em->getRepository(Gado::class)->findOneBy([
                'codigo' => $codigo,
                'estado' => true
            ]);

            if($existeCodigo) 
            {
                $this->addFlash('error', 'Erro ao adicionar, o código fornecido já existe!');
                return $this->redirectToRoute('gado_adicionar');
            }
            //adicionar novo gado
            $em->persist($gado);
            $em->flush();
            $this->addFlash('success', 'Gado adicionado com sucesso!');
            return $this->redirectToRoute('gado_listar');

        }

        $data['titulo'] = 'Adicionar novo gado';
        $data['form'] = $form;

        return $this->renderForm('gado/form.html.twig', $data);
    }

    #[Route('/gado/editar/{id}', name: 'gado_editar')]
    public function editar($id, Request $request, EntityManagerInterface $em, GadoRepository $gadoRepository): Response
    {

        $gado = $gadoRepository->find($id);
        
        $codigo = $gado->getCodigo();
        
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {    
            
            $codigoEnviado = $gado->getCodigo();

            if($codigo !== $codigoEnviado) 
            {
                $existeCodigo = $em->getRepository(Gado::class)->findOneBy([
                    'codigo' => $codigoEnviado,
                    'estado' => true
                 ]);

                if($existeCodigo) 
                {
                    $this->addFlash('error', 'Erro ao editar, o código fornecido já existe!');
                    return $this->redirectToRoute('gado_editar', ['id' => $gado->getId()]);
                }
            }

            $em->flush();
            $this->addFlash('success', 'Gado editado com sucesso!');
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
        $this->addFlash('success', 'Gado removido com sucesso!');

        return $this->redirectToRoute('gado_listar');
    }

    #[Route('/gado/abate', name: 'gado_abate')]
    public function abate(GadoRepository $gadoRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $data['titulo'] = 'Gados prontos para abate';

        $query = $gadoRepository->findPossibiliaDeAbate();

        $data['gados'] = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            7
        );
        
        return $this->render('gado/abate.html.twig', $data);
    }

    #[Route('/gado/abater/{id}', name: 'gado_abater')]
    public function abater($id, EntityManagerInterface $em, GadoRepository $gadoRepository): Response
    {
        $gado = $gadoRepository->find($id);  
        $gado->setEstado(false);

        $em->persist($gado);
        $em->flush();
        $this->addFlash('success', 'Gado mandado pro abate com sucesso!'); 

        return $this->redirectToRoute('gado_abate');
    }


    #[Route('/gado/abatidos', name: 'gado_abatidos')]
    public function abatidos(GadoRepository $gadoRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $data['titulo'] = 'Bovinos abatidos';

        $query = $gadoRepository->findByEstado(false);

        $data['gados'] = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            7
        );
        
        return $this->render('gado/abatidos.html.twig', $data);
    }


}
