<?php

function liveExecuteCommand($cmd)
{
	while (@ ob_end_flush());
	$proc = popen("$cmd 2>&1 ; echo Exit status : $?", 'r');
	$live_output	 = "";
	$complete_output = "";
	while (!feof($proc))
	{
		$live_output = fread($proc, 4096);
		$live_output = str_replace("Exit status : 0", '', $live_output);
		$complete_output = $complete_output . $live_output;
		echo $live_output;
		@ flush();
	}
	pclose($proc);
	preg_match('/[0-9]+$/', $complete_output, $matches);
	return array (
					'exit_status' => intval($matches[0]),
					'output' => str_replace("Exit status : ".$matches[0], '', $complete_output)
				 );
}

$nomor = $_GET['nomor'];
if(empty($nomor) || strlen($nomor) < 10 || strlen($nomor) > 14 || preg_match('/[^0-9]/',$nomor))
{
	echo "Invalid number!";
	die();
}
if(isset($_GET['type']) && $_GET['type'] == "json") {
    header('Content-Type: application/json');
    $cmd = "./sidompul ".$nomor." --json";
    nl2br(liveExecuteCommand($cmd));
}else{
    header('Content-Type: text/plain');
    $cmd = "./sidompul ".$nomor;
    nl2br(liveExecuteCommand($cmd));
}
