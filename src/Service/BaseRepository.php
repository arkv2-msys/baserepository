<?php

namespace Geekhives\BaseRepository\Service;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
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
     * @param array $includes
     * @return array
     * @deprecated Use @transformPaginatedModel to prevent confusion on Model paginate method
     */
    public function paginate(LengthAwarePaginator $paginator, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = $this->paginator->paginate($paginator, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @return array
     */
    public function transformPaginatedModel(LengthAwarePaginator $paginator, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = $this->paginator->paginate($paginator, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }

    /**
     * Transform the Patient
     *
     * @param Model $model
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @return array
     */
    public function transformItem(Model $model, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = new Item($model, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }

    /**
     * Transform Patient collection
     *
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @return array
     */
    public function transformCollection($collection, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = new Collection($collection, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }

    /**
     * Upload a single file in the server
     * and return the random (string) filename if successful and (boolean) false if not
     *
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public')
    {
        return $file->store($folder, ['disk' => $disk]);
    }

    /**
     * @param Model $model
     * @param array $params
     * @return Builder
     */
    public function queryBy(Model $model, array $params) : Builder
    {
        $query = $model->newQuery();

        if (!empty($params)) {
            $query->where($params);
        }

        return $query;
    }

    /**
     * @param Model $model
     * @param int $perPage
     * @param string $orderBy
     * @param string $sortBy
     * @param Builder|null $builder
     * @return mixed
     */
    public function getPaginatedModel(Model $model, int $perPage = 25, string $orderBy = 'id', string $sortBy = 'asc', Builder $builder = null)
    {
        if ($builder) {
            $query = $builder;
        } else {
            $query = $model->newQuery();
        }

        return $query->orderBy($orderBy, $sortBy)->paginate($perPage);
    }
}