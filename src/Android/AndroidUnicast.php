<?php
namespace Jemoker\UmengPush\Android;

use Jemoker\UmengPush\AndroidNotification;

class AndroidUnicast extends AndroidNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "unicast";
		$this->data["device_tokens"] = NULL;
	}

}