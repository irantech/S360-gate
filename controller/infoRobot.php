<?php

/**
 * Class infoRobot
 * @property infoRobot $infoRobot
 */
class infoRobot
{


	public function indexActiveRobot()
	{


		$Model = Load::library('Model');

		$sql    = "SELECT * FROM robot_tb  ";
		$Result = $Model->select($sql, "assoc");

		if (!empty($Result)) {

			$ResultInfo = $Result;


		} else {
			$ResultInfo['error'] = 'NoData';
		}


		return $ResultInfo;


	}
}