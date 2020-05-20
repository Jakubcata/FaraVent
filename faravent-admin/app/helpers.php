<?php

use App\User;

function user()
{
    return auth()->user() ?: User::getDefault();
}

function has_permission($item){
    return $item->public || user()->isAdmin();
}

function encode_answers($answers, $answer_id){
    return implode("-",$answers->map(function($item, $key) use ($answer_id){
        return $item->id."_".(int)($answer_id==$item->id);
    })->toArray());
}

/**
 * Helper to create url's relative to the applications root path.
 * @param string $path
 * @param bool $forceAppDomain
 * @return string
 */
function baseUrl($path, $forceAppDomain = false)
{
    $isFullUrl = strpos($path, 'http') === 0;
    if ($isFullUrl && !$forceAppDomain) {
        return $path;
    }
    $path = trim($path, '/');

    // Remove non-specified domain if forced and we have a domain
    if ($isFullUrl && $forceAppDomain) {
        $explodedPath = explode('/', $path);
        $path = implode('/', array_splice($explodedPath, 3));
    }

    // Return normal url path if not specified in config
    if (config('app.url') === '') {
        return url($path);
    }

    return rtrim(config('app.url'), '/') . '/' . $path;
}

/**
 * Get a path to a theme resource.
 * @param string $path
 * @return string|boolean
 */
function theme_path($path = '')
{
    $theme = config('view.theme');
    if (!$theme) {
        return false;
    }

    return base_path('themes/' . $theme .($path ? DIRECTORY_SEPARATOR.$path : $path));
}


/**
 * Get fetch an SVG icon as a string.
 * Checks for icons defined within a custom theme before defaulting back
 * to the 'resources/assets/icons' folder.
 *
 * Returns an empty string if icon file not found.
 * @param $name
 * @param array $attrs
 * @return mixed
 */
function icon($name, $attrs = [])
{
    $attrs = array_merge([
        'class' => '',
        'data-icon' => $name,
        'style' => 'height:25px; margin-top:6px; margin-left:0.5px;'
    ], $attrs);
    $attrString = ' ';
    foreach ($attrs as $attrName => $attr) {
        $attrString .=  $attrName . '="' . $attr . '" ';
    }

    $iconPath = resource_path('assets/icons/' . $name . '.svg');
    $themeIconPath = theme_path('icons/' . $name . '.svg');
    if ($themeIconPath && file_exists($themeIconPath)) {
        $iconPath = $themeIconPath;
    } else if (!file_exists($iconPath)) {
        return '';
    }

    $fileContents = file_get_contents($iconPath);
    return  str_replace('<svg', '<svg' . $attrString, $fileContents);
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime(date("Y-m-d H:i:s",time()));
    //$ago = new DateTime($datetime);
    $ago = $datetime;

    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => ['rokom','rokmi'],
        'm' => ['mesiacom','mesiacmi'],
        'w' => ['týždňom','týždnami'],
        'd' => ['dňom','dňami'],
        'h' => ['hodinou','hodinami'],
        'i' => ['minútou','minútami'],
        's' => ['sekundou','sekundami'],
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . ($diff->$k > 1 ? $v[1] : $v[0]);
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? "pred " . implode(', ', $string) : 'práve teraz';
}


function test_ending($testCount) {
    switch ($testCount) {
      case 1:
        return "";
      case 2:
      case 3:
      case 4:
        return "y";
      default:
        return "ov";
    }
}
