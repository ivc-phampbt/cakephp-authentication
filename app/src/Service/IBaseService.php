<?php

namespace App\Service;

interface IBaseService
{
    public function find($conditions = [], $selectedFields = []);

    public function findById($id);

    public function create($data);

    public function update($id, $data);

    public function delete($id);
}
