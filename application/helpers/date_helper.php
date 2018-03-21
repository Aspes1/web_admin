<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This function used to generate current date
 */
if(!function_exists('now'))
{
    function now()
    {
        date_default_timezone_set('Asia/Jakarta');
        return $now = date('Y-m-d H:i:s');
    }
}

/**
 * This function used to generate current date
 */
if(!function_exists('nowDate'))
{
    function nowDate()
    {
        date_default_timezone_set('Asia/Jakarta');
        return $now = date('d-m-Y H:i');
    }
}
/**
 * This function used to generate current date
 */
if(!function_exists('nowDateOnly'))
{
    function nowDateOnly()
    {
        date_default_timezone_set('Asia/Jakarta');
        return $now = date('Y-m-d');
    }
}
/**
 * This function used to generate current date on int format
 */
if(!function_exists('nowInt'))
{
    function nowInt()
    {
      date_default_timezone_set('Asia/Jakarta');
      return $now = date('Ymd');
    }
}
