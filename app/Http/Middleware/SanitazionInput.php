<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitazionInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param $except is for request if wanna not including in request, if wanna all request just entering *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$excepts)
    {
        $input = $request->all();

        // if except using *
        // '*' equal all input request
        if (!in_array("*", $excepts)) {
            $input = $request->except($excepts);
        }

        // processing remove Strip HTML and PHP tags from a string
        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });

        $request->merge($input);
        return $next($request);
    }
}
