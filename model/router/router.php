<?php
class Router
{
	static function parse($url){
		$url = trim($url, "/workspace/camagru/");
		$arrayElems = explode('/', $url);
		$arrayElems = array_filter($arrayElems);
		return $arrayElems;
	}
}