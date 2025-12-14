<?php

namespace gsanox\Soap2Rest\Services;

use gsanox\Soap2Rest\Models\Service;
use SoapClient;
use Exception;

class RegistryService
{
    public function register(int $userId, string $name, string $wsdl): Service
    {
        try {
            $client = new SoapClient($wsdl);
            $functions = $client->__getFunctions();
            $operations = [];

            foreach ($functions as $f) {
                if (preg_match('/\s(\w+)\(/', $f, $match)) {
                    $operations[] = $match[1];
                }
            }

            return Service::create([
                'user_id' => $userId,
                'name' => $name,
                'wsdl' => $wsdl,
                'operations' => $operations,
            ]);
        } catch (Exception $e) {
            throw new Exception("Error parsing WSDL: " . $e->getMessage());
        }
    }

    public function unregister(Service $service): bool
    {
        return $service->delete();
    }

    public function get(int $serviceId): ?Service
    {
        return Service::find($serviceId);
    }
}
