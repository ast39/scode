<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 25.09.2019
 * Time: 10:23
 */


use system\core\SC;


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
    return
        isset ($_SERVER['HTTP_X_REQUESTED_WITH'])
        && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
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

function noController($page_class)
{
    if  ($page_class != 'i' && stripos($page_class, 'apple-touch-icon') === false) {
        SC::logSystemError('Controller not found: ' . $page_class);
    }

    SC::goTo404();
}

function noMethod($page_method)
{
    SC::logSystemError('Method not found: ' . $page_method);
    SC::goTo404();
}

function isJson($string)
{
    return is_string($string) &&
        (is_object(json_decode($string)) ||
            is_array(json_decode($string)));
}
