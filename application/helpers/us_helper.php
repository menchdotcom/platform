<?php

function version_salt(){
	//This variable ensures that the CSS/JS files are being updated upon each launch
	//Also appended a timestamp To prevent static file cashing for local development
	//TODO Implemenet in sesseion when user logs in and logout if not matched!
	return 'v0.33'.( $_SERVER['SERVER_NAME']!=='us.foundation' ? '-'.substr(time(),6) : '' );
}

function parents(){
	//A Javascript version of this function is in main.js
	return array(
		1  => array(
			'name' => 'Us',
			'sign' => '@',
			'node_id' => 1,
		),
		2  => array(
			'name' => 'Sources',
			'sign' => '&',
			'node_id' => 2,
		),
		3  => array(
			'name' => 'Goals',
			'sign' => '#',
			'node_id' => 3,
		),
		4  => array(
			'name' => 'Questions',
			'sign' => '?',
		),
		43 => array(
			'name' => 'Metadata',
			'sign' => '!',
		),
	);
}



function status_descriptions($status_id){
	//translates numerical status fields to descriptive meanings
	if($status_id==-2){
		return array(
				'name' => 'Deleted',
				'description' => 'When content does not follow community guidelines.',
		);
	} elseif($status_id==-1){
		return array(
				'name' => 'Updated',
				'description' => 'When a new update replaces this update.',
		);
	} elseif($status_id==0){
		return array(
				'name' => 'Pending',
				'description' => 'The initial status updates have when submitted by guest users.',
		);
	} elseif($status_id==1){
		return array(
				'name' => 'Primary',
				'description' => 'The top link for the given node.',
		);
	} elseif($status_id==2){
		return array(
				'name' => 'Active',
				'description' => 'Active node links with content association.',
		);
	} elseif($status_id==3){
		return array(
				'name' => 'Active',
				'description' => 'Naked node link without content association.',
		);
	} else {
		//This should never happen!
		return array(
				'name' => 'Unknown!',
				'description' => 'Error: '.$status_id.' is an unknown status ID.',
		);
	}
}


function action_type_descriptions($action_type_id){
	//translates numerical status fields to descriptive meanings
	if($action_type_id==-1){
		return array(
			'name' => 'Deleted',
			'description' => 'Deleted a link relation.',
		);
	} elseif($action_type_id==0){
		return array(
			'name' => 'Pending',
			'description' => 'Added, but pending moderation.',
		);
	} elseif($action_type_id==1){
		return array(
			'name' => 'Added',
			'description' => 'Created a new link from scratch.',
		);
	} elseif($action_type_id==2){
		return array(
			'name' => 'Updated',
			'description' => 'Updated the content or parent of the link.',
		);
	} elseif($action_type_id==3){
		return array(
			'name' => 'Sorted',
			'description' => 'Re-sorted child nodes.',
		);
	} else {
		//This should never happen!
		return array(
				'name' => 'Unknown!',
				'description' => 'Error: '.$action_type_id.' is unknown.',
		);
	}
}



function echo_html($status,$message){
	if($status){
		echo '<span class="success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.$message.'</span>';
	} else {
		echo '<div><span class="danger"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> '.$message.'</span></div>';
	}
	return $status;
}

function format_timestamp($t){
	$timestamp = strtotime(substr($t,0,19));
	$format = ( date("Y",$timestamp)==date("Y") ? "j M Y" : "j M Y");
	return date($format,$timestamp);
}

function clean($string,$noblank=false){
	//return str_replace(" ", ($noblank?'':"<span class='sp'> </span>"), $string);
	return str_replace(" ", ($noblank?'':" "), $string);
}

function redirect_message($url,$message){
	//For message handling across the platform.
	$CI =& get_instance();
	$CI->session->set_flashdata('hm', $message);
	header("Location: ".$url);
	die();
}

function load_algolia($index_name='nodes'){
	require_once('application/libraries/algoliasearch.php');
	$client = new \AlgoliaSearch\Client("49OCX1ZXLJ", "84a8df1fecf21978299e31c5b535ebeb");
	return $client->initIndex($index_name);
}

