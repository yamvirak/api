<?php

namespace App\TSPIWT\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;
use App\Model\Setup\Telegram;

class BotSubmitApplication extends Controller
{
    

    // =========================================================================================>> Register
    public static function submittedApplication($application){
        if($application){

            // $chatID = env('SUBMITTED_APPLICATION_CHANNEL_CHAT_ID'); 
            $chatID = Telegram::where('slug', 'SUBMITTED_APPLICATION_CHANNEL_CHAT_ID')->first()->chat_id;

            $res = TelegramBot::sendMessage([
                'chat_id' => $chatID, 
                'text' => ' <b>បានដាក់ពាក្យ</b>
* លេខដាក់ពាក្យ: '.$application->code.'
* ស្ថានភាពដាក់ពាក្យ: '.$application->status->kh_name.'
* កាលបរិច្ឆេទដាក់ពាក្យ: '.$application->created_at.'
* <b>អ្នកដាក់ពាក្យ</b> : 
    - ឈ្មោះ: '.$application->kh_name.'
    - ភេទ: '.$application->sex->kh_name.'
    - លេខទូរស័ព្ទ: '.$application->phone.'
* <b>ឆ្នាំសិក្សានិងជំនាញ</b>
    - ជំនាញ: '.$application->major->name.'
    - តម្លៃសិក្សា: '.$application->major->price.'USD

',               'parse_mode' => 'HTML'
            ]);

            return $res; 
        }
    }
 
}
