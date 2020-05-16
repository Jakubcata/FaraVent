<?php
namespace App;

class MQTTClient
{
    public static function subscribe($topic)
    {
        file_get_contents(env('MQTT_CONTROLLER')."/topics/subscribe?topic=".$topic);
    }

    public static function unsubscribe($topic)
    {
        file_get_contents(env('MQTT_CONTROLLER')."/topics/unsubscribe?topic=".$topic);
    }

    public static function sendMessage($topic, $message)
    {
        file_get_contents(env('MQTT_CONTROLLER')."/publish?topic=".urlencode($topic)."&message=".urlencode($message));
    }

    public static function topics()
    {
        return json_decode(file_get_contents(env('MQTT_CONTROLLER')."/topics/list"));
    }
}
