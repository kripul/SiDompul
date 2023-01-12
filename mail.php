<?php
$username = $_GET['u'];
$password = $_GET['p'];
$server = '{imap-mail.outlook.com:993/ssl}';
$connection = imap_open($server, $username, $password);
$mailboxes = imap_list($connection, $server,'*');
$check = imap_check($connection); 
$n_msgs = $check->Nmsgs;
$array = array();
for ($i=$n_msgs-0; $i<=$n_msgs; $i++) {
    $header = imap_header($connection, $i);
    $data = json_decode(json_encode($header),true);
    $message_body = html_entity_decode(imap_body($connection,$i));
    $data['message_body'] = $message_body;
    array_push($array,$data);
}
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($array);
imap_close($connection);