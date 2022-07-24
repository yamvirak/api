<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Income\Type; 

class IncomeTypeController extends ApiController
{
    use Helpers;
   
    function listing(){
       
        $data           = Type::select('*')
        ->withCount('incomes')
        
        ->orderBy('id', 'DESC')
        ->get();
        
        return $data; 
    }

    function create(Request $req){

        //==============================>> Check validation
        $this->validate($req, [
            
            'name'             => 'required|max:20',
        ], 
        [
            'name.required'    => 'Please enter the name.', 
            'name.max'         => 'Total cannot be more than 20 characters.',
        ]);

        //==============================>> Start Adding data

        $income_type               =   New Type; 
        $income_type->name         =   $req->name;  

        $income_type  ->save(); 
    
        return response()->json([
            'income_type' => $income_type,
            'message' => 'Income has been successfully created.'
        ], 200);
        
    }
  
    function update(Request $req, $id=0){

         //==============================>> Check validation
         $this->validate($req, [
            
            'name'             =>  'required|max:20',

        ], 
        [
            'name.required' => 'Please enter the name.', 
            'name.max' => 'Name cannot be more than 20 characters.',
        ]);
        
        //==============================>> Start Updating data
        $income_type                         = Type::find($id);
        if( $income_type){

            $income_type->name              = $req->input('name');
            $income_type->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Income has been updated Successfully',
                'income_type' => $income_type,
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid data.',
            ], 400);

        }

       

    }

     function delete($id = 0){
        
        $data = Type::find($id);

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
