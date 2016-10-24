<?php
namespace Jemoker\UmengPush;

use Exception;
use Jemoker\UmengPush\Android\AndroidBroadcast;
use Jemoker\UmengPush\Android\AndroidUnicast;
use Jemoker\UmengPush\Android\AndroidFilecast;
use Jemoker\UmengPush\Android\AndroidGroupcast;
use Jemoker\UmengPush\Android\AndroidCustomizedcast;
use Jemoker\UmengPush\Android\AndroidListcast;
use Jemoker\UmengPush\Ios\IOSListcast;
use Jemoker\UmengPush\Ios\IOSBroadcast;
use Jemoker\UmengPush\Ios\IOSCustomizedcast;
use Jemoker\UmengPush\Ios\IOSFilecast;
use Jemoker\UmengPush\Ios\IOSGroupcast;
use Jemoker\UmengPush\Ios\IOSUnicast;

class UmengPush
{

	protected $appkey = NULL;

	protected $appMasterSecret = NULL;

	protected $timestamp = NULL;

	protected $validation_token = NULL;

	protected $exceptions = [];

	function __construct($key, $secret)
	{
		$this->appkey = $key;
		$this->appMasterSecret = $secret;
		$this->timestamp = strval(time());
	}

	function sendAndroidBroadcast()
	{
		try {
			$brocast = new AndroidBroadcast();
			$brocast->setAppMasterSecret($this->appMasterSecret);
			$brocast->setPredefinedKeyValue("appkey", $this->appkey);
			$brocast->setPredefinedKeyValue("timestamp", $this->timestamp);
			$brocast->setPredefinedKeyValue("ticker", "Android broadcast ticker");
			$brocast->setPredefinedKeyValue("title", "中文的title");
			$brocast->setPredefinedKeyValue("text", "Android broadcast text");
			$brocast->setPredefinedKeyValue("after_open", "go_app");
			// Set 'production_mode' to 'false' if it's a test device.
			// For how to register a test device, please see the developer doc.
			$brocast->setPredefinedKeyValue("production_mode", "true");
			// [optional]Set extra fields
			$brocast->setExtraField("test", "helloworld");
			//print("Sending broadcast notification, please wait...\r\n");
			$brocast->send();
			//print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			//print("Caught exception: " . $e->getMessage());
		}
	}

	/**
	 *
	 * @param unknown $device_tokens 设备唯一标识
	 * @param unknown $ticker 通知栏提示文字
	 * @param unknown $title 通知标题
	 * @param unknown $text 通知文字描述
	 * @param unknown $after_open 点击"通知"的后续行为
	 * @param unknown $extra
	 * @return mixed|boolean
	 */
	function sendAndroidUnicast($data)
	{
		try {
			$unicast = new AndroidUnicast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey", $this->appkey);
			$unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
			// Set your device tokens here
			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$unicast->setExtraField($k, $v); // 设置自定义值
				} else {
					$unicast->setPredefinedKeyValue($k, $v);
				}
			}
			return $unicast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	/**
	 *
	 * @param unknown $device_tokens 设备唯一标识
	 * @param unknown $ticker 通知栏提示文字
	 * @param unknown $title 通知标题
	 * @param unknown $text 通知文字描述
	 * @param unknown $after_open 点击"通知"的后续行为
	 * @param unknown $extra
	 * @return mixed|boolean
	 */
	function sendAndroidListcast($data)
	{
		try {
			$unicast = new AndroidListcast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey", $this->appkey);
			$unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
			// Set your device tokens here
			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$unicast->setExtraField($k, $v); // 设置自定义值
				} else {
					$unicast->setPredefinedKeyValue($k, $v);
				}
			}
			return $unicast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function sendAndroidFilecast()
	{
		try {
			$filecast = new AndroidFilecast();
			$filecast->setAppMasterSecret($this->appMasterSecret);
			$filecast->setPredefinedKeyValue("appkey", $this->appkey);
			$filecast->setPredefinedKeyValue("timestamp", $this->timestamp);
			$filecast->setPredefinedKeyValue("ticker", "Android filecast ticker");
			$filecast->setPredefinedKeyValue("title", "Android filecast title");
			$filecast->setPredefinedKeyValue("text", "Android filecast text");
			$filecast->setPredefinedKeyValue("after_open", "go_app"); //go to app
			//print("Uploading file contents, please wait...\r\n");
			// Upload your device tokens, and use '\n' to split them if there are multiple tokens
			$filecast->uploadContents("aa" . "\n" . "bb");
			//print("Sending filecast notification, please wait...\r\n");
			$filecast->send();
			//print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			//print("Caught exception: " . $e->getMessage());
		}
	}

