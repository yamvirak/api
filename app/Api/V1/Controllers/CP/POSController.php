<?php

namespace App\Api\V1\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Dingo\Api\Routing\Helpers;
use JWTAuth;

use App\Api\V1\Controllers\ApiController;
use App\Model\Order\Order;
use App\Model\Order\Detail;
use App\Model\Order\Customer;
use App\Model\Product\Product;
use App\Model\Product\Type as ProductType;
use App\Model\Income\Income;
use App\POS\Stock;

use App\CamCyber\Bot\BotNotification; 

class POSController extends ApiController
{
    use Helpers;

    function getProducts(){

        $data = ProductType::select('id', 'name')
        ->with([
            'products:id,name,image,type_id,unit_price,discount'
        ])
        ->get(); 

        return $data;

    }
   

    function makeOrder(Request $req){

        $user         = JWTAuth::parseToken()->authenticate();
        //return $user->admin; 

        //==============================>> Check validation
        $this->validate($req, [
            'cart'             => 'required|json', 
            'discount'          => 'required'
        ]);

        $customer = Customer::where('phone',$req->phone)->first();
        if($customer){
            $order                  = new Order;
            $order->customer_id     = $customer->id; 
            $order->cashier_id      = $user->admin ? $user->admin->id : null; //TODO:: will find cashier later
            $order->receipt_number  = $this->generateReceiptNumber(); 
            $order->save(); 
        }else {

            $customer               = new Customer;
            $customer->name         = $req->name;
            $customer->phone        = $req->phone;
            $customer->address      = $req->address;
            $customer->save();

            $order                  = new Order; 
            $order->customer_id     = $customer->id; 
            $order->cashier_id      = $user->admin ? $user->admin->id : null; //TODO:: will find cashier later
            $order->receipt_number  = $this->generateReceiptNumber(); 
            $order->save(); 
        }
        //ACreate Order
        

        //Find Total Price & Order Detail
        $details = [];
        $totalPrice = 0; 
        $cart = json_decode($req->cart); 
        
        // return response()->json([
        //     $cart
        // ], 200);
        
        foreach($cart as $productId => $qty){

            $product = Product::find($productId);
            if($product){
                // return $productId;

                //Check Stock

                $details[] = [
                    'order_id'      => $order->id, 
                    'product_id'    => $productId, 
                    'qty'           => $qty, 
                    'discount'      => $product->discount,
                    'unit_price'    => $product->unit_price
                ];

                $totalPrice +=  $qty*$product->unit_price - $qty*$product->unit_price*$product->discount*0.01; 
            }
        }
        //Save tot Details
        Detail::insert($details);

        $rate               = 4000; 
        $discountAmount     = $totalPrice*$req->discount*0.01; 
        $totalPriceKhr      = $totalPrice - $discountAmount; 

        //Update Order
        $order->total_price     = $totalPrice; 
        $order->discount        = $req->discount; 
        $order->total_price_khr = $totalPriceKhr; 
        $order->total_price_usd = $totalPriceKhr/$rate; 
        $order->ordered_at      = Date('Y-m-d H:i:s'); 
        $order->save(); 

        $income                 = new Income;
        $income->type_id        =1;
        $income->receipt_number = $order->receipt_number;
        $income->total          = $totalPrice;
        $income->save();

        $stockOut          = Stock::updateStock($order);

        //ToDo: Send Notification
        // $botRes = BotNotification::order($order); 
        
        $data           = Order::select('*')
        ->with([
            'cashier',
            'details',
            //'details.product'
        ])
        ->find($order->id); 
    
        return response()->json([
           // 'cart' => $cart,
            'order' => $data,
            'details' => $details, 
            'total_price' => $totalPrice, 
            'message' => 'Order has been successfully created.'
        ], 200);
        
    }

    function generateReceiptNumber(){
        $number = rand(1000000, 9999999); 
        $check = Order::where('receipt_number', $number)->first(); 
        if($check){
            return $this->generateReceiptNumber();
        }

        return $number; 
    }
    
}
