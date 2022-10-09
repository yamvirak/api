<?php

namespace App\CamCyber\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;
use App\Model\Telegram\Telegram;

class BotNotification extends Controller
{

    // =========================================================================================>> Order
    public static function order($order){

        $totalProduct = ''; 
        $i = 1; 
        $total = 0; 

        foreach($order->details as $detail){
$totalProduct.= $i.'. '.$detail->product->name.'('.number_format($detail->unit_price).'រៀល) x '.$detail->qty.' = '.number_format($detail->qty*$detail->unit_price).'រៀល
'; 
            $i++; 
            $total += $detail->qty*$detail->unit_price​​​​; 

        }

        if($order){

            
            $chatID = env('ORDER_CHAT_ID'); 
           

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => '<b> វិក័យបត្របង់ប្រាក់</b>
* លេខវិក័យប័ត្រ: '.$order->receipt_number.'
* អ្នកគិតលុយ: '.$order->cashier->name.'
* កាលបរិច្ឆេទវិក័យប័ត្រ: '.$order->ordered_at.'
* <b>ផលិតផលលក់ចេញ:</b>
'.$totalProduct.'
* លុយសរុប: '.$order->total_price.'
* បញ្ចុះតម្តៃ: '.$order->discount.'
* លុយទទួលបាន: '.$order->total_price_khr.'
',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }


}