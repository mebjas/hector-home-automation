<?php
	if (!isset($_GET['state'])) {
		echo "1003";
		exit;
	}
	$inp = $_GET['state'];
	$out = "";
	$out .= (isset($inp[0])) ? ($inp[0] == 'o' || $inp[0] == 'O') ? 'o' : 'f' : 'f';
	$out .= (isset($inp[1])) ? ($inp[1] == 'o' || $inp[1] == 'O') ? 'o' : 'f' : 'f';
	$out .= (isset($inp[2])) ? ($inp[2] == 'o' || $inp[2] == 'O') ? 'o' : 'f' : 'f';
	$out .= (isset($inp[3])) ? ($inp[3] == 'o' || $inp[3] == 'O') ? 'o' : 'f' : 'f';
	$out[4] = '\0';
	exec("./server $out", $output);
	if ($output != "1003" && $output != "1001") exit("1");
	exit("0");
?>