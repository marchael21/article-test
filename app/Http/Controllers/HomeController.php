<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UpdateProfile;
use Illuminate\Support\Facades\Hash; 
use Session;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        // if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        //     return (new ArticleController())->index($request);
        // } else {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('home');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
  
        $id = Auth::id();

        $user = User::find($id);

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => '',
                'name'  => 'Profile',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.profile.profile', ['user' => $user], compact('pageData'));
    }


    /**
     * Update User Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfile $request)
    {
        $id = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;

        if(isset($request->password) && !empty($request->password)) {
            $user->password = Hash::make($request->password); 
        }

        try {

            // save user
            if($user->save()) {

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Profile Updated!',
                    'text'  => 'Profile has been updated',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('profile/'.Session::get('user.profile_name'))->with('alertMsg', $alertMsg);

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

            return redirect('profile/'.Session::get('user.profile_name'))->with('alertMsg', $alertMsg);

        }


    }



}
