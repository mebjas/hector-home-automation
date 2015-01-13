<?php
	define('LEDS', 4);
	define('TIME', time());

	$stats = file_get_contents("stats.json");
	$stats = json_decode($stats, true);

	if (!isset($_GET['state'])) {
		echo "1003";
		exit;
	}

	$inp = $_GET['state'];
	$out = "";

	for($i = 0; $i < LEDS; $i++) {
		if ((isset($inp[$i])) && ($inp[$i] == 'o')) {
			// switched on
			$stats[$i]['last_started'] = TIME;
			$out .= 'o';
		} else {
			if ($stats[$i]['last_started'] != -1) {
				$stats[$i]['total_run'] += (TIME - $stats[0]['last_started']);
			}

			$stats[$i]['last_started'] = -1;
			$out .= 'f';
		}
	}

	$out[LEDS] = '\0';

	exec(__DIR__ ."/binaries/server $out", $output);

	file_put_contents("_STATE_", substr($out, 0, LEDS));
	file_put_contents("stats.json", json_encode($stats));

	if ($output != "1003" && $output != "1001") exit("1");
	exit("0");
?>