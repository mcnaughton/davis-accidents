<?php 

$row = 1;
$all_headers = [];
$headers = [];
$codes = [];
$finalized = [];
if (($handle = fopen("data.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
	if (1 === $row) {
		$headers = $data;
		$all_headers = $headers;
		$headers = array_slice($headers, 0, 24);
	} else if (2 === $row) {
		$codes = $data;
		$codes = array_slice($codes, 0, 24);
		$merged = array_combine(array_values($headers), array_values($codes));

		foreach($merged as $k => $v) {
			$finalized[$k] = [
				'code' => $v,
				'data' => []
			];
		}
	} else {
		$row = array_combine($all_headers, array_values($data));
		foreach($row as $k=>$v) {
			if (!empty($v) && intval($v) > 0) {
				if (isset($finalized[$k]) && is_array($finalized[$k]['data'])) {
					$finalized[$k]['data'][] = $row;
				}

			}
		}
	}
	$row++;
    }
    fclose($handle);
}

var_dump($finalized);
