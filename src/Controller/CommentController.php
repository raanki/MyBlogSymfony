<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'app_comment_add')]
    public function add(Request $request, ArticleRepository $articleRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, CommentRepository $commentRepository): Response
    {
        $commentData = $request->request->all('comment');

        if (!$this->isCsrfTokenValid('comment', $commentData['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN',
            ], Response::HTTP_BAD_REQUEST);
        }

        $article = $articleRepository->findOneBy([
            'id'=> $commentData['article'],
        ]);

        if (!$article instanceof Article) {
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND',
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comment($article);
        $comment->setContent($commentData['content'])
                ->setArticle($article)
                ->setCreatedAt(new \DateTime())
                ->setUser($userRepository->findOneBy(['id' => 1]));

        $article->addComment($comment);

        $entityManager->persist($comment);
        $entityManager->flush();

        $html = $this->renderView('comment/show.html.twig', [
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComments' => count($article->getComments()),
        ]);
    }
}
