<?php

namespace App\TSPIWT\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;
use App\Model\Setup\Telegram;

class BotForgetPassword extends Controller
{
    

    // =========================================================================================>> Register
    public static function newForgetPassword($user, $chanel = "Online", $code = ""){
        if($user){

            $chatID = Telegram::where('slug', 'FORGET_PASSWORD_CHANNEL_CHAT_ID')->first()->chat_id;


            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => ' <b>សូមប្រើកូដនេះដើម្បីផ្ទៀងផ្ទាត់ការផ្លាស់ប្តូរលេខសំងាត់របស់អ្នក។ សូមអរគុណ!</b>
 - ឈ្មោះ: '.$user->name.'
 - លេខទូរស័ព្ទ: '.$user->phone.'
 - លេខកូដផ្ទៀងផ្ទាត់: '.$code.'

',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }
     // =========================================================================================>> Register
     public static function verifyResetPasswordCode($user, $chanel = "Online", $code = ""){
        if($user){

            $chatID = Telegram::where('slug', 'FORGET_PASSWORD_CHANNEL_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => ' <b>ផ្លាស់ប្តូរលេខសំងាត់ដោយជោគជ័យ អរគុណ! ។</b>
 - លេខសម្គាស់ខ្លួន: '.$user->uid.'
 - ឈ្មោះ: '.$user->name.'
 - លេខទូរស័ព្ទ: '.$user->phone.'
',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }
 
}
