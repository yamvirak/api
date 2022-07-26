<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Product\Supplier; 

class SupplierController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){
       
      
        $data           = Supplier::select('*');
        
        if( $req->key && $req->key !="" ){
            $data = $data->where('name', 'like','%'.$req->key.'%')->orWhere('phone', 'like','%'.$req->key.'%');
        }
        
        $data = $data->orderBy('id', 'desc')->limit(10)->get();
        return response()->json($data, 200);
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

        $supplier               =   New Supplier; 
        $supplier->name         =   $req->name;
        $supplier->phone        =   $req->phone;
        $supplier->address      =   $req->address;  

        $supplier  ->save(); 
    
        return response()->json([
            'supplier' => $supplier,
            'message' => 'Supplier has been successfully created.'
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
        $supplier                         = Supplier::find($id);
        if( $supplier){

            $supplier->name         =   $req->name;
            $supplier->phone        =   $req->phone;
            $supplier->address      =   $req->address;  
    
            $supplier  ->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Supplier has been updated Successfully',
                'supplier' => $supplier,
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
