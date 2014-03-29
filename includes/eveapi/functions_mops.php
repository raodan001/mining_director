<?php

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}
//set global info
global $app_info;
$app_info['version'] = 0.3;
$app_info['name'] = "Mining Operations Director";
$app_info['c_date'] = "3/24/2014";
$app_info['m_date'] = "3/27/2014";

//the mining ops forms creation functions
//new mining operation form
function NewOp(){
	return	null;
	
	
}

//mining operation list view
function ViewOpsList($opslist){
	$oList = '';
	for($i=0; $i < $opslist; $i++){
		$oList .= '<tr><td><input type="checkbox" name="'.$opslist[$i].'" value="'.$opslist[$i].'" /></td><td>2</td><td>The Mining Operation '.$opslist[$i].'</td><td>2/29/2014</td><td>4/1/2014</td><td>2</td><td>2:00:56</td></tr>';
	}
	return	$oList;
}

//view a mining operation details, to edit, delete, finish, record
function ShowMiningOp( $op = 0){
	return null;
	
}
/*
            	<tr><td><input type="checkbox" name="opsnmbr" value="1" /></td><td>1</td><td>The First Mining Operation</td><td>30/12/2013</td><td>25/3/2014</td><td>7</td><td>1202:20:13</td></tr>
            	<tr><td><input type="checkbox" name="opsnmbr" value="2" /></td><td>2</td><td>The 2nd Mining Operation</td><td>2/29/2014</td><td>4/1/2014</td><td>2</td><td>2:00:56</td></tr>
				*/
