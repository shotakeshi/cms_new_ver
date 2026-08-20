<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ActivityLogHelper;

class AdminActivityLogger
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (
            auth('admin')->check() &&
            in_array($request->method(), ['POST','PUT','DELETE'])
        ) {
            ActivityLogHelper::log(
                'request',
                'system',
                null,
                [
                    'method' => $request->method(),
                    'url' => $request->path(),
                ]
            );
        }

        return $response;
    }
}
