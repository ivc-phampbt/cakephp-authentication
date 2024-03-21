<?php
declare(strict_types=1);

namespace App\Controller;
use App\Service\IArticlesService;
use Authorization\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
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
    public function index(IArticlesService $articlesService)
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->skipAuthorization();

        $articles = $articlesService->find();

        $this->set('articles', $articles);
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     */
    public function view(IArticlesService $articlesService)
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->skipAuthorization();

        $id = $this->request->getParam('id');
        $article = $articlesService->findById($id);

        if (empty($article)) {
            throw new NotFoundException();
        }

        $this->set('article', $article);
        $this->viewBuilder()->setOption('serialize', ['article']);
    }

    /**
     * Add method
     */
    public function add(IArticlesService $articlesService)
    {
        $this->request->allowMethod(['post']);
        $this->Authorization->skipAuthorization();

        $requestData = $this->request->getData();
        $requestData['user_id'] = $this->Authentication->getIdentity()->getIdentifier();

        $article = $articlesService->create($requestData);

        $this->set([
            'message' => $article->hasErrors()
                ? __('The article could not be saved. Please, try again.')
                : __('The article has been saved.') ,
            'errors' => $article->getErrors(),
            'article' => $article->hasErrors() ? [] : $article
        ]);

        $this->viewBuilder()->setOption('serialize', ['message', 'errors' ,
            $article->hasErrors() ? null : 'article']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     */
    public function edit(IArticlesService $articlesService)
    {
        $this->request->allowMethod(['put']);
        $id = $this->request->getParam('id');

        $article = $articlesService->findById($id);

        if ($article == null) {
            throw new NotFoundException();
        }

        if (!$this->Authorization->can($article, 'edit')) {
            throw new ForbiddenException(null, "Permission deined");
        }

        $requestData = $this->request->getData();
        $requestData['user_id'] = $this->Authentication->getIdentity()->getIdentifier();

        $article = $articlesService->update($id, $requestData);

        if ($article->hasErrors()) {
            $errors = $article->getErrors();
            $this->set([
                'message' => __('The article could not be saved. Please, try again.'),
                'errors' => $errors
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
        } else {

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
     */
    public function delete(IArticlesService $articlesService)
    {
        $this->request->allowMethod(['delete']);
        $id = $this->request->getParam('id');
        $article = $articlesService->findById($id);

        if ($article == null) {
            throw new NotFoundException();
        }

        if (!$this->Authorization->can($article, 'edit')) {
            throw new ForbiddenException(null, "Permission deined");
        }

        $this->set([
            'message' => $articlesService->delete($id)
                ? __('The article has been deleted.')
                : __('The article could not be deleted. Please, try again.'),
        ]);

        $this->viewBuilder()->setOption('serialize', ['message']);
    }


}
