<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Expense\Expense; 

class ExpenseController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){
       
        $data           = Expense::select('*')
        ->with([
            'type'
        ]);
        if( $req->key && $req->key !="" ){
            $data = $data->where('receipt_number', 'like','%'.$req->key.'%');
        }
        if( $req->type && $req->type !="" ){
            $data = $data->where('type_id', 'like','%'.$req->type.'%');
        }

        $data = $data->orderBy('id', 'desc')->paginate( $req->limit ? $req->limit : 10);
        return response()->json($data, 200);
    }

    function create(Request $req){

        //==============================>> Check validation
        $this->validate($req, [
            
            'total'             => 'required|max:20',
            'type_id'           => 'required|exists:expenses_type,id'
        ], 
        [
            'total.required' => 'Please enter the total.',
            'total.max' => 'Total cannot be more than 20 characters.',
            'type_id.exists' => 'Please select correct type.'
        ]);

        //==============================>> Start Adding data

        $expense                =   New Expense; 
        $expense->receipt_number =   $this->generateReceiptNumber();
        $expense->total         =   $req->total;  
        $expense->type_id       =   $req->type_id; 

        $expense  ->save(); 
    
        return response()->json([
            'expense' => $expense,
            'message' => 'Expense has been successfully created.'
        ], 200);
        
    }
  
    function update(Request $req, $id=0){

         //==============================>> Check validation
         $this->validate($req, [
            
            'total'             =>  'required|max:20',
            'type_id'           =>  'required|exists:expenses_type,id'

        ], 
        [
            'total.required' => 'Please enter the total.', 
            'total.max' => 'Total cannot be more than 20 characters.',
            'type_id.exists' => 'Please select correct type.'
        ]);
        
        //==============================>> Start Updating data
        $expense                         = Expense::find($id);
        if( $expense){

            $expense->total              = $req->input('total');
            $expense->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Expense has been updated Successfully',
                'expense' => $expense,
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid data.',
            ], 400);

        }

       

    }

     function delete($id = 0){
        
        $data = Expense::find($id);

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

    function generateReceiptNumber(){
        $number = rand(1000000, 9999999); 
        $check = Expense::where('receipt_number', $number)->first(); 
        if($check){
            return $this->generateReceiptNumber();
        }

        return $number; 
    }
    
}
