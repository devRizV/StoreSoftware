<?php

namespace App\Http\Controllers;

use DB;
use App\Models\DepartmentModel;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
class DepartmentController extends Controller
{
    protected $department;
    public function __construct(DepartmentModel $department)
    {
        $this->middleware('auth');
        $data = array();

        $this->department = $department;
    }

    public function CreateUser()
    {
        return view('pages.user.index');
    }

    //get store product
    public function getstoreDepartment(){
        return view('pages.department.index');
    }
    //get all product
    public function getAllDepartment(){
        $data['departments'] = DB::table('departments')->orderBy('pk_no', 'DESC')->get();
        return view('pages.department.department-list', compact('data'));
    }
    //get edit department
    public function geteditDepartment($id){
        $data['departments'] = DB::table('departments')->orderBy('pk_no', 'DESC')->where('pk_no', $id)->first();
        return view('pages.department.edit-department', compact('data'));
    }
    //get update department
    public function updateDepartment(Request $request){
       $update = DB::table('departments')->where('pk_no', $request->id)->update([ 'dep_name' => $request->name, 'dep_remarks' => $request->remarks ]);
       if ($update) {
           return redirect()->back()->with('msg', 'Updated Successfully.');
        }else{
           return redirect()->back()->with('msg', 'You did not give any new value !!');
        } 

    }

    //store product
    public function storeDepartment(DepartmentRequest $request){
           $resp = $this->department->StoreDepartment($request); 
           return redirect()->back()->with('msg', $resp);
    }
    //delete department 
    public function deleteDepartment(Request $request){
           $delete = DB::table('departments')->where('pk_no', $request->id)->delete();
           if ($delete) {
               return redirect()->back()->with('msg', 'Deleted Successfully.');
            }else{
               return redirect()->back()->with('msg', 'Someting wrong !!');
            } 
    }
}
