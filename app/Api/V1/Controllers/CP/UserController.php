<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main as User; 
use App\Model\Branch\BranchAdmin;
use App\Model\Admin\Admin;

class UserController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){
       
        $data           = User::select('*')
        ->with([
            'type',
            'admin',
            'admin.branches.branch'
        ]);
        
        if( $req->key && $req->key !="" ){
            $data = $data->where('name', 'like','%'.$req->key.'%')->orWhere('phone', 'like','%'.$req->key.'%');
        }
        $data = $data->orderBy('id', 'desc')->paginate( $req->limit ? $req->limit : 20);
        return response()->json($data, 200);
    }

    function changePassword(Request $req, $id = 0){

        //==============================>> Check validation
        $this->validate($req, [
            
            'password'             => 'required|min:6|max:20',
            'confirmed_password'   => 'required|min:6|max:20'
        ]);

        //==============================>> Start Adding data

        $user = User::find($id); 
        if($user){

            $user->password                 = bcrypt($req->password); 
            $user->password_last_updated_at = now(); 
            $user->save(); 

            return response()->json([
                'message' => 'Password has been updated.'
            ], 200);

        }else{
            return response()->json([
                'message' => 'Invalid user.'
            ], 400);
        }
    
       
        
    }
    function create(Request $req){

        //==============================>> Check validation
        $this->validate($req, [
            'name'                 => 'required|max:40',
            'phone'                =>  [
                                        'required', 
                                        'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                                        Rule::unique('user', 'phone')
                                    ],
            'email'                 =>[
                                        'required',
                                        Rule::unique('user','email')
                                    ],
            'password'             => 'required|min:6|max:20',
            'branch_id'            => 'required',
            'role_id'              => 'required',
        ], 
        [
                'name.required'     => 'Please input user name',
                'name.max'          => 'Name not more than 40 letters',
                'branch_id.required'=> 'Please input Branch',
                'phone.required'    => 'Please input phone number',
                'phone.regex'       => 'Please input correct phone number',
                'phone.unique'      => 'This number is already to use',
                'password.required' => 'Please input password',
                'password.min'      => 'Password cannot be less than 6 characters',
                'password.max'      => 'Password no longer than 20 characters',
                'email.required'    => 'Please input email',
                'email.unique'      => 'This email is already to use',
                'role_id.required'  => 'Please input Role',
        ]);

        //==============================>> Start Adding data

        $data               =   New User; 
        $data->name         =   $req->name;  
        $data->phone        =   $req->phone; 
        $data->type_id      =   2;  
        $data->email        =   $req->email; 
        $data->is_email_verified = 1;  
        $data->password     =   bcrypt($req->password); 
        $data->is_notified_when_login = 1;  
        $data->is_notified_when_login_with_unknown_device        =   1; 
        $data->is_active    =   1;

        $data  ->save(); 

        if($data){
            $admin              = New Admin;
            $admin->user_id     = $data->id;
            $admin->is_supper   = 0;
            $admin->save();
            if($admin){
                $branch             = New BranchAdmin;
                $branch->admin_id   = $admin->id;
                $branch->branch_id  = $req->branch_id;
                $branch->role_id    = $req->role_id;
                $branch->save(); 
            }
        }
    
        return response()->json([
            'User' => $data,
            'message' => 'User has been successfully created.'
        ], 200);
        
    }
  
    function update(Request $req, $id=0){

         //==============================>> Check validation
         $this->validate($req, [
            'name'                 => 'required|max:40',
            'phone'                =>  [
                                        'required', 
                                        'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/', 
                                        Rule::unique('user', 'phone')->ignore($id)
                                    ],
            'email'                 =>[
                                        'required',
                                        Rule::unique('user','email')->ignore($id)
                                    ],
            'branch_id'            => 'required',
            'role_id'              => 'required',
        ], 
        [
            'name.required'     => 'Please input user name',
            'name.max'          => 'Name not more than 40 letters',
            'branch_id.required'=> 'Please input Branch',
            'phone.required'    => 'Please input phone number',
            'phone.regex'       => 'Please input correct phone number',
            'phone.unique'      => 'This number is already to use',
            'email.required'    => 'Please input email',
            'email.unique'      => 'This email is already to use',
            'role_id.required'  => 'Please input Role',
    ]);
        
        //==============================>> Start Updating data
        $data                         = User::find($id);
        if( $data){

            $data->name         =   $req->name;  
            $data->phone        =   $req->phone; 
            $data->type_id      =   2;  
            $data->email        =   $req->email; 
            $data->is_email_verified = 1;  
            $data->password     =   bcrypt($req->password); 
            $data->is_notified_when_login = 1;  
            $data->is_notified_when_login_with_unknown_device        =   1; 
            $data->is_active    =   1;
    
            $data  ->save(); 
    
            if($data){
                
                $admin              = Admin::where('user_id',$data->id)->first();
                $admin->is_supper   = 0;
                $admin->save();
                if($admin){
                    
                    $branch             = BranchAdmin::where('admin_id',$admin->id)->first();
                    $branch->branch_id  = $req->branch_id;
                    $branch->role_id    = $req->role_id;
                    $branch->save(); 
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User has been updated Successfully',
                'Data' => $data,
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid data.',
            ], 400);

        }

       

    }

     function delete($id = 0){
        
        $data = User::find($id);

        //==============================>> Start deleting data
        if($data){

            $data->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data has been deleted',
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid data.',
            ], 400);

        }

        
    }  
}