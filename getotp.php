<?php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
$username = $_GET['u'];
$password = $_GET['p'];
$data = json_decode(file_get_contents('http://sidompul.cloudaccess.host/mail.php?u='.$username.'&p='.$password));
header('Content-Type: text/plain; charset=utf-8');
die(get_string_between($data[0]->message_body, '<span style=3D"font-size:18px">', '</span>'));