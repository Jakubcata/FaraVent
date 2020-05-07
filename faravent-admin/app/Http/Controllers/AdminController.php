<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
  private $API_URL = "http://mqtt.faravent.jakubcata.eu";


  public function index(Request $request){
    $data = file_get_contents($this->API_URL."/topics/list");
    $topics = json_decode($data);

    return view("index",["status"=>"done", "topics"=>$topics->topics, "messages"=>$this->last_messages()]);
  }

  public function deleteTopic(Request $request){
    file_get_contents($this->API_URL."/topics/unsubscribe?topic=".$request->topic);

    return $this->index($request);
  }

  public function addTopic(Request $request){
    file_get_contents($this->API_URL."/topics/subscribe?topic=".$request->topic);

    return $this->index($request);
  }

  function last_messages(){
    return array_reverse(DB::select("SELECT type, topic, message, created from message order by id desc limit 30"));
  }


}
