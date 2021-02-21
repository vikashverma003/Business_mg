<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\User;
use Hash;
class DepartmentController extends Controller
{
  protected $depObj;
 

    public function __construct(Department $dep)
    {
        $this->depObj=$dep;
       
    }

    /**
     * Login page
     */

    public function createdepartment(Request $request){
     
       $createDepartment=$this->depObj->createDepartment([
                'name'       =>  $request->name??null,
                'status'     =>  $request->status??null,
            ]);
       return redirect('admin/departmentlist')->with('status','Department Added Successfully');
    }

    public function delete_department(Request $request){
       $result=\DB::table('department')->where('id',$request->user_id)->delete();
         if($result){
         return response()->json(['success' => true,'message' => 'Department Deleted Successfully']);
      }
  }

   


}
