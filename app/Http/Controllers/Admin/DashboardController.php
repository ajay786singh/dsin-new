<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MY_Controller;
use Illuminate\Http\Request;
use Session;
use Validator;
use DB;
use Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Dynamic_model;


use App\Models\Brands;
use App\Models\Products;
use Illuminate\Support\Str;

class DashboardController extends MY_Controller
{



    public function index()
    {
        return view('admin.index');
    }


    public function users()
    {
        //getting session email
        $roles        = Session::get('loginId')['roles'];

        // $permission  = DB::table('permissions')->where('name', $roles)->get()->first();
        $permission = $this->_row('permissions', $roles, 'name');
        if (empty($permission->name) || is_null($permission->name)) {
            return $this->logout();
        }

        $data['users'] = User::get();

        return view('admin.users.users', $data);
    }



    public function add_user(Request $request)
    {
        $user = new User();

        $request->validate([
            'first_name' => 'required|min:1',
            'email' => 'required|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'            
        ]);

        $user->email    = $request->email;
        $user->first_name =  $request->first_name;
        $user->last_name =  $request->last_name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->roles    = json_encode($request->roles);
        $user->status   = $request->status;
        $result = $user->save();


        flash("User has added successfully!")->success();
        return back();
    }






    public function delete_user(Request $request)
    {
        $id     = $request->id;
        $result = $this->_delete('users', $id);

        flash("User has deleted successfully!")->success();
        return back();
    }



    public function delete_multiple_user(Request $request)
    {

        $ids    = $request->ids;
        $ids    = explode(",", $ids);
        $result = $this->_multiple_delete("users", $ids);

        flash("Selected user has added successfully!")->success();
        return back();
    }



    public function edit_user($id)
    {

        $user    = DB::table('users')->where('id', $id)->get()->first();
        @$jroles = json_decode($user->roles, true);

        #empty values sending
        /*$admin    = '';
        $dealer   = '';
        $customer = '';
        $salesperson   = '';

        if (array_key_exists('Admin', $jroles)) {
            $admin = 'checked';
        }
        if (array_key_exists('Dealer', $jroles)) {
            $dealer = 'checked';
        }

        if (array_key_exists('Customer', $jroles)) {
            $customer = 'checked';
        }

        if (array_key_exists('Salesperson', $jroles)) {
            $salesperson = 'checked';
        }

        if (in_array('Admin', $jroles)) {
            $admin = 'checked';
        }



        $value = "<div id=''>
       <div class='form-check form-check-inline'>
       <input class='form-check-input' type='checkbox' {$admin} value='Admin' name='roles[Admin]' id='check-admin-role' ><label for='check-admin-role'>Admin</label></div>
       <div class='form-check form-check-inline'>
       <input  class='form-check-input' type='checkbox' value='Dealer' {$dealer} name='roles[Dealer]' id='check-dealer-role' >
        <label for='check-dealer-role'>Dealer</label> </div>
        <div class='form-check form-check-inline'>
        <input  class='form-check-input' type='checkbox' value='Customer' name='roles[Customer]' {$customer} id='check-customer-role'  ><label for='check-customer-role'>Customer</label>
        </div>
            <div class='form-check form-check-inline'>
            <input  class='form-check-input' type='checkbox' value='Salesperson' name='roles[Salesperson]' {$salesperson} id='check-sales-person-role'  ><label for='check-sales-person-role'>Sales Person</label>
            </div>
       
        </div>";
        */


        return response()->json([
            'status' => 200,
            'user'   => $user,
            'roles' => $user->roles,
            //'value'  => $value
        ]);
    }


    public function get_change_password($id)
    {

        $user = $this->_row('users', $id);
        return response()->json([
            'status' => 200,
            'user'   => $user
        ]);
    }

    public function update_user(Request $request)
    {

        $request->validate([
            /*   'email' => 'required|unique:users', */]);
        $id             = $request->id;
        $user           = User::find($id);
        $user->email    = $request->email;
        $user->first_name =  $request->first_name;
        $user->last_name =  $request->last_name;
        $user->roles    = json_encode($request->roles);
        $user->status   = $request->status;
        $result         = $user->save();

        flash("User has been updated successfully!")->success();
        return back();
    }

    public function change_password(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'password'  => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $result = $user->save();
        flash("Password has been updated successfully!")->success();
        return back();
    }


    public function logout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            return redirect('/admin/login');
        }
    }
}
