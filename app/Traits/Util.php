<?php
namespace App\Traits;
trait Util{
function getMessage($str,$value) { 
   return sprintf($str,$value);
}
}