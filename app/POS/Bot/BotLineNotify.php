<?php

namespace App\POS\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;
use App\Model\Setup\Telegram;

class BotLineNotify extends Controller
{
    

    // =========================================================================================>> Register
    public static function sendNotification($data){
        $line = new LineModel();
        $line->setToken('DoxLjTok6YsY4o33DVmTa9nKTSWdhMsBb2Ju8h2prKS');
        $line->setMsg('Transaction');
        $line->addMsg('*****************************');
        $line->addMsg('💸 : ข้อความ'.$data->id);
        $line->addMsg('Name: '.$data->name);
        $line->addMsg('Phone: '.$data->phone);
        $line->addMsg('Email: '.$data->email);
        $line->addMsg('*****************************');

        if($line->sendNotify()){
            echo "ส่งแล้ว";
        }else{
            echo "<pre>";
            print_r($line->getError());
            echo "</pre>";
        }

    }
}
