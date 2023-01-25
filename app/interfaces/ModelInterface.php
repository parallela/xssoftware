<?php
namespace App\Interfaces;

interface ModelInterface
{
    /**
     * @return mixed
     */
    public function fetchAll();

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * @param array $attributes
     * @return bool
     */
    public function create(array $attributes);
}