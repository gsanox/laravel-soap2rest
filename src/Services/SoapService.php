<?php

namespace gsanox\Soap2Rest\Services;

use SoapClient;
use Exception;

class SoapService
{
    private ?SoapClient $client = null;

    public function __construct(?SoapClient $client = null)
    {
        $this->client = $client;
    }

    public function setWsdl(string $wsdl): self
    {
        $this->client = new SoapClient($wsdl);
        return $this;
    }

    public function call(string $operation, array $params)
    {
        if (!$this->client) {
            throw new Exception("WSDL not set.");
        }

        try {
            $response = $this->client->__soapCall($operation, [$params]);
            return $this->toArray($response);
        } catch (Exception $e) {
            throw new Exception("SOAP error: " . $e->getMessage());
        }
    }

    private function toArray($input)
    {
        if (is_array($input)) return $input;

        if (is_object($input)) {
            return json_decode(json_encode($input), true);
        }

        if (is_string($input)) {
            $xml = simplexml_load_string($input);
            return json_decode(json_encode($xml), true);
        }

        return $input;
    }
}
