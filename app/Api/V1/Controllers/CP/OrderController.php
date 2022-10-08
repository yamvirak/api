<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Carbon\Carbon;

use App\Api\V1\Controllers\ApiController;
use App\Model\Order\Order; 

class OrderController extends ApiController
{
    use Helpers;
   
    function listing(Request $req){
       
        $data           = Order::select('*')
        ->with([
            'cashier',
            'details',
            'customer'
        ]); 


       // ==============================>> Date Range
       if($req->from && $req->to){
            $data = $data->whereBetween('created_at', [$req->from." 00:00:00", $req->to." 23:59:59"]);
        }
        
        // =========================== Search receipt number
        if( $req->receipt_number && $req->receipt_number !="" ){
            $data = $data->where('receipt_number', $req->receipt_number);
        }

        // ===========================>> If Not admin, get only record that this user make order
        $user         = JWTAuth::parseToken()->authenticate();
        if($user->type_id == 2){ //Manager
            $data = $data->where('cashier_id', $user->id); 
        }
    
        $data = $data->orderBy('id', 'desc')
        ->paginate( $req->limit ? $req->limit : 10);
        return response()->json($data, 200);
    }
    

    function delete($id = 0){
        
        $data = Order::find($id);

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
    
    function record(Request $req){

        $user         = JWTAuth::parseToken()->authenticate();
        $data           = Order::select('*')
        ->with([
            'cashier',
            'details',
            'customer'
        ]); 


        // ==============================>> Date Range
        if($req->from && $req->to){
            $data = $data->whereBetween('created_at', [$req->from." 00:00:00", $req->to." 23:59:59"]);
        }
    
        $data = $data->orderBy('id', 'desc')
        ->get();
        $total = $data->sum('total_price_khr');
        $payload = [
            // 'type'          => $type,
            // 'province'      => $province,  
            // 'department'    => $department,  
            // 'category'      => $category,
            'from'          => $req->from,
            'to'            => $req->to,
            'total'         => $total,
            'user'          => $user->name,
            'data'          => $data,
            

        ];
        return $payload;

    }
    function invoice(Request $req, $id = 0){
       
        $data           = Order::select('*')
        ->with([
            'cashier',
            'details',
            'customer'
        ])
        ->where('id',$id); 
        $data = $data->orderBy('id', 'desc')
        ->get();
        
        $payload = [
            'data'          => $data,

        ];
        return $payload;

    }
}
