<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_functions
 *
 * @author Bk Santiago 
 */
//TIMEZONE
date_default_timezone_set('Asia/Manila');

function sendHome() {
    header("Location: " . base_url());
}

function msgRedirect($msg, $url){
    echo "<script>alert('$msg');</script>";
    echo "<meta http-equiv='Refresh' content='0; URL=$url'>";
}

/*
   $num[0] = monday(Morning)
   $num[1] = monday(Noon)
   $num[2] = monday(Afternoon)
   etc..
*/
function convertToNumeric($schedules){
	$num = array(0, 0, 0,
		0, 0, 0,
		0, 0, 0,
		0, 0, 0,
		0, 0, 0,
		);
	$sCtr = 0;
	$day = 1;
	$time = 1;
	for($i = 0; $i < 15; $i++){	
		if($sCtr < count($schedules)){
			if($schedules[$sCtr]->schedDay->id == $day && $schedules[$sCtr]->schedTime->id == $time){
				$num[$i] = 1;
				$sCtr++;
			}
		}
		$time++;
		if($time == 4){
			$time = 1;
			$day++;
		}
	}
	return $num;
}
?>
