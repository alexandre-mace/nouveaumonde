<?php

namespace App\Controller;

use App\Repository\ProposalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProposalRepository $proposalRepository
     * @return Response
     */
    public function index(ProposalRepository $proposalRepository): Response
    {
        return $this->render('proposal/index.html.twig', [
            'proposals' => $proposalRepository->getProposalsOrderedByNumberOfLikes(),
        ]);
    }
}
