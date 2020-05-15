<?php
namespace App;

class ChartDataset
{
    public $name;
    public $values;
    public $color;

    public function __construct(string $name, array $values, string $color)
    {
        $this->name = $name;
        $this->values = $values;
        $this->color = $color;
    }

    public function formatValues(): string
    {
        return implode(",", array_map(function ($x) {
            return "'{$x}'";
        }, $this->values));
    }
}
