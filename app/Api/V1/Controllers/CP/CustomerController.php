<?php

namespace App\Api\V1\Controllers\CP;
//=====================================================================>> Core Library
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

//=====================================================================>> Third Library
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use DB;

//=====================================================================>> Custom Library
use App\Api\V1\Controllers\ApiController;
use App\Model\Order\Customer; 

class CustomerController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){

        $data           = Customer::select('id', 'name', 'phone', 'address', 'created_at')
        ->with([
            'order'
        ])
        ->withCount('order')
        ->withCount([
            'order as total_price' => function($query){
                $query->select(DB::raw("SUM(total_price_khr) as total_price")); 
            },
        ]);

        
        if( $req->key && $req->key !="" ){
            $data = $data->where('phone','like', '%'.$req->key.'%');
        }
        $data = $data->orderBy('id', 'desc')->paginate( $req->limit ? $req->limit : 20);
        return response()->json($data, 200);
    }

    function view($id = 0){
       
        $data           = Customer::select('*')
        ->with([
            'order'
        ])
        ->withCount('order')
        ->withCount([
            'order as total_price' => function($query){
                $query->select(DB::raw("SUM(total_price_khr) as total_price")); 
            },
        ])
        ->find($id);
        
        return $data; 
    }

    function create(Request $req){

        //==============================>> Check validation
        $this->validate($req, [
            
            'name'             =>  'required|max:10',
            'phone'            =>  ['required'],
            'address'          =>  ['required'],
        ], 
        [
            'name.required' => 'Please enter the name.', 
            'name.max' => 'Name cannot be more than 10 characters.', 
            'phone.required' => 'Please enter the phone number.'
        ]);

        //==============================>> Start Adding data

        $customer                  =   New Customer; 
        $customer->name            =   $req->name;  
        $customer->phone           =   $req->phone;
        $customer->address         =   $req->address;

        $customer->save(); 
    
        return response()->json([
            'customer' => $customer,
            'message' => 'Customer has been successfully created.'
        ], 200);
        
    }
  
    function update(Request $req, $id=0){

         //==============================>> Check validation
         $this->validate($req, [
            
            'name'             =>  'required|max:20',
            'phone'            =>  ['required'],
            'address'          =>  ['required'],
        ], 
        [
            'name.required' => 'Please enter the name.', 
            'name.max' => 'Name cannot be more than 20 characters.'
        ]);
        
        //==============================>> Start Updating data
        $customer                    = Customer::find($id);
        if($customer){

            $customer->name              = $req->input('name');
            $customer->phone             = $req->input('phone');
            $customer->address           = $req->input('address');
            $customer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'customer has been updated Successfully',
                'customer' => $customer,
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid branch.',
            ], 400);

        }
    }

    function delete($id = 0){
        
        $data = Customer::find($id);

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
