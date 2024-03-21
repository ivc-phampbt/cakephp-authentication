<?php
declare(strict_types=1);

namespace App\Controller;
use App\Service\ILikesService;

/**
 * Likes Controller
 *
 * @property \App\Model\Table\LikesTable $Likes
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $this->Authentication->allowUnauthenticated(['index']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index(ILikesService $likesService)
    {
        $this->Authorization->skipAuthorization();
        $articleId = $this->request->getParam('article_id');
        $totalLikes = $likesService->totalLikes($articleId);

        $this->set([
            'total_likes' => $totalLikes,
        ]);
        $this->viewBuilder()->setOption('serialize', ['total_likes']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(ILikesService $likesService)
    {
        $this->request->allowMethod(['post']);
        $this->Authorization->skipAuthorization();

        $articleId = $this->request->getParam('article_id');
        $userId =  $this->Authentication->getIdentity()->getIdentifier();

        $hasLike = $likesService->hasLike($userId, $articleId);

        if ($hasLike) {
            $message ="You have liked this article!";
        } else {
            $like = $likesService->create(['article_id' => $articleId, 'user_id' => $userId]);
            $message = ($like === false || $like->hasErrors()) ?  "Like failed!!!" : "Like success!!!";
        }

        $this->set([
            'message' => $message,
        ]);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }
}
