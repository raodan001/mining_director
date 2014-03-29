<?php
/**
*
* @package phpBB3
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
include($phpbb_root_path . 'includes/eveapi/functions_mops.' . $phpEx); //add the mining ops functions
global $app_info;

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('memberlist');

// Get and set some variables
$mode		= $_POST['mode']; //request_var('mode', '');
$session_id	= request_var('s', '');
$start		= request_var('start', 0);
$sort_key	= request_var('sk', 'b');
$sort_dir	= request_var('sd', 'd');
$show_guests= ($config['load_online_guests']) ? request_var('sg', 0) : 0;

// Can this user view profiles/memberlist?
if (!$auth->acl_gets('u_viewprofile', 'a_user', 'a_useradd', 'a_userdel'))
{
	if ($user->data['user_id'] != ANONYMOUS)
	{
		trigger_error('NO_VIEW_USERS');
	}

	login_box('', "In order to view the Mining Operations list you have to be registered & logged in."); //login_box('', $user->lang['LOGIN_EXPLAIN_VIEWONLINE']);
}

$sort_key_text = array('a' => $user->lang['SORT_USERNAME'], 'b' => $user->lang['SORT_JOINED'], 'c' => $user->lang['SORT_LOCATION']);
$sort_key_sql = array('a' => 'u.username_clean', 'b' => 's.session_time', 'c' => 's.session_page');

// Sorting and order
if (!isset($sort_key_text[$sort_key]))
{
	$sort_key = 'b';
}

$order_by = $sort_key_sql[$sort_key] . ' ' . (($sort_dir == 'a') ? 'ASC' : 'DESC');

$ops_list = '';
$ops_form = '';
	
// Output the page
	page_header();
	
// mining operations info requested
switch ($mode) //if($mode == 'opts' && $auth->acl_get('a_') && $session_id)
{
	case 'showop': 
		$ops_form .= ShowMiningOp($_POST['opsnmbr']);
		// Send data to template
		$template->assign_vars(array(
			'ACTIVE_OPS_LIST'	=> $ops_list) //end array vars
		);
		
		
		$template->set_filenames(array(
				'body' => 'miningopts_details.html')
		);
		break;
/* 	$sql = 'SELECT u.user_id, u.username, u.user_type, s.session_ip
		FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . " s
		WHERE s.session_id = '" . $db->sql_escape($session_id) . "'
			AND	u.user_id = s.session_user_id";
	$result = $db->sql_query($sql);

	if ($row = $db->sql_fetchrow($result))
	{
		$template->assign_var('OPTS', "This is a test of the Mining Operations Beta Test area to display as needed."); //user_ipopt($row['session_ip']));
	}
	$db->sql_freeresult($result); */

//pull the operations list form the database
//Start Date/Time, Name, End Date/Time, Members, Operation Length
//this is a print out test for the ops list
	case 'newop':
		$ops_form .= NewOp();
		// Send data to template
		$template->assign_vars(array(
			'ACTIVE_OPS_LIST'	=> $ops_list) //end array vars
		);
		
		
		$template->set_filenames(array(
				'body' => 'miningopts_new.html')
			);
		break;
		
	case 'delop':
		break;
		
	default:
		//$ops_list = ViewOpsList();
		// Send data to template
		$template->assign_vars(array(
			'ACTIVE_OPS_LIST'	=> ViewOpsList(array(1,2)),
			'OPS_TITLE'	=>	$app_info['name'].' v'.$app_info['version'].' - Operations List'
			));//end array vars
		
		
		$template->set_filenames(array(
				'body' => 'miningopts_list.html')
			);
		break;
	
}
	//make_jumpbox(append_sid("{$phpbb_root_path}miningopts.$phpEx"));

	page_footer();
