<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class Helper
{

  public static function time_elapsed_string($datetime, $full = false) {
      $now = new DateTime;
      $ago = new DateTime($datetime);
      $diff = $now->diff($ago);

      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;

      $string = array(
          'y' => 'year',
          'm' => 'month',
          'w' => 'week',
          'd' => 'day',
          'h' => 'hour',
          'i' => 'minute',
          's' => 'second',
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          } else {
              unset($string[$k]);
          }
      }

      if (!$full) $string = array_slice($string, 0, 1);
      return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

  public static function messagesCounts($table, $date_col, $number=10, $unit="d", $where_cond=""){

      $fields = [];
      $now = Carbon::now();

      if($unit=="d"){
          $base = "CURDATE()";
          $granularity_sql = "%Y-%m-%d-00:00:00";
          $interval_sql = "INTERVAL {$number} DAY";
          for($i=0; $i<$number; $i++){
              $fields[$now->format('Y-m-d 00:00:00')] = 0;
              $now = $now->subDay();
          }
      } elseif ($unit=="h") {
          $granularity_sql = "%Y-%m-%d-%H:00:00";
          $base = "CONVERT(DATE_FORMAT(NOW(),'{$granularity_sql}'),DATETIME)";
          $interval_sql = "INTERVAL {$number} HOUR";

          for($i=0; $i<$number; $i++){
              $fields[$now->format('Y-m-d H:00:00')] = 0;
              $now = $now->subHour();
          }
      } elseif ($unit=="m") {
          $granularity_sql = "%Y-%m-%d-%H:%i:00";
          $base = "CONVERT(DATE_FORMAT(NOW(),'{$granularity_sql}'),DATETIME)";
          $interval_sql = "INTERVAL {$number} MINUTE";
          for($i=0; $i<$number; $i++){
              $fields[$now->format('Y-m-d H:i:00')] = 0;
              $now = $now->subMinute();
          }
      }

      $sql = "SELECT count(*) as c, CONVERT(DATE_FORMAT({$date_col},'{$granularity_sql}'),DATETIME) as d FROM `{$table}` where {$date_col}>(DATE_SUB({$base}, {$interval_sql})) {$where_cond} group by CONVERT(DATE_FORMAT({$date_col},'{$granularity_sql}'),DATETIME)";
      $rows = DB::select($sql);
      foreach($rows as $row){
          $fields[$row->d] = $row->c;
      }
      return $fields;
  }

  public static function formatChart($chart){
      $newChart = [];
      foreach($chart as $key=>$value){
          $newChart["'{$key}'"]=$value;
      }
      return $newChart;


  }


}
