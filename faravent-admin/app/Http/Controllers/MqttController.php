<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EspBinary;
use App\Device;
use App\Chart;
use App\ChartDataset;
use App\MqttClient;
use Illuminate\Support\Str;
use Helper;

class MqttController extends Controller
{
    public function index(Request $request)
    {
        return view('mqtt', [
            "path"=>"home",
            "lastMessages" => $this->lastMessages(),
            "lastMessagesChart" => $this->lastMessagesChart(),
            "temperatureChart" => $this->sensorValuesChart("Temperature", "temperature_chart", "temperature", time()-3600*24*7, time(), 600),
            "humidityChart" => $this->sensorValuesChart("Humidity", "humidity_chart", "humidity", time()-3600*24*7, time(), 600),
            "movementChart" => $this->sensorValuesChart("Movement", "movement_chart", "movement", time()-3600*24*7, time(), 600, "max"),
            "signalChart" => $this->sensorValuesChart("Signal", "signal_chart", "signal", time()-3600*24*7, time(), 600),

            "topics" => MQTTClient::topics()->topics,
        ]);
    }

    private function lastMessages()
    {
        return DB::select("SELECT type, topic, message, created from message order by id desc limit 30");
    }

    public function lastMessagesSnippet(Request $request)
    {
        return view("mqtt.messages_table", [
            "lastMessages"=>$this->lastMessages(),
        ]);
    }

    private function lastMessagesChart()
    {
        $mqttReceivedCounts = Helper::messagesCountsF("message", 3600, time()-7*24*3600, time(), "type='received'");
        $mqttSentCounts = Helper::messagesCountsF("message", 3600, time()-7*24*3600, time(), "type='sent'");

        //$mqttSentCounts = Helper::messagesCounts("message", "created", 10, "d", "and type='sent'");

        $receivedCountsDataset = new ChartDataset("Received Messages", array_values($mqttReceivedCounts), "rgb(255, 159, 64)");
        $sentCountsDataset = new ChartDataset("Sent Messages", array_values($mqttSentCounts), "rgb(54, 162, 235)");

        return new Chart("last_messages", array_keys($mqttReceivedCounts), array($receivedCountsDataset, $sentCountsDataset));
    }

    private function sensorValuesChart($name, $chartID, $column, $start, $end, $diff)
    {
        $sensorsValues = Helper::sensorValues($column, $diff, $start, $end, "1=1");
        $sensorValuesDataset = new ChartDataset($name, array_values($sensorsValues), "rgb(54, 162, 235)");

        return new Chart($chartID, array_keys($sensorsValues), array($sensorValuesDataset));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'topic' => 'required|max:100',
            'message' => 'required',
        ]);

        MQTTClient::sendMessage($request->topic, $request->message);
        return response()->json(["status"=>"ok"]);
    }

    public function topicsSnippet()
    {
        return view("mqtt.topics_table", [
            "topics"=>MQTTClient::topics()->topics,
        ]);
    }

    public function deleteTopic(Request $request)
    {
        $request->validate([
            'topic' => 'required|max:100',
        ]);
        MQTTClient::unsubscribe($request->topic);
        return response()->json(["status"=>"ok"]);
    }

    public function addTopic(Request $request)
    {
        $request->validate([
            'topic' => 'required|max:100',
        ]);
        MQTTClient::subscribe($request->topic);
        return response()->json(["status"=>"ok"]);
    }
}
