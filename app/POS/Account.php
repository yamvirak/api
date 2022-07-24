<?php

namespace App\TSPIWT;

use Carbon\Carbon;

use App\Model\User\Main as User;
use App\Model\User\Code as Code;

use App\Model\Transaction\USD as USDTrx; //For calculating today PV. 

class Account{
    
  	public static function generateUid(){

        $uid = 'TSI'.rand(10000000, 9999999); 
        $user = User::where('uid', $uid)->first(); 
        if($user){
            return self::generateUid(); 
        }
        
        return $uid; 

    }
    public static  function generateVerificationCode(){
        
        $lastCode = Code::select('id')->orderBy('id', 'DESC')->first(); 
        $code = 1;
        if($lastCode){
            $code = $lastCode->id+1; 
        }

        if( $code >= 1 && $code < 10 ){
            $code = '00000'.$code; 
        }else  if( $code >= 10 && $code < 100 ){
             $code = '0000'.$code; 
        }else  if( $code >= 100 && $code < 100000 ){
             $code = '000'.$code; 
        }else  if( $code >= 100000 && $code < 1000000 ){
             $code = '00'.$code; 
        }
        return $code; 
    }
    
  
}
