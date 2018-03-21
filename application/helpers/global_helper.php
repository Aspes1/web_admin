<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This function used to generate current date
 */
if(!function_exists('FormatNoTrans'))
{
  function FormatNoTrans($num)
  {
      $num=$num+1;
      switch (strlen($num))
      {
        case 1 : $NoTrans = "0000".$num; break;
        case 2 : $NoTrans = "000".$num; break;
        case 3 : $NoTrans = "00".$num; break;
        case 4 : $NoTrans = "0".$num; break;
        default: $NoTrans = $num;
      }
      return $num;
  }
}
