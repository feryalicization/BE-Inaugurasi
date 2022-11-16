<?php

use Illuminate\Support\Facades\Route;
use App\Models\Section;
use App\Models\Components;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return "connected succesfully";
    }
    catch(\Exception $ex)
    {
        dd($ex->getMessage());
    }
});


Route::get('/list', function () {
    try {

        // $list = DB::table('section')->leftJoin('components', 'section.components_id', '=', 'components.id')
        //     ->select(['section.key as key', 'components.title as title'])
        //     ->where('components.id', '=', 1)
        //     ->get();

        $user = DB::table('users')->find(1);
 

            return response()->json([
            'data'=>$users
        ]);
    }
    catch(\Exception $ex)
    {
        dd($ex->getMessage());
    }
});
