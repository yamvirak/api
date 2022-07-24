<?php

namespace App\TSPIWT\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;
use App\Model\Setup\Telegram;

class BotRegister extends Controller
{
    

    // =========================================================================================>> Register
    public static function newRegister($user, $chanel = "Online", $code = ""){
        if($user){

            //$chatID = env('REGISTER_CHANNEL_CHAT_ID'); 
            $chatID = Telegram::where('slug', 'REGISTER_CHANNEL_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => ' <b>ចុះឈ្មោះចូលប្រព័ន្ធ</b>
 - ឈ្មោះ: '.$user->name.'
 - លេខទូរស័ព្ទ: '.$user->phone.'
 - លេខកូដផ្ទៀងផ្ទាត់: '.$code.'

',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }

    public static function registerVerify($user, $chanel = "Online", $code = ""){
        if($user){

            //$chatID = env('REGISTER_CHANNEL_CHAT_ID'); 
            $chatID = Telegram::where('slug', 'REGISTER_CHANNEL_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => ' <b>ផ្ទៀងផ្ទាត់កូដដោយជោគជ័យ</b>
 - លេខសម្គាស់ខ្លួន: '.$user->uid.'
 - ឈ្មោះ: '.$user->name.'
 - លេខទូរស័ព្ទ: '.$user->phone.'
',
'parse_mode' => 'HTML', 
'reply_to_message' => 14
            ]);

            return $res; 
        }
    }

     // =========================================================================================>> Register
     public static function registerRequestVerifyCode($user, $chanel = "Online", $code = ""){
        if($user){

            //$chatID = env('REGISTER_CHANNEL_CHAT_ID'); 
            $chatID = Telegram::where('slug', 'REGISTER_CHANNEL_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => ' <b>កូដផ្ទៀងផ្ទាត់ឡើងវិញដោយជោគជ័យ</b>
 - ឈ្មោះ: '.$user->name.'
 - លេខទូរស័ព្ទ: '.$user->phone.'
 - លេខកូដផ្ទៀងផ្ទាត់: '.$code.'

',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }
 
}
