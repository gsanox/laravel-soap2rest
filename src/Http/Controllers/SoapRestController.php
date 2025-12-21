<?php

namespace gsanox\Soap2Rest\Http\Controllers;

use gsanox\Soap2Rest\Services\RegistryService;
use gsanox\Soap2Rest\Services\SoapService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SoapRestController extends Controller
{
    public function register(Request $request, RegistryService $registry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'wsdl' => 'required|url',
        ]);

        $service = $registry->register(Auth::id(), $request->name, $request->wsdl);

        return response()->json($service);
    }

    public function unregister(int $serviceId, RegistryService $registry)
    {
        $service = $registry->get($serviceId);

        if (!$service || $service->user_id !== Auth::id()) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $registry->unregister($service);

        return response()->json(['message' => 'Service unregistered successfully']);
    }

    public function proxy(
        int $serviceId,
        string $operation,
        Request $request,
        RegistryService $registry,
        SoapService $soap
    ) {
        $service = $registry->get($serviceId);

        if (!$service || $service->user_id !== Auth::id()) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        if (!in_array($operation, $service->operations)) {
            return response()->json(['error' => 'Invalid operation'], 400);
        }

        $result = $soap->setWsdl($service->wsdl)->call(
            $operation,
            $request->all()
        );

        return response()->json($result);
    }
}
