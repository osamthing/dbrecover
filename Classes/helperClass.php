<?php

namespace Utility;

use Dotenv\Dotenv;

class helperClass{

    public function Hello()
    {
        echo "Hello Sample\n";
    }

    public function getFreeMemory()
    {
      /* free command */
      $free = `free -m`;
      $split_array = [];
      // list($split_array) = explode(" ",$free);
      list($t,$m,$s) = explode("\n",$free);
      $split_array = explode(" ",$m);
      $mems = array_merge(array_filter($split_array, "strlen"));
      $free = $mems[3]+$mems[5];
      $available = $mems[6];
      $return_arr = [
        "free" => $free." MB",
        "available" => $available." MB",
      ];

      return $return_arr;
    }

    public function sendmail($to, $title, $content)
    {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        mb_send_mail($to, $title, $content);
        return true;
    }




    public function restartMariaDB()
    {
      system('systemctl restart mariadb',$ret);
      return $ret;
    }

    public function statustMariaDB()
    {
      return `systemctl status mariadb`;
    }

    /* active or disable*/
    public function parseStatus($info)
    {
      /* search Active: active (running) since Fri 2018-08-10 */

      if(strpos($info,'Active: active (running)'))
      {
        return true;
      } else if (strpos($info,'Active: inactive (dead)')) {
        return false;
      } else {
        return false;
      }
    }


}
