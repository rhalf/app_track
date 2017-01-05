<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function select(Request $request) {
        return app('db')->select("SELECT * FROM app_main.user;");
    }

    public function selectById(Request $request, $id) {
        return app('db')->select("SELECT * FROM app_main.user WHERE id=?;",[$id]);
    }

    public function insert(Request $request) {

        $query = "
        INSERT INTO app_main.user
        (
        user_name,
        user_password,
        user_dt_created,
        user_dt_expired,
        user_dt_login,
        user_dt_active,
        user_hash,
        e_privilege_id,
        e_status_id,
        company_id,
        user_info_id
        )
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?);
        ";


        $item = app('db')->insert($query, [
            $request->input('user_name'),
            $request->input('user_password'),
            $request->input('user_dt_created'),
            $request->input('user_dt_expired'),
            $request->input('user_dt_login'),
            $request->input('user_dt_active'),
            $request->input('user_hash'),
            (int)$request->input('e_privilege_id'),
            (int)$request->input('e_status_id'),
            (int)$request->input('company_id'),
            (int)$request->input('user_info_id')
            ]);


        return new Response(
            json_encode(
                array(
                    'success' => true, 
                    'item' => $item, 
                    'id' => 1), 
                200)
            );
    }
}
