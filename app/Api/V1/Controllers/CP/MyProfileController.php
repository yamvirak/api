<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Library\FileUpload;
use App\Api\V1\Controllers\ApiController;
use App\Model\User\Main as User;

use App\Model\Admin\Admin as Model;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use JWTAuth;

class MyProfileController extends ApiController
{
    use Helpers;
    function get(){
        $auth = JWTAuth::parseToken()->authenticate();
        $admin = User::select('id','name','phone','email','avatar')->where('id', $auth->id)->first();
        return response()->json($admin, 200);
    }
    
    function put(Request $request){
         $user_id = JWTAuth::parseToken()->authenticate()->id;

        $this->validate($request, [
            'name' => 'required|max:60',
            'phone' =>  [
                            'required', 
                            'regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/'
                        ],
        ]);

        //========================================================>>>> Start to update user
        $user = User::findOrFail($user_id);
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->updated_at = now();

        //Start to upload image 
        $today      = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
        $res        = FileUpload::upload($request->avatar, 'my-profile/' . $today, '');
        if ($res) {
            if (isset($res['url'])) {
                if($res['url'] != ''){
                    $user->avatar          = $res['url'];
                }
            }
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ការកែបានជោគជ័យ!', 
            'data' => $user
        ], 200);

    }
  
    function changePassword(Request $request){
        $old_password = $request->input('old_password');
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        //dd($user_id);
       $current_password = User::find($user_id)->password;
        

       if (password_verify($old_password, $current_password)){ 
            
            $this->validate($request, [
                            'password'         => 'required|min:6|max:18',
                            'confirm_password' => 'required|same:password',
            ]);

            $id=0;
            //========================================================>>>> Start to update user
            $user = User::findOrFail($user_id);
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'ការកែបានជោគជ័យ!'
            ], 200);
        }else{
         return response()->json([
                'status' => 'error',
                'message' => 'ពាក្យសម្ងាត់ចាស់របស់អ្នកមិនត្រឹមត្រូវ។ សូមបន្ថែមមួយផ្សេងទៀត'
            ], 200);   
        }
        

    }

}
