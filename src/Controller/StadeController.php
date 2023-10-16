<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\StadeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StadeController extends AbstractController
{
    #[Route('/stade', name: 'app_stadesss')]
    public function index(): Response
    {
        return $this->render('stade/index.html.twig', [
            'controller_name' => 'StadeController',
        ]);
    }

    #[Route('/stades', name: 'stades')]
    public function stades(StadeRepository$repo): Response
    {
        return $this->render('stade/list.html.twig', [
            'stades' => $repo->findAll(),
        ]);
    }

    #[Route('/addJ/{idofStade}', name: 'addJ')]
    public function addJ(ManagerRegistry $mr,Request $req,$idofStade,StadeRepository $repo): Response
    {
        $player=new Player();
        $form=$this->createForm(PlayerType::class,$player);
        $form->handleRequest($req);
        if ($form->isSubmitted() ){
            $stade=$repo->find($idofStade);
            if($stade!=null){
            $player->setStade($stade);
            $em=$mr->getManager();
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('stades');
        
        }else {
            return new Response("l'id d stade n'existe pas");
        }
    
    }
        return $this->render('stade/new.html.twig', [
            'f' => $form->createView(),
        ]);
    }
}
