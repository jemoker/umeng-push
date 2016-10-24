<?php
namespace Jemoker\UmengPush\Android;

use Jemoker\UmengPush\AndroidNotification;

class AndroidListcast extends AndroidNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "listcast";
		$this->data["device_tokens"] = NULL;
	}

}