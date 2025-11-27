<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnsureProjectTenantExists
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        // e.g. work.cip-tools.de
        $parts = explode('.', $host);
        $subdomain = $parts[0] ?? null;     // work

        // Agar main domain (cip-tools.de) ho to bypass:
        if ($host === 'cip-tools.de') {
            return $next($request);
        }

        // Agar koi subdomain hi nahi mila ya project nahi mila → 404 [web:306]
        if (! $subdomain || ! Project::where('slug', $subdomain)->exists()) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
