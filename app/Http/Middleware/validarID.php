<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class validarID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->input('id');
        if (!is_numeric($id) || intval($id) <= 0 || is_float($id)) {
            return response()->json(["error" => 'El ID debe ser numérico, entero y positivo'], 400);
        }
        return $next($request);
    }
}
