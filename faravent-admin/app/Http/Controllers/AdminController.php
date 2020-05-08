<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EspBinary;
use Illuminate\Support\Str;


class AdminController extends Controller
{
  private $API_URL = "http://mqtt.faravent.jakubcata.eu";


  public function index(Request $request){
    $data = file_get_contents($this->API_URL."/topics/list");
    $topics = json_decode($data);

    $binaries = EspBinary::all();

    return view("index",["status"=>"done", "topics"=>$topics->topics, "messages"=>$this->last_messages(),"binaries"=>$binaries]);
  }

  public function deleteTopic(Request $request){
    file_get_contents($this->API_URL."/topics/unsubscribe?topic=".$request->topic);

    return $this->index($request);
  }

  public function addTopic(Request $request){
    file_get_contents($this->API_URL."/topics/subscribe?topic=".$request->topic);

    return $this->index($request);
  }

  public function publish(Request $request){
    file_get_contents($this->API_URL."/publish/?topic=".urlencode($request->topic)."&message=".urlencode($request->message));

    return $this->index($request);
  }

  function last_messages(){
    return DB::select("SELECT type, topic, message, created from message order by id desc limit 30");
  }

  function upload_binary(Request $request){
    $file = $request->file('binary');

    $filename = $file->getClientOriginalName();
    $extension = $file->getClientOriginalExtension();
    $tempPath = $file->getRealPath();
    $fileSize = $file->getSize();
    $mimeType = $file->getMimeType();

    $location = public_path().'/binaries/';
    $realName = Str::random(5)."_".$filename;

    // Upload file
    $file->move($location,$realName);

    $binary = EspBinary::create(["name"=>$filename,"real_name"=>$realName ,"size"=>$fileSize, "description"=>""]);

    return $this->index($request);
  }




}
