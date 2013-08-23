<?php

include('settings.php');
include('include/simple_html_dom.php');

$here = preg_replace("/^".preg_replace("/\//", '\/',preg_replace("/(?:^\/|\/$)/", '', $URLbase))."\//", '', preg_replace("/(?:^\/|\/$)/", '', $_SERVER['REQUEST_URI']));
$url = explode("/", $here);

$template = file_get_html($template);

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

		$body = $page->innertext;
	}elseif($networks[$url[0]]['type'] == "twitter"){
		$url = $networks[$url[0]]['url']."/status/".$url[1];
		$page = @file_get_html($url);
		$html = $page->find('p.tweet-text', 0);
		$page = str_get_html($html);
		$attribs = $page->find('span.tco-ellipsis');
		foreach($attribs as $a){
			$a->innertext = '';
		}

		$body = $page->innertext;
	}

	$template->find('#1d-title', 0)->innertext = "Title";
	$template->find('#1d-body', 0)->innertext = $body;
	echo $template->innertext;
}else{
	fileNotFound();
}

function fileNotFound(){
	header("HTTP/1.1 404 File Not Found");
	echo "File not found :(";
	exit();
}
