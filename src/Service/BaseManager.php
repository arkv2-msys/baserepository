<?php

namespace Geekhives\BaseRepository\Service;

use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class BaseManager
{
    /**
     * @param $resource
     * @param array $includes
     * @param string $apiVer
     * @return array
     */
    public function buildData($resource, array $includes = [], $apiVer = null) : array
    {
        $manager = new Manager;
        $manager->setSerializer(new JsonApiSerializer(config('app.url') . $apiVer));
        $manager->parseIncludes($includes);

        return $manager->createData($resource)->toArray();
    }
}
