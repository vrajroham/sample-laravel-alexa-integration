<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogAfterRequest {

    public function handle($request, Closure $next)
    {
        Log::info('app.request', [ 'request' => $request]);
        // Log::info('app.headers', [ 'headers' => $this->getallheaders()]);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Log::info('app.request', [ 'request' => $request->all()]);
        // Log::info('app.response', ['response' => json_encode($response->content())]);
    }

    private function getallheaders()
    {
        if (!is_array($_SERVER)) {
            return array();
        }

        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}