<?php

namespace App\Controller;

use App\Entity\Proposal;
use App\Form\ProposalType;
use App\Repository\ProposalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proposal")
 */
class ProposalController extends AbstractController
{
    /**
     * @Route("/new", name="proposal_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $proposal = new Proposal();
        $form = $this->createForm(ProposalType::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proposal->setAuthor($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proposal);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('proposal/new.html.twig', [
            'proposal' => $proposal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proposal_show", methods={"GET"})
     * @param Proposal $proposal
     * @return Response
     */
    public function show(Proposal $proposal): Response
    {
        return $this->render('proposal/show.html.twig', [
            'proposal' => $proposal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="proposal_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Proposal $proposal
     * @return Response
     */
    public function edit(Request $request, Proposal $proposal): Response
    {
        $form = $this->createForm(ProposalType::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('proposal/edit.html.twig', [
            'proposal' => $proposal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/like", name="proposal_like", methods={"GET"})
     * @param Request $request
     * @param Proposal $proposal
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function like(Request $request, Proposal $proposal, EntityManagerInterface $entityManager): Response
    {
        $proposal->addLike($this->getUser());
        $proposal->removeDislike($this->getUser());

        $entityManager->flush();
        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}/dislike", name="proposal_dislike", methods={"GET"})
     * @param Request $request
     * @param Proposal $proposal
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function dislike(Request $request, Proposal $proposal, EntityManagerInterface $entityManager): Response
    {
        $proposal->addDislike($this->getUser());
        $proposal->removeLike($this->getUser());

        $entityManager->flush();
        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}", name="proposal_delete", methods={"DELETE"})
     * @param Request $request
     * @param Proposal $proposal
     * @return Response
     */
    public function delete(Request $request, Proposal $proposal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($proposal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
