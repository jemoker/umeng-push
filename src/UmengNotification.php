<?php

namespace Jemoker\UmengPush;

use Exception;

abstract class UmengNotification
{
	// The host
	protected $host = "http://msg.umeng.com";

	// The upload path
	protected $uploadPath = "/upload";

	// The post path
	protected $postPath = "/api/send";

	// The app master secret
	protected $appMasterSecret = NULL;

	protected $data = array(
		"appkey" => NULL,
		"timestamp" => NULL,
		"type" => NULL,
		"production_mode" => "true"
	);

	protected $DATA_KEYS = array(
		"appkey",
		"timestamp",
		"type",
		"device_tokens",
		"alias",
		"alias_type",
		"file_id",
		"filter",
		"production_mode",
		"feedback",
		"description",
		"thirdparty_id"
	);
	protected $POLICY_KEYS = array(
		"start_time", 
		"expire_time", 
		"max_send_num"
	);

	function __construct()
	{

	}

	function setAppMasterSecret($secret)
	{
		$this->appMasterSecret = $secret;
	}

	function isComplete()
	{
		if (is_null($this->appMasterSecret))
			throw new Exception("Please set your app master secret for generating the signature!");
		$this->checkArrayValues($this->data);
		return TRUE;
	}

	private function checkArrayValues($arr)
	{
		foreach ($arr as $key => $value) {
			if (is_null($value))
				throw new Exception($key . " is NULL!");
			else if (is_array($value)) {
				$this->checkArrayValues($value);
			}
		}
	}

	abstract function setPredefinedKeyValue($key, $value);

	function send()
	{
		$this->isComplete();
		$url = $this->host . $this->postPath;
		$postBody = json_encode($this->data);
		$sign = md5("POST" . $url . $postBody . $this->appMasterSecret);
		$url = $url . "?sign=" . $sign;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
		$result = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlErrNo = curl_errno($ch);
		$curlErr = curl_error($ch);
		curl_close($ch);
		if ($httpCode == "0") {
			throw new Exception("Curl error number:" . $curlErrNo . " , Curl error details:" . $curlErr . "\r\n");
		} else if ($httpCode != "200") {
			throw new Exception("Http code:" . $httpCode . " details:" . $result . "\r\n");
		} else {
			return $result;
		}
	}
}