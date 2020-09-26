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
use DateTime;

class MqttController extends Controller
{
    public function index(Request $request)
    {
        return view('mqtt', [
            "path"=>"home",
            "lastMessages" => $this->lastMessages(),
            "lastMessagesChart" => $this->lastMessagesChart(),
            "temperatureChart" => $this->sensorValuesChart("temperature"),
            "humidityChart" => $this->sensorValuesChart("humidity"),
            "movementChart" => $this->sensorValuesChart("movement"),
            "signalChart" => $this->sensorValuesChart("signal"),
            "topics" => MQTTClient::topics()->topics,
        ]);
    }

    public function sensorChart(Request $request)
    {
        $start = DateTime::createFromFormat('Y-m-d H:i:s', $request->start);
        $end = DateTime::createFromFormat('Y-m-d H:i:s', $request->end);

        $chart = $this->sensorValuesChart($request->type, $start->getTimestamp(), $end->getTimestamp(), $request->diff);

        $datasets = [];
        foreach ($chart->datasets as $dataset) {
            $datasets[] = $dataset->values;
        }

        $data = [
          "labels" => $chart->formatJSONLabels(),
          "datasets"=> $datasets,
        ];

        return response()->json($data);
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

        return new Chart("last_messages", "last_messages", 0, 0, array_keys($mqttReceivedCounts), array($receivedCountsDataset, $sentCountsDataset));
    }

    private function sensorValuesChart($type, $start=0, $end=0, $diff=3600)
    {
        if (!$start) {
            $start=time()-7*24*3600;
        }
        if (!$end) {
            $end=time();
        }

        $data = [
            "temperature"=>["name"=>"Temperature", "id"=>"temperature_chart","column"=>"temperature","f"=>"avg"],
            "humidity"=>["name"=>"Humidity", "id"=>"humidity_chart", "column"=>"humidity","f"=>"avg"],
            "movement"=>["name"=>"Movement", "id"=>"movement_chart", "column"=>"movement","f"=>"max"],
            "signal"=>["name"=>"Signal", "id"=>"signal_chart", "column"=>"signal","f"=>"avg"]
        ];
        $ch = $data[$type];
        return $this->genericSensorValuesChart($type, $ch["name"], $ch["id"], $ch["column"], $start, $end, $diff, $ch["f"]);
    }

    private function genericSensorValuesChart($type, $name, $chartID, $column, $start, $end, $diff, $f)
    {
        $sensorsValues = Helper::sensorValues($column, $diff, $start, $end, "1=1", $f);
        $sensorValuesDataset = new ChartDataset($name, array_values($sensorsValues), "rgb(54, 162, 235)");

        return new Chart($chartID, $type, $start, $end, array_keys($sensorsValues), array($sensorValuesDataset));
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