	function sendAndroidGroupcast($data)
	{
		try {
			$groupcast = new AndroidGroupcast();
			$groupcast->setAppMasterSecret($this->appMasterSecret);
			$groupcast->setPredefinedKeyValue("appkey", $this->appkey);
			$groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$groupcast->setExtraField($k, $v); // 设置自定义值
				} else {
					$groupcast->setPredefinedKeyValue($k, $v);
				}
			}
			return $groupcast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function sendAndroidCustomizedcast($data)
	{
		try {
			$customizedcast = new AndroidCustomizedcast();
			$customizedcast->setAppMasterSecret($this->appMasterSecret);
			$customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
			$customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);

			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$customizedcast->setExtraField($k, $v); // 设置自定义值
				} else {
					$customizedcast->setPredefinedKeyValue($k, $v);
				}
			}

			$customizedcast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function sendIOSBroadcast()
	{
		try {
			$brocast = new IOSBroadcast();
			$brocast->setAppMasterSecret($this->appMasterSecret);
			$brocast->setPredefinedKeyValue("appkey", $this->appkey);
			$brocast->setPredefinedKeyValue("timestamp", $this->timestamp);

			$brocast->setPredefinedKeyValue("alert", "IOS 广播测试");
			$brocast->setPredefinedKeyValue("badge", 0);
			$brocast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$brocast->setPredefinedKeyValue("production_mode", "false");
			// Set customized fields
			$brocast->setCustomizedField("test", "helloworld");
			//print("Sending broadcast notification, please wait...\r\n");
			$brocast->send();
			//print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			//print("Caught exception: " . $e->getMessage());
		}
	}

	function sendIOSUnicast($data)
	{
		try {
			$unicast = new IOSUnicast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey", $this->appkey);
			$unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
			// Set your device tokens here
			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$unicast->setCustomizedField($k, $v); // 设置自定义值
				} else {
					$unicast->setPredefinedKeyValue($k, $v);
				}
			}
			return $unicast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function sendIOSListcast($data)
	{
		try {
			$unicast = new IOSListcast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey", $this->appkey);
			$unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
			// Set your device tokens here
			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$unicast->setCustomizedField($k, $v); // 设置自定义值
				} else {
					$unicast->setPredefinedKeyValue($k, $v);
				}
			}
			return $unicast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function sendIOSFilecast()
	{
		try {
			$filecast = new IOSFilecast();
			$filecast->setAppMasterSecret($this->appMasterSecret);
			$filecast->setPredefinedKeyValue("appkey", $this->appkey);
			$filecast->setPredefinedKeyValue("timestamp", $this->timestamp);

			$filecast->setPredefinedKeyValue("alert", "IOS 文件播测试");
			$filecast->setPredefinedKeyValue("badge", 0);
			$filecast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$filecast->setPredefinedKeyValue("production_mode", "false");
			//print("Uploading file contents, please wait...\r\n");
			// Upload your device tokens, and use '\n' to split them if there are multiple tokens
			$filecast->uploadContents("aa" . "\n" . "bb");
			//print("Sending filecast notification, please wait...\r\n");
			$filecast->send();
			//print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			//print("Caught exception: " . $e->getMessage());
		}
	}

	function sendIOSGroupcast($data)
	{
		try {
			$groupcast = new IOSGroupcast();
			$groupcast->setAppMasterSecret($this->appMasterSecret);
			$groupcast->setPredefinedKeyValue("appkey", $this->appkey);
			$groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
			// Set the filter condition
			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$groupcast->setCustomizedField($k, $v); // 设置自定义值
				} else {
					$groupcast->setPredefinedKeyValue($k, $v);
				}
			}
			return $groupcast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function sendIOSCustomizedcast($data)
	{
		try {
			$customizedcast = new IOSCustomizedcast();
			$customizedcast->setAppMasterSecret($this->appMasterSecret);
			$customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
			$customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);

			foreach ($data as $k => $v) {
				if ($k == 'tag' || $k == 'val') {
					$customizedcast->setCustomizedField($k, $v); // 设置自定义值
				} else {
					$customizedcast->setPredefinedKeyValue($k, $v);
				}
			}
			$customizedcast->send();
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	function taskStatus($task_id)
	{
		try {
			$url = 'http://msg.umeng.com/api/status';
			$data = array(
				'appkey' => $this->appkey,
				'timestamp' => $this->timestamp,
				'task_id' => $task_id
			);
			$postBody = json_encode($data);
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
			//print($result . "\r\n");
			if ($httpCode == "0") {
				// Time out
				throw new Exception("Curl error number:" . $curlErrNo . " , Curl error details:" . $curlErr . "\r\n");
			} else
				if ($httpCode != "200") {
					// We did send the notifition out and got a non-200 response
					throw new Exception("Http code:" . $httpCode . " details:" . $result . "\r\n");
				} else {
					return $result;
				}
		} catch (Exception $e) {
			$this->exceptions[] = $e;
			return false;
		}
	}

	/**
	 * 获取产生的异常列表
	 */
	public function getExceptionList()
	{
		return $this->exceptions;
	}
}
