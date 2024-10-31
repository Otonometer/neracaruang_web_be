<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\DB;

class TenancyAware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($request->route()->parameters());
        //dd($request->session()->all());
        $myAppTenancy = \App\Models\UserTenancy::with('tenancy')->where('url', $request->route('db'))->first();
        if($myAppTenancy) {
            session([
                'url' => $request->route('url'),
                'myselection' =>  @$myAppTenancy->tenancy->db,
                //'myApp' => $myAppTenancy
            ]);

            $newCon = 'tenant';
            config(['database.connections.'.$newCon => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => $myAppTenancy->db,
                'username' => env('TENANT_DB_USERNAME'),
                'password' => env('TENANT_DB_PASSWORD')
            ]]);
            DB::setDefaultConnection($newCon);
        }
        else{

        }
            // dd($next($request));
        return $next($request);
    }
}
