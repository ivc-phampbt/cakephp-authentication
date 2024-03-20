<?php
declare(strict_types=1);

namespace App\Controller;
use Authorization\Exception\ForbiddenException;
use Cake\View\JsonView;

/**
 * Articles Controller
 *
 */
class ArticlesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->skipAuthorization();
        $query = $this->Articles->find();
        $articles = $query->select(['total_likes' => $query->func()->count('Likes.id')])
            ->leftJoinWith('Likes')
            ->group('Articles.id')
            ->enableAutoFields(true);

        $this->set('articles', $articles);
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     */
    public function view($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->skipAuthorization();

        $query = $this->Articles->find();
        $article = $query->select(['total_likes' => $query->func()->count('Likes.id')])
            ->leftJoinWith('Likes')
            ->where(['Articles.id' => $id])
            ->group('Articles.id')
            ->enableAutoFields(true)
            ->first();

        $this->set('article', $article);
        $this->viewBuilder()->setOption('serialize', ['article']);
    }

    /**
     * Add method
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

        $requestData = $this->request->getData();
        $requestData['user_id'] = $this->Authentication->getIdentity()->getIdentifier();

        $article = $this->Articles->newEntity($requestData);
        $this->Authorization->authorize($article);

        $errors = [];
        if ($article->hasErrors()) {
            $errors = $article->getErrors();

            $this->set([
                'message' => __('The article could not be saved. Please, try again.'),
                'errors' => $errors
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
        } else {
            $article = $this->Articles->save($article);

            $this->set([
                'message' => __('The article has been saved.'),
                'article' => $article
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'article']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['put']);
        $article = $this->Articles->get($id);

        if (!$this->Authorization->can($article, 'edit')) {
            throw new ForbiddenException(null, "Permission deined");
        }

        $requestData = $this->request->getData();
        $requestData['user_id'] = $this->Authentication->getIdentity()->getIdentifier();

        $article = $this->Articles->patchEntity($article, $requestData);

        if ($article->hasErrors()) {
            $errors = $article->getErrors();
            $this->set([
                'message' => __('The article could not be saved. Please, try again.'),
                'errors' => $errors
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
        } else {
            $article = $this->Articles->save($article);

            $this->set([
                'message' => __('The article has been saved.'),
                'article' => $article
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'article']);
        }

    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $article = $this->Articles->get($id);

        if (!$this->Authorization->can($article, 'edit')) {
            throw new ForbiddenException(null, "Permission deined");
        }

        $this->set([
            'message' => $this->Articles->delete($article)
                ? __('The article has been deleted.')
                : __('The article could not be deleted. Please, try again.'),
        ]);

        $this->viewBuilder()->setOption('serialize', ['message']);
    }


}
