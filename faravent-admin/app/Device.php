<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
      'name', 'verbose_name','description', 'active','in_topic', 'out_topic','update_topic'
  ];

    public function lastMessages()
    {
        return DB::select("SELECT type, topic, message, created from message where topic='{$this->in_topic}' OR  topic='{$this->out_topic}' OR topic='{$this->update_topic}' order by id desc limit 30");
    }
}
