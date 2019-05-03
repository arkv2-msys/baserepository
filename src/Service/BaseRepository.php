<?php

namespace Geekhives\BaseRepository\Service;

use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\TransformerAbstract;

abstract class BaseRepository
{
    /**
     * @var BaseManager
     */
    public $manager;

    /**
     * @var BasePaginator
     */
    public $paginator;

    /**
     * BaseRepositoryTrait constructor.
     */
    public function __construct()
    {
        $this->manager = new BaseManager;
        $this->paginator = new BasePaginator;
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @return array
     */
    public function paginate(LengthAwarePaginator $paginator, TransformerAbstract $transformer, $resourceKey)
    {
        $resource = $this->paginator->paginate($paginator, $transformer, $resourceKey);

        return $this->manager->buildData($resource);
    }
}