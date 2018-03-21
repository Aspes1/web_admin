<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('get_hash'))
{
    function get_hash($plainPassword)
    {
    	 $options = [
        'cost' => 10, // proses hash sebanyak 2^10 atau 1024 kali.
                    ];
        return password_hash($plainPassword, PASSWORD_DEFAULT,$options);
    }
}
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('hash_verified'))
{
    function hash_verified($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}
