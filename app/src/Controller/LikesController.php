<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Likes Controller
 *
 * @property \App\Model\Table\LikesTable $Likes
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Articles'],
        ];
        $likes = $this->paginate($this->Likes);

        $this->set(compact('likes'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $this->Authorization->skipAuthorization();

        $articleId = $this->request->getParam('article_id');
        $userId =  $this->Authentication->getIdentity()->getIdentifier();

        $like = $this->Likes->find('all')
            ->where([
                'article_id' => $articleId,
                'user_id' => $userId
            ])
            ->first();

        if (empty($like)) {
            $like =  $this->Likes->newEntity(['article_id' => $articleId, 'user_id' => $userId]);
            $message = $this->Likes->save($like) ? "Like success!!!" : "Like failed!!!";
        } else {
            $message ="You have liked this article!";
        }

        $this->set([
            'message' => $message,
        ]);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }
}
