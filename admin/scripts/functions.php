<?php
function formatToPrice($val) {
	if (strlen($val) == 0 ) return "0";
	$temp = "";
	for ($i=3; $i < strlen($val); $i=$i+3) {
		if ($i ==3 ) {
			$temp = substr($val, "-".$i,3);
		} else {
			$temp = substr($val, "-".$i,3) .".". $temp;
		}
		$pos = $i;
	}
	$countLeft = strlen($val) - $pos;
	if ($countLeft > 0 && $pos > 1) {
		$temp = substr($val, 0, $countLeft) .".". $temp;
	} else {
		$temp = $val;
	}
	$temp .= ",00";
	return $temp;
}

//echo formatToPrice("123456789");


?>