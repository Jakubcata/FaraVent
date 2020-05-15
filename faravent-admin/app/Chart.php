<?php
namespace App;

class Chart
{
    public $id;
    public $labels;
    public $datasets;


    public function __construct(string $id, array $labels, array $datasets)
    {
        $this->id = $id;
        $this->labels = $labels;
        $this->datasets = $datasets;
    }

    public function formatLabels() : string
    {
        return implode(",", array_map(function ($x) {
            return "'{$x}'";
        }, $this->labels));
    }
}
