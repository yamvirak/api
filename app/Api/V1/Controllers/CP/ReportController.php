<?php

namespace App\Api\V1\Controllers\CP;

// ==================================> Core 
use Illuminate\Http\Request;
// 
use App\Api\V1\Controllers\ApiController;
use App\Model\Order\Order; 

class ReportController extends ApiController

{
    protected $route;
    public function __construct(){
        // $this->route = "cp";
        
    }
   
    public function report(Request $req){
       $data = Order::select('*')
       ->with([
        'details',
        'cashier',
        'customer'
       ])
       ->orderBy('id', 'desc')
       ->get();
       //return $data;
       return view($this->route.'.sale-report', ['route'=>$this->route, 'data'=>$data, 'from'=>$req->from, 'to'=>$req->to]);
    }
}