function admin_error($message){
	//TODO: Email $message to admin for review.
}

function auth($donot_redirect=false){
	$CI =& get_instance();
	$user_data = $CI->session->userdata('user');
	$node_id = $CI->uri->segment(1);
	
	if($donot_redirect){
		return (isset($user_data['id']));
	} elseif(!isset($user_data['id'])){
		redirect_message('/login'.( intval($node_id)>0 ? '?next='.intval($node_id) : '' ),'<div class="alert alert-danger" role="alert">Login to access this page.</div>');
	}
}

function auth_admin($donot_redirect=false){
	$CI =& get_instance();
	$user_data = $CI->session->userdata('user');
	$node_id = $CI->uri->segment(1);
	
	if($donot_redirect){
		return $user_data['is_mod'];
	} elseif(!$user_data['is_mod']){
		redirect_message('/login'.( intval($node_id)>0 ? '?next='.intval($node_id) : '' ),'<div class="alert alert-danger" role="alert">Login as moderator to access this page.</div>');
	}
}




function http_404($message){
	header("HTTP/1.1 404 ".$message);
	die();
}

function valid_hashtag($text){
	//TODO expand upon this, set hashtag policy, check first letter, etc...
	return (ctype_alnum($text));
}

function all_ses_data(){
	$CI =& get_instance();
	return $CI->session->all_userdata();
}







function prep_metadata_for_edit($data){
	//TODO: implement
	//This function translates the original data into an editable mode:
	$return_array = array();
	foreach($data as $d){
		if($d['hide_from_ui']=='t'){
			//Skip this guy:
			continue;
		}
		
		//What do HTML inputs take for editing?
		if($d['type_id']==3){
			//Date
			$return_array[$d['clean_name']] = date('Y-m-d' , $d['value_int']);
		} elseif($d['type_id']==2){
			//Date/Time
			$return_array[$d['clean_name']] = date('Y-m-d\TH:i:s' , $d['value_int']);
		} elseif(strlen($d['value_string'])>0){
			//Any other string field
			//Need to cleanup the single quote:
			$return_array[$d['clean_name']] = str_replace('\'','&apos;',$d['value_string']);
		} else {
			//This is an integer
			$return_array[$d['clean_name']] = $d['value_int'];
		}
	}
	return $return_array;
}


function data_validate_cleanup($type_id,$value){
	//TODO: implement
	$CI =& get_instance();
	$value = trim($value);
	
	if(strlen($value)<=0){
		//Nothing has been passed!
		if($type_id==5){
			//If a checkbox is false, it would return null, so lets return false:
			return 0;
		} else {
			return null;
		}
	}
	
	if($type_id==1){
		//External ID
		return ( intval($value)>0 ? intval($value) : null );
	} elseif($type_id==5){
		//checkbox, which is never NULL
		return ( strtolower($value)=='on' || intval($value) ? 1 : 0 );
	} elseif($type_id==9){
		//Phone number:
		$phone_number = preg_replace('/\D/', '', $value);
		return ( strlen($phone_number)>=4 ? $phone_number : null );
	} elseif($type_id==2 || $type_id==3){
		//Date/Time && Date
		return ( strtotime($value) ? strtotime($value) : null );
	} elseif($type_id==11 || $type_id==8){
		//Number and dollar, both MAY have decimal values
		return floatval($value);
	} elseif($type_id==6){
		//Email address:
		return ( filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null );
	} elseif($type_id==10){
		//URL
		return ( filter_var($value, FILTER_VALIDATE_URL) ? $value : null );
	} elseif($type_id==13){
		//Pattern reference ID
		$validate_pattern = $CI->Patterns_model->fetch_pattern_from_id(intval($value));
		return ( $validate_pattern['id'] ? intval($value) : null );
	} elseif($type_id==4 || $type_id==12){
		//Text & Text Area
		return $value;
	} elseif($type_id==7){
		//Pick list
		//TODO: Validate with database possible inputs to ensure it matches!
		return $value;
	} elseif($type_id==14){
		//TODO: Users, to be deleted soon
		return intval($value);
	} else {
		//Unknown?!
		return null;
	}
}
