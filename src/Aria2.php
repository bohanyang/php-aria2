<?php

declare(strict_types=1);

namespace Cider\Aria2;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function array_unshift;

class Aria2
{
    /** @var HttpClientInterface */
    private $client;

    /** @var string */
    private $auth;

    /** @var string */
    private $url;

    public function __construct(string $url, string $secret = null, HttpClientInterface $client = null)
    {
        if ($client === null) {
            $client = HttpClient::create();
        }

        $this->client = $client;

        if ($secret !== null) {
            $this->auth = "token:$secret";
        }

        $this->url = $url;
    }

    public function request(string $method, array $params)
    {
        if (isset($this->auth)) array_unshift($params, $this->auth);

        $request = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => "aria2.$method",
            'params' => $params
        ];

        $response = $this->client->request('POST', $this->url, ['json' => $request])->toArray(false);

        if (isset($response['error'])) {
            throw new Exception($response['error']['message'], $response['error']['code']);
        }

        return $response['result'];
    }

    public function __call(string $name, array $arguments)
    {
        $this->request($name, $arguments);
    }
}
