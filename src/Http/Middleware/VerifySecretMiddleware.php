<?php

namespace HatHatch\LaravelControlPanel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifySecretMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = config('control-panel.url');
        $path = explode('/', trim(parse_url($url, PHP_URL_PATH), '/'));

        [, , $team, , $secret] = $path;

        // todo check secret
        if ($request->hasHeader('x-api-key') && $request->header('x-api-key') === $secret) {
            return $next($request);
        }

        abort(403, 'Forbidden');
    }
}
