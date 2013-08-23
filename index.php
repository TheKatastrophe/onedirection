<?php

include('settings.php');
include('include/simple_html_dom.php');

$here = preg_replace("/^".preg_replace("/\//", '\/',preg_replace("/(?:^\/|\/$)/", '', $URLbase))."\//", '', preg_replace("/(?:^\/|\/$)/", '', $_SERVER['REQUEST_URI']));
$url = explode("/", $here);

if($networks[$url[0]]){
	if($networks[$url[0]]['type'] == "tumblr"){
		$url = $networks[$url[0]]['url']."/post/".$url[1];
		$page = @file_get_html($url);
		if(!$page){ fileNotFound(); }
		$html = $page->find('div.post', 0);
		$page = str_get_html($html);
		$attribs = $page->find('a');
		foreach($attribs as $a){
			$a->setAttribute('href', '#');
			$a->setAttribute('target', '');
		}

		echo $page->innertext;
	}elseif($networks[$url[0]]['type'] == "twitter"){

	}
}else{
	fileNotFound();
}

function fileNotFound(){
	header("HTTP/1.1 404 File Not Found");
	echo "File not found :(";
	exit();
}
