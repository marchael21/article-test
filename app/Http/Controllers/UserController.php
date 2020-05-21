<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\Hash; 
use Auth;
 
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::id();

        $roleOpt = Role::get();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = User::with('role');

        if (isset($request->name) && $request->name !=='') {
            $query->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if (isset($request->username) && $request->username !=='') {
            $query->where('username', 'LIKE', '%'.$request->username.'%');
        }

        if (isset($request->email) && $request->email !=='') {
            $query->where('email', 'LIKE', '%'.$request->email.'%');
        }

        if (isset($request->role) && $request->role !=='') {
            $query->where('role_id', $request->role);
        }

        if (isset($request->status) && $request->status !=='') {
            if ($request->status == 'active') {
                $query->where('active', 1)->where('block', 0);
            } elseif ($request->status == 'unverified') {
                $query->whereNull('active')->where('block', 0);
            } elseif ($request->status == 'inactive') {
                $query->where('active', 0)->where('block', 0);
            } elseif ($request->status == 'blocked') {
                $query->where('block', 1);
            } else {}
        }

        $users = $query->paginate($pageLimit);

        // Search Filters
        $searchFilter = array();
        $searchFilter['role'] = isset($request->role) && $request->role !== '' ? $request->role : '';
        $searchFilter['status'] = isset($request->status) && $request->status !== '' ? $request->status : '';
        $searchFilter['username'] = isset($request->username) && $request->username !== '' ? $request->username : '';
        $searchFilter['name'] = isset($request->name) && $request->name !== '' ? $request->name : '';
        $searchFilter['email'] = isset($request->email) && $request->email !== '' ? $request->email : '';
        $searchFilter['page_limit'] = $pageLimit;

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/user/list'),
                'name'  => 'User',
                'icon'  => 'fas fa-users',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.users.list', ['users' => $users], compact('pageData', 'roleOpt', 'searchFilter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();

        $roleOpt = Role::get();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/user/list'),
                'name'  => 'User',
                'icon'  => 'fas fa-users',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Create',
                'icon'  => '',
                'class' => 'active'
            ), 
        );

        return view('pages.users.create', compact('pageData', 'roleOpt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {

        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->active = 1;
        $user->block = 0;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);

        try {

            // save user
            if($user->save()) {

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'User Created!.',
                    'text'  => 'User has been registered successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('user/list')->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('user/create')->withInput()->with('alertMsg', $alertMsg);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roleOpt = Role::get();
        $user = User::with('role')->find($id);

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/user/list'),
                'name'  => 'User',
                'icon'  => 'fas fa-users',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Edit',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.users.edit',['user' => $user], compact('pageData', 'roleOpt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {

        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = user::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->active = isset($request->active) ? $request->active : 0;
        $user->block = isset($request->block) ? $request->block : 0;

        // $user->role_id = $request->role;
        if(isset($request->password) && !empty($request->password)) {
            $user->password = Hash::make($request->password); 
        }

        try {

            // save user
            if($user->save()) {                
                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'User Updated!.',
                    'text'  => 'User has been updated successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect(session('links')[2])->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('user/edit/'.$id)->withInput()->with('alertMsg', $alertMsg);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        try {

            $user->delete();

            $alertMsg = array(
                'title' => 'Success!',
                'text'  => 'User "' . $user->name . '" has been deleted successfully".' ,
                'icon'  => 'success'
            );
            return redirect('/user/list')->with('alertMsg', $alertMsg);

        } catch (\Exception $e) {

            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );
            
            return redirect('/user/list')->with('alertMsg', $alertMsg);
        }
    }
}
