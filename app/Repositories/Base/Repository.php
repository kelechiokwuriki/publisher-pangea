<?php

namespace App\Repositories\Base;

interface Repository
{
    public function find(int $id);
    public function create(array $data);
    public function update($id, array $data);
    public function all();
    public function delete(int $id);
}
