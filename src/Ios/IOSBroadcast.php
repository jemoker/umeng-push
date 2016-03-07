<?php
namespace Jemoker\UmengPush\Ios;

use Jemoker\UmengPush\IOSNotification;

class IOSBroadcast extends IOSNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}