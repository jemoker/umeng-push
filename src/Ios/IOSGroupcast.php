<?php
namespace Jemoker\UmengPush\Ios;

use Jemoker\UmengPush\IOSNotification;

class IOSGroupcast extends IOSNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "groupcast";
		$this->data["filter"]  = NULL;
	}
}