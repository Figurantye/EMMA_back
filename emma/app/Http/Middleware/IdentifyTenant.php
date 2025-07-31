<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Closure;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost(); // ou subdomínio ou header
        $tenant = Tenant::where('name', $host)->first();

        if (!$tenant) {
            return response()->json(['error' => 'Tenant não encontrado'], 404);
        }

        config(['database.connections.tenant.database' => $tenant->database]);

        DB::purge('tenant');
        DB::reconnect('ten  ant');

        // Opcional: compartilhar tenant com o app
        app()->instance('currentTenant', $tenant);

        return $next($request);
    }
}
