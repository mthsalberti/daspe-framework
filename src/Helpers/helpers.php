<?php


if (!function_exists('breadcrumb')) {
    function breadcrumb($seg)
    {
        $seg = str_replace("daspe.", "", $seg);
        $seg = str_replace("breadcrumb.", "", $seg);
        $seg = str_replace("-", " ", $seg);
        return $seg;
    }
}

if (!function_exists('slug')) {
    function slug()
    {
        return \Request::segments()[1];
    }
}



