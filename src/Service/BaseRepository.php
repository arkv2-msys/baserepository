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
     * @param string $apiVer
     * @return array
     * @deprecated Use @transformPaginatedModel to prevent confusion on Model paginate method
     */
    public function paginate(
        LengthAwarePaginator $paginator,
        TransformerAbstract $transformer,
        $resourceKey,
        array $includes = [],
        $apiVer = null
    )
    {
        $resource = $this->paginator->paginate($paginator, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes, $apiVer);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @param string $apiVer
     * @return array
     */
    public function transformPaginatedModel(
        LengthAwarePaginator $paginator,
        TransformerAbstract $transformer,
        $resourceKey,
        array $includes = [],
        $apiVer = null
    )
    {
        $resource = $this->paginator->paginate($paginator, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes, $apiVer);
    }

    /**
     * Transform the Patient
     *
     * @param Model $model
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @param string $apiVer
     * @return array
     */
    public function transformItem(
        Model $model,
        TransformerAbstract $transformer,
        $resourceKey,
        array $includes = [],
        $apiVer = null
    )
    {
        $resource = new Item($model, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes, $apiVer);
    }

    /**
     * Transform Patient collection
     *
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @param string $apiVer
     * @return array
     */
    public function transformCollection(
        $collection,
        TransformerAbstract $transformer,
        $resourceKey,
        array $includes = [],
        $apiVer = null
    )
    {
        $resource = new Collection($collection, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes, $apiVer);
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
     * @param Model|Builder $modelOrBuilder
     * @param array $params
     * @return Builder
     */
    public function queryBy($modelOrBuilder, array $params) : Builder
    {
        if ($modelOrBuilder instanceof Model) {
            $query = $modelOrBuilder->newQuery();
        } else {
            $query = $modelOrBuilder; // Builder
        }

        if (!empty($params)) {
            foreach ($params as $key => $param) {
                if (!is_null($param)) {
                    $query->where($key, $param);
                }
            }
        }

        return $query;
    }

    /**
     * @param Model|Builder $model
     * @param int $perPage
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function getPaginatedModel($model, int $perPage = 25, string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $model->orderBy($orderBy, $sortBy)->paginate($perPage);
    }
}