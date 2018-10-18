<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter Notification library configuration file
 *
 * Easily set and display notifications or message stacks in an application
 *
 * @location	application/config
 * @updated		06/01/2011
 * @package		CodeIgniter
 * @subpackage	Notify
 * @version		1.0
 * @author		Mike Saville <http://mikesaville.net>
 * @author		Saville Resources <http://savilleresources.com>
 * @copyright	2011 Saville Resources
 * @license		Apache License v2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
	
/**
 * Array of notifications
 * Customize your CSS file to match this stuff and give it the look you desire
 */
$notify_array = array(
	'error'		=>	array(
		'icon'	=>	'X',
		'color'	=>	'red'
	),
	'warning'	=>	array(
		'icon'	=>	'!',
		'color'	=>	'yellow'
	),
	'info'		=>	array(
		'icon'	=>	'i',
		'color'	=>	'blue'
	),
	'success'	=>	array(
		'icon'	=>	'3',
		'color'	=>	'green'
	)
);

/**
 * Message setup
 * The different parts we need to replace
 * You MUST NOT change {message} - this is the actual message displayed
 *
 * @var 	array	Array of key/value pairs - the key will correspond with each {} wrapped part in $notify_message (below) being replaced
 * 					The value part of the pair is what to wrap the replaced key with. (i.e. Let's say an entry in the array is 'icon' => array('<span>','</span>') - 
 *						When {icon} is replaced in the message it will be replaced with <span>(some value for icon)</span> instead of just (some value for icon)
 *					The value array must be a length of TWO and ONLY TWO (opening HTML tag and closing HTML tag)
 */
$message_variables = array(
	'key'		=>	'',
	'icon'		=>	array('<span class="pictos {color}">','</span>'),
	'color'		=>	'',
	'message'	=>	''
);

/**
 * The message that will be displayed to the user
 * {key} is typically the secondary class found in your CSS file, and also corresponds to 'key' in $message_variables and should match the array key values 
 * 	of $notify_array
 * 
 * {icon} can be an image (relative to your root path, i.e. if your image is in images/icons/, then you'll put <img src="images/icons/{icon}" />, OR in the 
 * 	$notify_array above, you could put 'icon' => 'images/icons/error_icon.png' and then have <img src="{icon}" />)
 *
 * You MUST NOT change {message} - this is the actual message displayed
 */
// $notify_message = '<p class="notification {key}">{icon}&nbsp;{message}</p>';
$notify_message = '<p class="notification {key}">{message}</p>';

/* End of ./application/config/notifications.php */
/* Mike Saville, Saville Resources */