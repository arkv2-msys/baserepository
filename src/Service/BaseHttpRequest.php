<?php

namespace Geekhives\BaseRepository\Service;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BaseHttpRequest
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    /**
     * BaseHttpRequest constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->client = new Client;
        $this->url = $url;
    }

    /**
     * Create a GET HTTP request
     *
     * @param null $path
     * @return mixed
     * @throws Exception
     */
    public function get($path = null)
    {
        try {

            $fullUrl = $this->url;

            if ($path) {
                $fullUrl = $this->url . $path;
            }

            $response = $this->client->get($fullUrl);

            return json_decode($response->getBody(), true);

        } catch (Exception $e) {
            Log::info($e->getTraceAsString());
            throw new Exception($e);
        }
    }


    /**
     * Create a POST HTTP request
     *
     * @param array $data
     * @param bool $json
     * @return mixed
     * @throws Exception
     */
    public function post(array $data, $json = false)
    {
        $post = [
            'post_params' => $data
        ];

        if ($json) {
            $post = [
                'json' => $data
            ];
        }

        try {

            $response = $this->client->post($this->url, $post);

            return json_decode($response->getBody(), true);

        } catch (Exception $e) {
            Log::info($e->getTraceAsString());
            throw new Exception($e);
        }
    }
}
