<?php

include('settings.php');

$here = preg_replace("/^".preg_replace("/\//", '\/', preg_replace("/^\//", '', $URLbase))."\//", '', preg_replace("/(?:^\/|\/$)/", '', $_SERVER['REQUEST_URI']));
$url = explode("/", $here);

if($networkes[$url[0]]){
	
}else{

}
