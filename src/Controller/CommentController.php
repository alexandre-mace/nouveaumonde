<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/like", name="comment_like", methods={"GET"})
     * @param Comment $comment
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function like(Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $comment->addLike($this->getUser());
        $comment->removeDislike($this->getUser());

        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('proposal_show', ['id' => $comment->getProposal()->getId()]) . '#comment-' . $comment->getId());
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/dislike", name="comment_dislike", methods={"GET"})
     * @param Comment $comment
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function dislike(Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $comment->addDislike($this->getUser());
        $comment->removeLike($this->getUser());

        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('proposal_show', ['id' => $comment->getProposal()->getId()]) . '#comment-' . $comment->getId());
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return new RedirectResponse($request->headers->get('referer'));
    }
}
