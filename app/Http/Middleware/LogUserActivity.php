<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log de acessos a rotas importantes
        if (Auth::check() && $this->shouldLog($request)) {
            Log::create([
                'data_hora' => now(),
                'user_id' => Auth::id(),
                'modulo' => 'Acesso',
                'objeto_id' => null,
                'alteracao' => "Acedeu à rota: {$request->path()}",
                'ip' => $request->ip(),
                'browser' => $request->header('User-Agent'),
            ]);
        }

        return $response;
    }

    private function shouldLog(Request $request)
    {
        $routesToLog = [
            'admin.*',
            'requisicoes.*',
            'orders.*',
            'perfil.*',
        ];

        foreach ($routesToLog as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }

        return false;
    }
}
