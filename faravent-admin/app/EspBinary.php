<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspBinary extends Model
{
  protected $fillable = [
      'name','real_name', 'size', 'description',
  ];

  public function getUrl(){
    return url('/')."/binaries/".$this->real_name;
  }

}
