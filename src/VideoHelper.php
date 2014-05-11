<?php

namespace yii\helpers;

/**
 * VideoHelper provides functionality for YouTube video
 */
class VideoHelper
{
    protected static $hosts = ['youtube.com', 'www.youtube.com'];
    protected static $id_params = ['v'];
    protected static $hq_img = 'http://img.youtube.com/vi/{{id}}/hqdefault.jpg';

	public static function getId($url) {
        $url_parts = parse_url($url);

        if (isset($url_parts['host']) and in_array($url_parts['host'], self::$hosts)) {
            $query = $url_parts['query'];
            $params = explode('&', $query);
            foreach ($params as $pair) {
                list($key, $value) = explode('=', $pair);
                if (in_array($key, self::$id_params) && $value) {
                    return $value;
                }
            }
        }

        return false;
    }

    public static function getImg($url) {
        $id = self::getId($url);
        if ($id) {
            return str_replace('{{id}}', $id, self::$hq_img);
        }

        return false;
    }

    public static function embedCode($url, $width = 640, $height = 480) {
        $id = self::getId($url);

        return $id ? "<iframe width='{$width}' height='{$height}' src='//www.youtube.com/embed/{$id}' frameborder='0' allowfullscreen></iframe>" : '';
    }
}
