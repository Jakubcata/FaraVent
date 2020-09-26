<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
use App\Device;

class Helper
{
    public static function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime, new DateTimeZone('UTC'));
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

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function roundTime($time, $diff)
    {
        return floor($time/$diff)*$diff;
    }

    public static function fill($data, $start, $end, $diff)
    {
    }

    public static function messagesCountsF($table, $diff, $start, $end, $where_cond)
    {
        $sql = "SELECT (UNIX_TIMESTAMP(created) DIV {$diff}) as d, count(*) as c FROM `message` where UNIX_TIMESTAMP(created)>={$start} and UNIX_TIMESTAMP(created)<={$end} and {$where_cond} group by (UNIX_TIMESTAMP(created) DIV {$diff})";
        $rows = DB::select($sql);

        $fields = array();

        foreach ($rows as $row) {
            $fields[$row->d*$diff] = $row->c;
        }

        $start = self::roundTime($start, $diff);
        $end = self::roundTime($end, $diff);

        for ($i=$start; $i<=$end; $i+=$diff) {
            if (!isset($fields[$i])) {
                $fields[$i] = 0;
            }
        }
        ksort($fields);
        return $fields;
    }

    public static function sensorValues($column, $diff, $start, $end, $where_cond, $f="avg")
    {
        $sql = "SELECT (UNIX_TIMESTAMP(created) DIV {$diff}) as d, {$f}(`{$column}`) as c FROM `sensor_values` where UNIX_TIMESTAMP(created)>={$start} and UNIX_TIMESTAMP(created)<={$end} and {$where_cond} group by (UNIX_TIMESTAMP(created) DIV {$diff})";
        $rows = DB::select($sql);

        $fields = array();

        foreach ($rows as $row) {
            $fields[$row->d*$diff] = $row->c;
        }

        $start = self::roundTime($start, $diff);
        $end = self::roundTime($end, $diff);

        for ($i=$start; $i<$end; $i+=$diff) {
            if (!isset($fields[$i])) {
                $fields[$i] = 0;
            }
        }
        ksort($fields);
        return $fields;
    }

    public static function devicesList()
    {
        return Device::all();
    }
}
