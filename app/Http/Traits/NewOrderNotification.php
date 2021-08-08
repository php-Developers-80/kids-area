<?php


namespace App\Http\Traits;


use Pusher\Pusher;

trait NewOrderNotification
{

    public function notify($title,$message,$router,$type,$order)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['router'] = $router;
        $data['type'] = $type;
        $data['title'] = $title;
        $data['message'] =$message;
        $data['order'] =$order;
        $pusher->trigger('new-order-channel', 'App\\Events\\OrderEvent', $data);

    }//end fun
}//end class
