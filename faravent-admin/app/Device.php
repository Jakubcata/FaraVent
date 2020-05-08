<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
  protected $fillable = [
      'name', 'description', 'active','in_topic', 'out_topic',
  ];
}
