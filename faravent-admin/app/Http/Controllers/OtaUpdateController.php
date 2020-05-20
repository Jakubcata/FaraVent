<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EspBinary;
use App\Device;
use Illuminate\Support\Str;
use Helper;
use App\MqttClient;

class OtaUpdateController extends Controller
{
    public function index(Request $request)
    {
        $binaries = EspBinary::all();
        return view("ota", ["path"=>"ota","binaries"=>$binaries]);
    }

    public function deployBinary(Request $request)
    {
        $binary = EspBinary::find($request->id);
        $this->sendOtaUpdateMessages($binary);
        return back();
    }

    public function uploadBinary(Request $request)
    {
        $file = $request->file('binary');

        $filename = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $location = public_path().'/binaries/';
        $realName = Str::random(5)."_".$filename;

        // Upload file
        $file->move($location, $realName);

        $binary = EspBinary::create(["name"=>$filename,
                                    "real_name"=>$realName,
                                    "size"=>$fileSize,
                                    "description"=>"",
                                    "version"=>$request->version ? $request->version : "",
                                    "branch"=>$request->branch ? $request->branch : ""
                                ]);

        $this->sendOtaUpdateMessages($binary);

        if ($request->wantsJson()) {
            return response()->json([
                "name"=>$filename,
                "size"=>$fileSize,
                "status"=>"ok",
              ]);
        }
        return back();
    }

    public function deleteBinary(Request $request)
    {
        $binary = EspBinary::find($request->id);
        $binary->delete();

        return back();
    }


    private function createOtaUpdateMessages($binary)
    {
        return json_encode(["host"=>$this->removeProtocols(url('/')), "path"=>"/binaries/".$binary->real_name,"version"=>$binary->version,"branch"=>$binary->branch]);
    }

    private function removeProtocols($uri)
    {
        return explode("//", $uri)[1];
    }

    private function sendOtaUpdateMessages($binary)
    {
        $devices = Device::where("active", true)->get();
        foreach ($devices as $device) {
            MQTTClient::sendMessage($device->update_topic, $this->createOtaUpdateMessages($binary));
        }
    }
}
