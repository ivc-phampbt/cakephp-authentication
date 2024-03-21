<?php

namespace App\Service\Impl;
use App\Service\IArticlesService;
use Cake\ORM\TableRegistry;

class ArticlesService extends BaseService implements IArticlesService
{

    public function __construct()
    {
        $articlesTable = TableRegistry::getTableLocator()->get('Articles');
        parent::__construct($articlesTable);
    }

     /**
     * Find by id
     * @param mixed $id: the primary key.
     * @return \Cake\ORM\Entity|null
     */
    public function findById($id)
    {
        $query = $this->_table->find();
        return $query
            ->select(['total_likes' => $query->func()->count('Likes.id')])
            ->leftJoinWith('Likes')
            ->where(['Articles.id' => $id])
            ->group('Articles.id')
            ->enableAutoFields(true)
            ->first();
    }

    /**
     * Find article with conditions.
     * @return array
     */
    public function find($conditions = [], $selectedFields = [])
    {
        $query = $this->_table->find();
        return $query
            ->select(['total_likes' => $query->func()->count('Likes.id')])
            ->leftJoinWith('Likes')
            ->group('Articles.id')
            ->enableAutoFields(true)
            ->toArray();
    }
}
