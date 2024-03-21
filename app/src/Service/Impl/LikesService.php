<?php

namespace App\Service\Impl;
use App\Service\ILikesService;
use Cake\ORM\TableRegistry;

class LikesService extends BaseService implements ILikesService
{
    public function __construct()
    {
        $articlesTable = TableRegistry::getTableLocator()->get('Likes');
        parent::__construct($articlesTable);
    }

    /**
     * Has like.
     * @param mixed $userId: the user id.
     * @param mixed $articleId: the article id.
     * @return bool
     */
    public function hasLike($userId, $articleId) :bool
    {
        $count = $this->_table->find('all')
            ->where([
                'article_id' => $articleId,
                'user_id' => $userId
            ])
            ->count();
        return $count == 1;
    }

    /**
     * Total likes
     * @param mixed $articleId: the article id.
     * @return int
     */
    public function totalLikes($articleId): int
    {
        return $this->_table->find()
            ->where(['article_id' => $articleId])
            ->count();
    }
}
