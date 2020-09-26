<?php
namespace App;

class Chart
{
    public $id;
    public $type;
    public $start;
    public $end;
    public $labels;
    public $datasets;


    public function __construct(string $id, string $type, int $start, int $end, array $labels, array $datasets)
    {
        $this->id = $id;
        $this->type = $type;
        $this->start = $start;
        $this->end = $end;
        $this->labels = $labels;
        $this->datasets = $datasets;
    }

    public function formatLabels() : string
    {
        return implode(",", array_map(function ($x) {
            $t = date("Y-m-d H:i:s", $x);
            return "'{$t}'";
        }, $this->labels));
    }

    public function formatJSONLabels() : array
    {
        return array_map(function ($x) {
            return date("Y-m-d H:i:s", $x);
        }, $this->labels);
    }
}
