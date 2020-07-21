<?php
namespace App\Wp;

class Connection
{
  public function setDb($pref)
  {
     return ($pref == 'okinawa') ? 'mysql_wp_ok' : 'mysql_wp_kt';
  }

}