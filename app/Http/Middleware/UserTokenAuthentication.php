<?php

namespace App\Http\Middleware;

use App\Models\AuthToken;
use App\Models\Usuario;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $utoken = $request->query('utoken');
        if (!$utoken) {
            // endpoint does not contain utoken
        }
        $authToken = AuthToken::where('token', $utoken)->first();
        if (!$authToken) {
            // provided utoken is not valid or even exist
        }
        if ($authToken->expira_em < Carbon::now()) {
            // the provided utoken exists but is expired
        }
        $usuario = Usuario::where('uuid', $authToken->usuario_uuid)->first();
        if (!$usuario) {
            // user does not exist
        }
        return $next($request);
    }
}
