<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUsagesRequest;
use App\Http\Requests\ProductUpdateRequest;
class UserController extends Controller
{
    protected $product;
    public function __construct(ProductModel $product)
    {
        $this->middleware('auth');
        $data = array();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function CreateUser()
    {
        return view('pages.user.index');
    }

    public function getUserList()
    {
        $data['users'] = DB::table('users')->get();
        return view('pages.user.user-list', compact('data'));
    }

     //get edit product 
    public function geteditUser($userId){
        $data['users'] = DB::table('users')->where('id', $userId)->first();

        return view('pages.user.edit-user', compact('data'));
    }

    //get update user
    public function updateUser(Request $request){
       $update = DB::table('users')->where('id', $request->id)->update([ 'name' => $request->name, 'email' => $request->email ]);
       if ($update) {
           return redirect()->back()->with('msg', 'Updated Successfully.');
        }else{
           return redirect()->back()->with('msg', 'You did not give any new value !!');
        } 

    }

    //get create user
    public function create(Request $request){
            $data             = [];
            $data['name']     = $request->name;
            $data['email']    = $request->email;
            $data['user_type']    = $request->type;
            $data['password'] = Hash::make($request->password);

            $checkEmail = DB::table('users')->where('email', $request->email)->count();
            if ($checkEmail == 0) {
                $save = DB::table('users')->insert($data);
               if ($save) {
                   return redirect()->back()->with('msg', 'User created Successfully.');
                }else{
                   return redirect()->back()->with('msg', 'You did not give any new value !!');
                }
            }else{
                return redirect()->back()->with('error', 'email already exists !!');
            }
        

    }


   


}
