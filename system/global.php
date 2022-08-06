<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 25.09.2019
 * Time: 10:23
 */

function xmp($data)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}

function printSession()
{
    xmp($_SESSION);
}

function printPost()
{
    xmp($_POST);
}

function printClassMethods($class)
{
    xmp(get_class_methods($class));
}

function printMethodParams()
{
    xmp(func_get_args());
}

function requestType()
{
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
}

function isAjax()
{
    return isset ($_SERVER['HTTP_X_REQUESTED_WITH'])
        AND !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ? TRUE
            : FALSE;
}

function objectToArray($data)
{
    return json_decode(json_encode($data), true);
}

function xmlToArray($xml_string)
{
    $xml   = simplexml_load_string($xml_string, "SimpleXMLElement", LIBXML_NOCDATA);
    $json  = json_encode($xml);

    return json_decode($json,TRUE);
}
