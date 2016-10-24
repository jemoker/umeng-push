<?php
namespace Jemoker\UmengPush\Ios;

use Jemoker\UmengPush\IOSNotification;

class IOSListcast extends IOSNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "listcast";
		$this->data["device_tokens"] = NULL;
	}

}