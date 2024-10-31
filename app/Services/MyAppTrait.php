<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\MyApp;
use App\Models\AppOrder;
use App\Models\Application;
use App\Models\AppPayment;

trait MyAppTrait {
    public function createMyApp($request, $tenancy) {
        $appOrder = AppOrder::create([
            'application_id' => $request->app,
            'app_price_id' => $request->price ? : 1, // 1 = free trial
            'auto_renewal' => $request->auto_renewal ? : 0, // 0 = no, 1 = yes
            'app_order_status_id' => 1, // 1 = accepted, 2 = actived, 3 = rejected, 4 = canceled, 5 = deleted
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        $myApp = null;
        if($appOrder) {
            $appPayment = AppPayment::create([
                'app_order_id' => $appOrder->id,
                'app_payment_type_id' => $request->payment_type ? : 1, // 1 = free
                'app_payment_status_id' => !$request->payment_type ? 1 : ($request->payment_status ? : 2), // 1 = free, 2 = unpaid, 3 = paid, 4 = canceled, 5 = failed
                'created_by' => !$request->payment_type ? 0 : Auth::user()->id, // 0 = created by system admin
                'updated_by' => !$request->payment_type ? 0 : Auth::user()->id // 0 = updated by system admin
            ]);

            if($appPayment->app_payment_status_id == 1 || $appPayment->app_payment_status_id == 3) {                    
                $app = Application::find($request->app);
                $appURL = str_replace('_', '-', $tenancy->url) . '-' . $app->url;
                $appDB = $tenancy->url . '_' . $app->url;

                if (DB::statement('create database ' . $appDB)) {
                    // config(['database.connections.mysql.database' => $tenancy->db]);
                    // DB::purge('mysql');    
                    // DB::reconnect('mysql');            
                    $newCon = env('TENANCY_DB_CONNECTION');
                    // \Illuminate\Support\Facades\Config::set('database.connections.' . $newCon, [
                    //     'driver' => 'mysql',
                    //     'host' => env('TENANCY_DB_HOST'),
                    //     'port' => env('TENANCY_DB_PORT'),
                    //     'database' => $tenancy->db,
                    //     'username' => env('TENANCY_DB_USERNAME'),
                    //     'password' => env('TENANCY_DB_PASSWORD'),
                    // ]);            
                    config(['database.connections.'.$newCon => [
                        'driver' => 'mysql',
                        'host' => env('TENANCY_DB_HOST'),
                        'port' => env('TENANCY_DB_PORT'),
                        'database' => $appDB,
                        'username' => env('TENANCY_DB_USERNAME'),
                        'password' => env('TENANCY_DB_PASSWORD')
                    ]]);

                    // DB::purge($newCon);
                    // DB::reconnect($newCon);
                    // DB::setDefaultConnection($newCon);

                    // \Artisan::call('migrate', ['--path' => '/database/migrations/'.$tenancy->app]);
                    \Artisan::call('migrate', [
                        '--database' => $newCon,
                        '--path' => 'database/migrations/'.$app->url
                    ]);

                    // \Artisan::call('db:seed', [
                    //     '--class' => 'Seeders\\Raffle\\SettingsTableSeeder'
                    // ]);
                    // // \Artisan::call('db:seed', [
                    // //     '--class' => 'RaffleUsersTableSeeder'
                    // // ]);
                    // \Artisan::call('db:seed', [
                    //     '--class' => 'Seeders\\Raffle\\RolesTableSeeder'
                    // ]);
                    // \Artisan::call('db:seed', [
                    //     '--class' => 'Seeders\\Raffle\\RoleUserTableSeeder'
                    // ]);
                    // \Artisan::call('db:seed', [
                    //     '--class' => 'Seeders\\Raffle\\BranchesTableSeeder'
                    // ]);
                    // \Artisan::call('db:seed', [
                    //     '--class' => 'Seeders\\Raffle\\RegionsTableSeeder'
                    // ]);
                    $tenancyNS = 'App\Services\\'.$app->name.'App';
                    // $tenancyIns = new $tenancyNS('BASE_'.strtoupper($app->name).'_APP_URL', $tenancy->url);
                    $tenancyIns = new $tenancyNS(config('webapp.'.$app->url.'.base_url'), $appURL);                    
                    $tenancyIns->runDBSeeder();

                    // $inputUser['name'] = Auth::user()->name;
                    // $inputUser['email'] = Auth::user()->email;
                    // $inputUser['identity'] = '1000';
                    // $inputUser['password'] = Auth::user()->password;
                    // $inputUser['created_at'] = \Carbon\Carbon::now();
                    // $inputUser['updated_at'] = \Carbon\Carbon::now();
                    // $tenantUser = DB::connection($newCon)->table('users')->insert($inputUser);
                    $tenancyIns->setAdminUser();
                              
                    $input = $request->all();
                    unset($input['app']);
                    $input['tenancy_id'] = $tenancy->id;
                    $input['application_id'] = $request->app;
                    $input['app_order_id'] = $appOrder->id;
                    $input['created_by'] = Auth::user()->id;
                    $input['updated_by'] = Auth::user()->id;                    
                    // $input['fqdn'] = env('BASE_RAFFLE_APP_URL').$tenancy->url;
                    $input['fqdn'] = $tenancyIns->fqdn;
                    $input['url'] = $appURL;
                    $input['db'] = $appDB;

                    $myApp = new MyApp();
                    $myApp = $myApp->setConnection('mysql')->create($input);
                }
            }
        }

        return $myApp;
    }
}
