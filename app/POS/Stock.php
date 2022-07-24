<?php

namespace App\POS;

use App\Model\Member\Main as Member;
use App\Model\Member\Stock as MemberStock;
use App\Model\Package\Main as MasterStock;
use App\Model\Package\Main as Package;
use App\Model\Product\Product;
use App\Model\Product\Stock as Stocks;
use App\Model\Order\Main as Order;
use App\Model\Purchase\Main as Purchase;
use App\Model\DistributorPackage\DistributorPackage;

class Stock{

    // ==========================================================================>> Master Stock
    public static function getBranch($productId = 0, $branchId = 0){
        $branch = Stocks::where([
            'product_id' => $productId,
            // 'branch_id' => $branchId
        ])->first(); 
        return $branch; 
    }

    public static function updateStock($trx){

        $details = $trx->details; 
        foreach($details as $detail){
           
            $branch = Self::getBranch($detail->product_id, 1); 
           
            // ===> decrease product stock
            $branch->available_stock = $branch->available_stock - $detail->qty;
            $branch->save();
    
        }
       

    }
    
    // ==========================================================================>> Distributor Package
    public static function distributorPackages($distributorId = 0, $packageId = 0){
    
        $distributorPackage = DistributorPackage::where([
            'distributor_id' => $distributorId, 
            'package_id' => $packageId
        ])->first(); 

        if(!$distributorPackage){
            //Check if package is valid
            $package = Package::find($packageId);

            if($package){

                $distributorPackage = new DistributorPackage; 
                $distributorPackage->distributor_id = $distributorId; 
                $distributorPackage->package_id = $packageId; 
                $distributorPackage->available_stock = 0; 
                $distributorPackage->save(); 
            } 
        }
        return $distributorPackage; 
    }
    
    public static function updateDistributorPackage($type = 'stock-in',  $trx, $distributorId = 0){

        $details = $trx->details; 
        $stocks = []; 

        foreach($details as $detail){
           
            $distributorPackage = Self::distributorPackages($distributorId, $detail->package_id); 
            if($distributorPackage){
                if($type == 'stock-in'){ // This Auction happens when Upline Distributor approves Downline Distributor's Purchased Request
                    $distributorPackage->available_stock = $distributorPackage->available_stock + $detail->qty; 
                }else{
                    $distributorPackage->available_stock = $available_stock->available_stock - $detail->qty; 
                }
            
                $distributorPackage->save();
                $stocks[] = $distributorPackage; 
            
                //Trx can be Purchase
                $detail->member_stock_id = $distributorPackage->id; 
                $detail->save(); 

            }
    
        }

        return $stocks; 

    }

   

    // Master Stock
    public static function masterStocks( $productId = 0){
    
        $masterStock = Package::find($productId); 
        return $masterStock; 
    }

    // Update master stock
    public static function updateMasterStock($type="", $trx =0){
        $details = $trx->details; 
        foreach($details as $detail){
           
            $masterStock = Self::masterStocks($detail->product_id); 

            if($type == 'stock-in'){ // This Auction happens when Master Approves Branch's Purchased Request
               

            }else{
                $masterStock->qty = $masterStock->qty - $detail->qty; 
            }
    
            $masterStock->save();
    
        }
    }

    public static function updateMemberStockIn($type = 'stock-in',  $trx){

        $details = $trx->details; 
        foreach($details as $detail){
           
            $memberStock = Self::memberStocks($trx->member_id, $detail->product_id); 

            if($type == 'stock-in'){ // This Auction happens when Master Approves Branch's Purchased Request
                $memberStock->qty = $memberStock->qty + $detail->qty; 
                $memberStock->save();
            }
        }
    }

    public static function checkIfHaveStock( $user = [] ){
       $data = Member::where('user_id', $user['id'])->first(); 
        if(!$data){
            return false;
        }

        if($data->distributor_type_id){
            return true;

        }

        return false;

    }

    public static function stockInfo( $user = [] ){
        $data = Member::where('user_id', $user['id'])
                        ->with(['user', 'distributorType'])
                        ->first(); 
        if(!$data){
            return [];
        }

        if(!$data->distributor_type_id){
            return [];
        }

        if($data->distributor_type_id){
            return  [
                'distributor_type'          => $data->distributorType->name ?? '',
                'distributor_name'          => $data->distributor_name ?? '',
                'distributor_expired'       => $data->distributor_contract_expired ?? '',
                'distributor_phone'         => $data->distributor_phone ?? '',
                'distributor_address'       => $data->distributor_address ?? '',
                'distributor_facebook'      => $data->distributor_facebook ?? '',
                'rank_expired'              => $data->rank_expired ?? '',
                'user_name'                 => $data->user->name ?? ''
            ];
       

        }

        return false;
    }

    public static function storeTotalSale($user = []){
        $member = Member::where('user_id', $user['id'])->first();
        $totalSale = Order::where('member_id', $member->id)->sum('total_price');
        return $totalSale;
    }

    public static function storeTotalPurchase($user = []){
        $member = Member::where('user_id', $user['id'])->first();
        $totalPurchase = Purchase::where('member_id', $member->id)->sum('total_price');
        return $totalPurchase;
    }


    // ==========================================================================>> Update Disributor Stock From Customer Purchase
    public static function updateDistributorStock($type = '',  $order){

        $distributorPackage = Self::getMasterStock($order->package_id); 

        if($type == 'stock-in'){
            $distributorPackage->available_stock = $distributorPackage->available_stock + 1; 

        }else{
            $distributorPackage->available_stock = $distributorPackage->available_stock - 1; 
        }

        $distributorPackage->save();
        
        return $distributorPackage; 

    }


}
