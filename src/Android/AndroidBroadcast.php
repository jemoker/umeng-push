<?php
namespace Jemoker\UmengPush\Android;

use Jemoker\UmengPush\AndroidNotification;

class AndroidBroadcast extends AndroidNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}