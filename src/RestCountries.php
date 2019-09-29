<?php

namespace App\src;

use GuzzleHttp\Client;
use Exception;

class RestCountries
{
    /**
     * Guzzle Client instance
     * @var Client
     */
    private $client;

    /**
     * Fields to filter response
     * @var array
     */
    private $fields;

    public function __construct()
    {
        $this->client = new Client([
            "base_uri" => "https://restcountries.eu/rest/v2/",
        ]);
        $this->fields = [];
    }

    /**
     * Filter output of request to include only the specified fields
     *
     * @param  array  $fields Fields to filter
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Search by country name. It can be the native name or partial name
     *
     * @param string $name Country name
     * @param boolean $isFullName Search by country full name
     * @return RestCountries::execute
     * @throws Exception
     */
    public function byName($name, $isFullName = false)
    {
        $fullNameRequest = ($isFullName ? ["fullText" => "true"] : []);
        $url = sprintf("name/%s", $name);

        return $this->execute($url, $fullNameRequest);
    }

    /**
     * Execute RestCountries request
     *
     * @param string $url RestCountries request URL
     * @param array $requestParams Request params
     * @return mixed  Response JSON object or Exception
     * @throws Exception
     */
    private function execute($url, $requestParams = [])
    {
        if (count($this->fields)) {
            $requestParams = array_merge($requestParams, [
                "fields" => implode(";", $this->fields),
            ]);
            $this->fields = [];
        }

        try {
            return $this->client->get($url, [
                "query" => $requestParams,
            ])->getBody()->getContents();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
