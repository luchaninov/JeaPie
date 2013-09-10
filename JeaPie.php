<?php
/**
 * JeaPie
 * Send notifications to iOS, Android, Google Chrome
 * @link http://jeapie.com/
 * @author Vladimir Luchaninov
 */
class JeaPie {
	private static $token = 'YOURTOKENHERE';

	/**
	 * @param string $message
	 * @param string $title
	 * @param int $priority 1 - important, 0 - normal, -1 - low priority
	 * @return bool
	 */
	static public function send($message, $title = '', $priority = 0) {
		$json = self::_post('http://api.jeapie.com/v2/broadcast/send/message.json', array(
			'token' => self::$token,
			'message' => $message,
			'title' => $title,
			'priority' => (string)$priority
		));

		$json = json_decode($json, true);

		return (!empty($json['success']));
	}

	private static function _post($url, $data) {
		$postdata = http_build_query($data);

		$opts = array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);

		return file_get_contents($url, false, $context);
	}
}
