<?php

namespace App\POS\Bot;

use App\Http\Controllers\Controller;
use App\Model\Setup\Telegram;

use \LINE\LINEBot\SignatureValidator as SignatureValidator;

class LineBot extends Controller
{
    // =========================================================================================>> Register
    public static function loginData($data){
        if($data){

            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);

            $message = 'Transaction #'.$data->id. ''.$data->name;

            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
            $response = $bot->pushMessage(env('LINE_USER_ID'), $textMessageBuilder);

            // $res = $bot->pushMessage(
            //     env('LINE_USER_ID'),
            //     new RawMessageBuilder(
            //         [
            //             'type' => 'flex',
            //             'altText' => 'Shopping',
            //             'contents' => [
            //                 'type' => 'carousel',
            //                 'contents' => [
            //                     [
            //                         'type' => 'bubble',
            //                         'hero' => [
            //                             'type' => 'image',
            //                             'size' => 'full',
            //                             'aspectRatio' => '20:13',
            //                             'aspectMode' => 'cover',
            //                             'url' => 'https://example.com/photo1.png'
            //                         ],
            //                         'body' => [
            //                             'type' => 'box',
            //                             'layout' => 'vertical',
            //                             'spacing' => 'sm',
            //                             'contents' => [
            //                                 [
            //                                     'type' => 'text',
            //                                     'text' => 'Arm Chair, White',
            //                                     'wrap' => true,
            //                                     'weight' => 'bold',
            //                                     'size' => 'xl'
            //                                 ],
            //                                 [
            //                                     'type' => 'box',
            //                                     'layout' => 'baseline',
            //                                     'contents' => [
            //                                         [
            //                                             'type' => 'text',
            //                                             'text' => '$49',
            //                                             'wrap' => true,
            //                                             'weight' => 'bold',
            //                                             'size' => 'xl',
            //                                             'flex' => 0
            //                                         ],
            //                                         [
            //                                             'type' => 'text',
            //                                             'text' => '.99',
            //                                             'wrap' => true,
            //                                             'weight' => 'bold',
            //                                             'size' => 'sm',
            //                                             'flex' => 0
            //                                         ]
            //                                     ]
            //                                 ]
            //                             ]
            //                         ],
            //                         'footer' => [
            //                             'type' => 'box',
            //                             'layout' => 'vertical',
            //                             'spacing' => 'sm',
            //                             'contents' => [
            //                                 [
            //                                     'type' => 'button',
            //                                     'style' => 'primary',
            //                                     'action' => [
            //                                         'type' => 'uri',
            //                                         'label' => 'Add to Cart',
            //                                         'uri' => 'https://example.com'
            //                                     ]
            //                                 ],
            //                                 [
            //                                     'type' => 'button',
            //                                     'action' => [
            //                                         'type' => 'uri',
            //                                         'label' => 'Add to wishlist',
            //                                         'uri' => 'https://example.com'
            //                                     ]
            //                                 ]
            //                             ]
            //                         ]
            //                     ],
            //                     [
            //                         'type' => 'bubble',
            //                         'hero' => [
            //                             'type' => 'image',
            //                             'size' => 'full',
            //                             'aspectRatio' => '20:13',
            //                             'aspectMode' => 'cover',
            //                             'url' => 'https://example.com/photo2.png'
            //                         ],
            //                         'body' => [
            //                             'type' => 'box',
            //                             'layout' => 'vertical',
            //                             'spacing' => 'sm',
            //                             'contents' => [
            //                                 [
            //                                     'type' => 'text',
            //                                     'text' => 'Metal Desk Lamp',
            //                                     'wrap' => true,
            //                                     'weight' => 'bold',
            //                                     'size' => 'xl'
            //                                 ],
            //                                 [
            //                                     'type' => 'box',
            //                                     'layout' => 'baseline',
            //                                     'contents' => [
            //                                         [
            //                                             'type' => 'text',
            //                                             'text' => '$11',
            //                                             'wrap' => true,
            //                                             'weight' => 'bold',
            //                                             'size' => 'xl',
            //                                             'flex' => 0
            //                                         ],
            //                                         [
            //                                             'type' => 'text',
            //                                             'text' => '.99',
            //                                             'wrap' => true,
            //                                             'weight' => 'bold',
            //                                             'size' => 'sm',
            //                                             'flex' => 0
            //                                         ]
            //                                     ]
            //                                 ],
            //                                 [
            //                                     'type' => 'text',
            //                                     'text' => 'Temporarily out of stock',
            //                                     'wrap' => true,
            //                                     'size' => 'xxs',
            //                                     'margin' => 'md',
            //                                     'color' => '#ff5551',
            //                                     'flex' => 0
            //                                 ]
            //                             ]
            //                         ],
            //                         'footer' => [
            //                             'type' => 'box',
            //                             'layout' => 'vertical',
            //                             'spacing' => 'sm',
            //                             'contents' => [
            //                                 [
            //                                     'type' => 'button',
            //                                     'style' => 'primary',
            //                                     'color' => '#aaaaaa',
            //                                     'action' => [
            //                                         'type' => 'uri',
            //                                         'label' => 'Add to Cart',
            //                                         'uri' => 'https://example.com'
            //                                     ]
            //                                 ],
            //                                 [
            //                                     'type' => 'button',
            //                                     'action' => [
            //                                         'type' => 'uri',
            //                                         'label' => 'Add to wishlist',
            //                                         'uri' => 'https://example.com'
            //                                     ]
            //                                 ]
            //                             ]
            //                         ]
            //                     ],
            //                     [
            //                         'type' => 'bubble',
            //                         'body' => [
            //                             'type' => 'box',
            //                             'layout' => 'vertical',
            //                             'spacing' => 'sm',
            //                             'contents' => [
            //                                 [
            //                                     'type' => 'button',
            //                                     'flex' => 1,
            //                                     'gravity' => 'center',
            //                                     'action' => [
            //                                         'type' => 'uri',
            //                                         'label' => 'See more',
            //                                         'uri' => 'https://example.com'
            //                                     ]
            //                                 ]
            //                             ]
            //                         ]
            //                     ]
            //                 ]
            //             ]
            //         ]
            //     )
            // );
    
            // $this->assertEquals(200, $res->getHTTPStatus());
            // $this->assertTrue($res->isSucceeded());
            // $this->assertEquals(200, $res->getJSONDecodedBody()['status']);

        
        }
    }

    
 
}
