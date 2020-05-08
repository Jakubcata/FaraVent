<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspBinary extends Model
{
  protected $fillable = [
      'name','real_name', 'size', 'description',
  ];

}
