<?php

namespace models;

class NewsHelper {

    public static function getTextPreview(string $text)
    {
        return trim(substr($text, 0, stripos($text, '[CUT]'))) . '...';
    }

    public static function getFullText(string $text)
    {
        return str_ireplace('[CUT]', '',$text);
    }

    public static function getImageUrl(string $path, ?string $img = null)
    {
        return SITE_IMG . $path . '/' . $img;
    }
}