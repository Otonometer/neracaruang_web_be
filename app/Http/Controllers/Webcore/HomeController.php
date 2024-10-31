<?php

namespace App\Http\Controllers\Webcore;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\AppBaseController;
use App\User;
use App\Repositories\UserRepository;
use Flash;
use Response;
use File;


class HomeController extends AppBaseController
{
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    
    public function profile()
    {
        $user = Auth::user();
        return view('profile')->with('userlogin', $user);
    }

    public function update_profile(Request $request){
        $user = Auth::user();
        $input = $request->all();

        $fields = [
            'name' => $input['name'],
            'email' => $input['email'], 
        ];

        $image = @$request->file('image');
        if(!empty($image)) {

            $validator = Validator::make($request->all(), [
                'image' => 'required|file|mimes:png,jpg,jpeg'
            ]);
            if ($validator->fails()) {
                return redirect('post/create')
                    ->withErrors($validator)
                    ->withInput($input);
            }
            $fields['image'] = saveImageOriginalName($image,'users', true, $user->image);
        }
        
        if(!empty($input['password'])){
            if(@$input['password'] != @$input['password2']){
                return redirect()->back()->withInput($input)->withErrors(['message' => 'Password didnot match!']);
            }
            
            $fields['password'] = Hash::make($input['password']);
        }

        $this->userRepository->update($fields, $user->id);
        Flash::success('Profile updated successfully.');
        return redirect(route('profile'));
    }
}
