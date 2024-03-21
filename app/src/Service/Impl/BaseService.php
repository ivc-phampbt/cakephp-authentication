<?php

namespace App\Service\Impl;
use App\Service\IBaseService;
use Cake\ORM\Table;

class BaseService implements IBaseService
{
    protected Table $_table;

    public function __construct(Table $table)
    {
        $this->_table = $table;
    }

    /**
     * Find article with conditions.
     * @return mixed
     */
    public function find($conditions = [], $selectedFields = [])
    {
        $query = $this->_table->find();
        if ($conditions) {
            $query->where($conditions);
        }

        if ($selectedFields) {
            $query->select($selectedFields);
        }
        return $query;
    }

    /**
     * Find by id
     * @param mixed $id: the primary key.
     * @return \Cake\ORM\Entity|null
     */
    public function findById($id)
    {
        return $this->_table->get($id);
    }

    /**
     * Create function.
     * @param array $data: the input data.
     * @return \Cake\ORM\Entity
     */
    public function create($data)
    {
        $entity = $this->_table->newEntity($data);
        if ($entity->hasErrors()) {
            return $entity;
        }
        return $this->_table->save($entity);
    }

    /**
     * Update function
     * @param mixed $id: the primary key.
     * @param array $data: the data.
     * @return \Cake\ORM\Entity
     */
    public function update($id, $data)
    {
        $entity = $this->_table->get($id);
        $entity = $this->_table->patchEntity($entity, $data);

        if ($entity->hasErrors()) {
            return $entity;
        }

        return $this->_table->save($entity);
    }

    /**
     * Delete function.
     * @param mixed $id: the primary key.
     * @return bool
     */
    public function delete($id)
    {
        $entity = $this->_table->get($id);
        return $this->_table->delete($entity);
    }

}
