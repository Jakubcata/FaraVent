<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EspBinary;
use App\Device;
use Illuminate\Support\Str;

class MQTTClient{
  private static $API_URL = "http://mqtt.faravent.jakubcata.eu";

  public static function subscribe($topic){
    file_get_contents(self::$API_URL."/topics/subscribe?topic=".$topic);
  }

  public static function unsubscribe($topic){
    file_get_contents(self::$API_URL."/topics/unsubscribe?topic=".$topic);
  }

  public static function publish($topic, $message){
    file_get_contents(self::$API_URL."/publish/?topic=".urlencode($topic)."&message=".urlencode($message));
  }

  public static function topics(){
    return json_decode(file_get_contents(self::$API_URL."/topics/list"));
  }

}



class AdminController extends Controller
{

  public function index(Request $request){
    $topics = MQTTClient::topics();

    $binaries = EspBinary::all();
    $devices = Device::all();

    return view("index",["status"=>"done", "topics"=>$topics->topics, "messages"=>$this->last_messages(),"binaries"=>$binaries,"devices"=>$devices]);
  }



  public function deleteTopic(Request $request){
    MQTTClient::unsubscribe($request->topic);
    return $this->index($request);
  }

  public function addTopic(Request $request){
    MQTTClient::subscribe($request->topic);
    return $this->index($request);
  }

  public function publish(Request $request){
    MQTTClient::publish($request->topic, $request->message);
    return $this->index($request);
  }

  public function addDevice(Request $request){

    $inTopic = $request->name."_in";
    $outTopic = $request->name."_out";


    Device::create(["name"=>$request->name, "description"=>"","active"=>True,"in_topic"=>$inTopic,"out_topic"=>$outTopic]);
    MQTTClient::subscribe($outTopic);
    return $this->index($request);
  }

  public function removeDevice(Request $request){
    $device = Device::find($request->id);
    MQTTClient::unsubscribe($device->out_topic);
    $device->delete();

    return $this->index($request);
  }

  function removeProtocols($uri) {
    return explode("//", $uri)[1];
  }

  function last_messages(){
    return DB::select("SELECT type, topic, message, created from message order by id desc limit 30");
  }

  public function publishBinaryDeploy($binary){
    $devices = Device::where("active",True)->get();
    foreach ($devices as $device) {
      MQTTClient::publish($device->updateTopic(), $this->removeProtocols($binary->getUrl()));
    }
  }

  public function deployBinary(Request $request){
    $binary = EspBinary::find($request->id);
    $this->publishBinaryDeploy($binary);
    return $this->index($request);
  }

  public function uploadBinary(Request $request){
    $file = $request->file('binary');

    $filename = $file->getClientOriginalName();
    $fileSize = $file->getSize();

    $location = public_path().'/binaries/';
    $realName = Str::random(5)."_".$filename;

    // Upload file
    $file->move($location,$realName);

    $binary = EspBinary::create(["name"=>$filename,"real_name"=>$realName ,"size"=>$fileSize, "description"=>""]);
    $this->publishBinaryDeploy($binary);

    if($request->wantsJson()){
      return response()->json([
        "name"=>$filename,
        "size"=>$fileSize,
        "status"=>"ok",
      ]);
    }
    return $this->index($request);
  }

  public function deleteBinary(Request $request){
    $binary = EspBinary::find($request->id);
    $binary->delete();

    return $this->index($request);
  }
}
