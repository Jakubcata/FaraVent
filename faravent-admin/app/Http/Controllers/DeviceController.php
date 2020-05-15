<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EspBinary;
use App\Device;
use Illuminate\Support\Str;
use Helper;
use App\MqttClient;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        return view("devices", ["path"=>"devices","devices"=>Device::all()]);
    }

    public function addDevice(Request $request)
    {
        $inTopic = $request->name."_in";
        $outTopic = $request->name."_out";
        $updateTopic = $request->name."_update";


        Device::create(["name"=>$request->name,
                        "verbose_name"=>$request->verboseName,
                        "description"=>"",
                        "active"=>true,
                        "in_topic"=>$inTopic,
                        "out_topic"=>$outTopic,
                        "update_topic"=>$updateTopic,
                    ]);
        MQTTClient::subscribe($outTopic);
        return back();
    }

    public function removeDevice(Request $request)
    {
        $device = Device::find($request->id);
        MQTTClient::unsubscribe($device->out_topic);
        $device->delete();

        return back();
    }

    public function showDevice(Request $request)
    {
        $device = Device::find($request->id);
        return view("device", ["path"=>"device".$device->id,"device"=>$device]);
    }

    public function lastMessagesSnippet(Request $request)
    {
        $device = Device::find($request->id);

        return view("mqtt.messages_table", [
            "lastMessages"=>$device->lastMessages(),
        ]);
    }
}
