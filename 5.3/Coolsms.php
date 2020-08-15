<?php
namespace Coolsms\PHP53;

/**
 * Class Coolsms
 *
 * PHP 5.3+
 *
 * @package Coolsms
 *
 * @see https://www.coolsms.co.kr/
 */
class Coolsms {
	/**
	 * @var string $apiKey
	 */
	private $apiKey = '';

	/**
	 * @var string $apiSecret
	 */
	private $apiSecret = '';

	/**
	 * @var string $apiUrl
	 */
	private $apiUrl = 'https://api.coolsms.co.kr/';

	/**
	 * @var string $version SMS API Version
	 */
	private $version = '1.6';

	/**
	 * @var string $senderidVersion 발신번호 등록 API
	 */
	private $senderidVersion = '1.2';

	/**
	 * @var string $srk
	 */
	private $srk = 'K0010535426';

	/**
	 * @var array   $data                           기본정보
	 *      int     $data['byte']['sms']            SMS 글자 제한
	 *      int     $data['byte']['lms']            LMS 글자 제한
	 *      int     $data['charge']['sms']          SMS 비용
	 *      int     $data['charge']['lms']          LMS 비용
	 *      array   $data['senderid']['list']       발신번호 List
	 *      string  $data['senderid']['default']    기본 발신번호
	 */
	private $data = array(
		'byte'=>array(
			'sms'=>90,
			'lms'=>2000
		),
		'charge'=>array(
			'sms'=>20,
			'lms'=>50
		),
		'senderid'=>array(
			'list'=>array(),
			'default'=>''
		)
	);

	public function __construct () {
		$this->data['senderid']['list'] = $this->getSenderidList();
		foreach ($this->data['senderid']['list'] as $row) {
			if ($row['flag_default'] == 'Y') {
				$this->data['senderid']['default'] = $row['phone_number'];
			}
		}
	}

	/**
	 * getData
	 *
	 * $this->data 를 리턴
	 *
	 * @return  array   $this->data
	 */
	public function getData () {
		return $this->data;
	}

	/**
	 * getCurl
	 *
	 * @param   string      $url
	 * @param   array       $param
	 *
	 * @return  array       $data
	 */
	public function getCurl ($url, $param = array()) {
		$data = array();

		// set CURLOPT_USERAGENT
		if (!isset($param[CURLOPT_USERAGENT])) {
			if (isset($_SERVER['HTTP_USER_AGENT'])) {
				$param[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
			} else {
				// default IE11
				$param[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko';
			}
		}

		// check curl_init function
		if (function_exists('curl_init')) {
			$ch = curl_init();

			// url 설정
			curl_setopt($ch, CURLOPT_URL, $url);

			foreach ($param as $key => $value) {
				curl_setopt($ch, $key, $value);
			}

			$data['html'] = json_decode(curl_exec($ch), true);
			$data['response'] = curl_getinfo($ch);
			$data['error']['no'] = curl_errno($ch);
			$data['error']['message'] = curl_error($ch);

			curl_close($ch);
		}

		return $data;
	}

	/**
	 * get
	 *
	 * method GET 으로 API 통신
	 *
	 * @param   string      $method
	 * @param   string      $version
	 * @param   string      $action
	 * @param   array       $data
	 *
	 * @return  array
	 */
	public function get ($method, $version, $action, $data = array()) {
		$data['api_key'] = $this->apiKey;
		$data['timestamp'] = time();
		$data['salt'] = uniqid();
		$data['signature'] = $this->getSignature($data['timestamp'], $data['salt']);

		$url = $this->apiUrl . $method . '/' . $version . '/' . $action . '?' . http_build_query($data);
		return $this->getCurl(
			$url,
			[
				CURLOPT_RETURNTRANSFER  => true
			]
		);
	}

	/**
	 * _post
	 *
	 * curl post
	 *
	 * @param   string      $method
	 * @param   string      $version
	 * @param   string      $action
	 * @param   array       $data
	 *
	 * @return  array       $response
	 */
	public function post ($method, $version, $action, $data = array()) {
		$param = array(
			CURLOPT_POST=>true,
			CURLOPT_RETURNTRANSFER=>true
		);

		$data['api_key'] = $this->apiKey;
		$data['timestamp'] = time();
		$data['salt'] = uniqid();
		$data['signature'] = $this->getSignature($data['timestamp'], $data['salt']);
		$param[CURLOPT_POSTFIELDS] = http_build_query($data);

		$url = $this->apiUrl . $method . '/' . $version . '/' . $action;
		$response = $this->getCurl($url, $param);
		return $response;
	}

	/**
	 * getByte
	 *
	 * 텍스트의 Byte를 구함
	 *
	 * @param   string      $text
	 *
	 * @return  int         $byte
	 */
	private function getByte ($text) {
		$byte = 0;
		$length = mb_strlen($text, 'UTF-8');

		for ($i = 0; $i < $length; $i++) {
			$char = mb_substr($text, $i, 1, 'UTF-8');
			$ord = ord($char);
			$len = mb_strlen(bin2hex($char), 'UTF-8');
			if ($ord == 13) {
				// break point
			} else if ($ord == 10) {
				// new line
				$byte++;
			} else if ($len == 2) {
				// 1byte - ex. [0-9a-zA-Z]
				$byte++;
			} else if ($len == 6) {
				// 3byte - ex. [가-히]
				$byte += 2;
			}
		}

		return $byte;
	}

	/**
	 * getSignature
	 *
	 * @param   int     $timestamp      time();
	 * @param   string  $salt           uniqid();
	 *
	 * @return  string
	 */
	public function getSignature ($timestamp, $salt) {
		return hash_hmac('md5', $timestamp . $salt, $this->apiSecret);
	}

	/**
	 * getSenderidDefault
	 *
	 * 기본 발신번호를 리턴
	 *
	 * @return  array   $data
	 *          string  $data['handle_key']     PK
	 *          string  $data['phone_number']   Phone Number (Only Number)
	 */
	public function getSenderidDefault () {
		$data = $this->get('senderid', $this->senderidVersion, 'get_default');
		return $data;
	}

	/**
	 * getSenderidList
	 *
	 * 등록된 발신번호 리스트를 리턴
	 *
	 * @return  array   $data
	 *          string  $data[]['idno']             PK
	 *          string  $data[]['phone_number']     Phone Number (Only Number)
	 *          string  $data[]['flag_default']     Y (기본 발신번호) / N
	 *          string  $data[]['updatetime']       Y-m-d H:i:s 마지막 갱신일시
	 *          string  $data[]['regdate']          Y-m-d H:i:s 최초 등록일시
	 *          string  $data[]['expiration']       Y-m-d H:i:s 다음 갱신일시
	 */
	public function getSenderidList () {
		$data = $this->get('senderid', $this->senderidVersion, 'list');
		return $data;
	}

	/**
	 * getBalance
	 *
	 * 남은 잔액
	 *
	 * @return  array   $data
	 *          int     $data['cash']
	 *          int     $data['point']
	 *          string  $data['deferred_payment']   후불회원인지 확인
	 */
	public function getBalance () {
		$data = $this->get('sms', $this->version, 'balance');
		return $data;
	}

	/**
	 * getStatus
	 *
	 * 전송채널의 상태를 조회합니다.
	 *
	 * @param   array       $param
	 *          int         $param['count']     기본값 1이며 1개의 최신의 레코드를 받을 수 있음, 10입력시 10분 동안의 레코드 목록을 리턴
	 *          string      $param['unit']      minute(default), hour, day 중 하나
	 *                                          minute : 분 단위의 현황
	 *                                          hour : 시간 단위의 평균
	 *                                          day : 일 단위의 평균
	 *          string      $param['date']      데이터를 읽어오는 기준 시각으로 YYYYMMDDHHMISS 형식의 14자리 값
	 *                                          기본값 : 현재시각
	 *          int         $param['channel']   1: 1건 발송 채널 (기본 값), 2: 대량 발송 채널
	 *
	 * @return  array       $data
	 *          string      $data[]['registdate']
	 *          int         $data[]['sms_average']
	 *          int         $data[]['sms_sk_average']
	 *          int         $data[]['sms_kt_average']
	 *          int         $data[]['sms_lg_average']
	 *          int         $data[]['mms_average']
	 *          int         $data[]['mms_sk_average']
	 *          int         $data[]['mms_kt_average']
	 *          int         $data[]['mms_lg_average']
	 */
	public function getStatus ($param = array()) {
		$data = $this->get('sms', $this->version, 'status', $param);
		return $data;
	}

	/**
	 * getSent
	 *
	 * 발송된 문자메시지의 목록을 가져옵니다.
	 *
	 * @see https://www.coolsms.co.kr/Legacy_Result_Codes
	 *
	 * @param   array       $param
	 *          int         $param['page']                  1부터 시작하는 페이지값
	 *          int         $param['count']                 기본값 20이며 20개의 목록을 받을 수 있음. 40입력시 40개의 목록이 리턴
	 *          string      $param['s_rcpt']                수신번호로 검색
	 *          string      $param['start']                 검색 시작일시 접수 날짜와 시간으로 검색 YYYY-MM-DD HH:MI:SS 포맷의 날짜와 시간
	 *          string      $param['end']                   검색 종료일시 접수 날짜와 시간으로 검색 YYYY-MM-DD HH:MI:SS 포맷의 날짜와 시간
	 *          int         $param['status']                메시지 상태 값으로 검색
	 *          int         $param['resultcode']            전송결과 값으로 검색
	 *          int         $param['notin_resultcode']      입력된 전송결과 값 이외의 건들만 조회
	 *          int         $param['message_id']            메시지ID
	 *          int         $param['group_id']              ID
	 *
	 * @return  array       $data
	 *          int         $data['limit']
	 *          string      $data['data'][]['type']                     SMS / LMS
	 *          string      $data['data'][]['accepted_time']            Y-m-d H:i:s
	 *          string      $data['data'][]['recipient_number']         수신번호
	 *          string      $data['data'][]['group_id']
	 *          string      $data['data'][]['message_id']
	 *          int         $data['data'][]['status']                   0 : 대기중, 1 : 이통사로 전송중, 2 : 이통사로부터 리포트 도착
	 *          string      $data['data'][]['result_code']
	 *          string      $data['data'][]['result_message']
	 *          string      $data['data'][]['sent_time']                YmdHis
	 *          string      $data['data'][]['text']
	 *          string      $data['data'][]['carrier']                  SKT / LGUplus
	 */
	public function getSent ($param = array()) {
		$data = $this->get('sms', $this->version, 'sent', $param);
		return $data;
	}

	/**
	 * send
	 *
	 * 문자메시지를 전송 요청합니다. 전송 요청에 대한 Response는 휴대전화까지 전송된 결과가 아닙니다.
	 *
	 * @param   array       $param
	 *          string      $param['to']                    수신번호 입력 콤마(,)로 구분된 수신번호 입력가능 예) 01012345678,01023456789,01034567890
	 *          string      $param['from']                  발신번호 예) 0212345678
	 *                                                      2015/10/16 발신번호 사전등록제에 의해 반드시 등록된 번호만 허용됩니다. (해외문자 제외)
	 *          string      $param['text']                  문자내용
	 *          string      $param['type']                  CTA(친구톡), ATA(알림톡), SMS(80바이트), LMS(장문 2,000바이트), MMS(장문+이미지)
	 *                                                      입력 없으면 SMS가 기본 국가코드가 KR이 아니면 SMS로 강제
	 *          string      $param['template_code']         알림톡 Template Code
	 *          string      $param['sender_key']            알림톡 Sender Key
	 *          string      $param['image']                 지원형식 : 300KB 이하의 JPEG, PNG, GIF 형식의 파일 2048x2048 픽셀이하
	 *          string      $param['image_encoding']        이미지 인코딩 방식 binary(Default), base64
	 *          string      $param['refname']               참조내용(이름)
	 *          int         $param['country']               한국: 82, 일본: 81, 중국: 86, 미국: 1, 기타 등등 (기본 한국)
	 *                                                      http://countrycode.org 참고
	 *          string      $param['datetime']              예약시간을 YYYYMMDDHHMISS 포맷으로 입력 (입력 없거나 지난날짜를 입력하면 바로 전송)
	 *                                                      예) 20131216090510 (2013년 12월 16일 9시 5분 10초에 발송되도록 예약)
	 *          string      $param['subject']               LMS, MMS 일때 제목 (40바이트)
	 *          string      $param['charset']               한글 인코딩 방식 지정 유니코드 UTF-8 일 경우 utf8 완성형 한글(EUC-KR) 일 경우 euckr 으로 입력
	 *                                                      입력 없으면 utf8가 기본
	 *          string      $param['srk']                   솔루션 제공 수수료를 정산받을 솔루션 등록키
	 *          bool        $param['only_ata']              알림톡이 실패해도 문자메시지로 대체하여 발송하지 않습니다.
	 *                                                      true 혹은 false(기본)
	 *          string      $param['os_platform']           클라이언트의 OS 및 플랫폼 버전) CentOS 6.6
	 *                                                      (v1.5에서 추가됨)
	 *          string      $param['dev_lang']              개발 프로그래밍 언어 예) PHP 5.3.3
	 *                                                      (v1.5에서 추가됨)
	 *          string      $param['sdk_version']           SDK 버전 예) PHP SDK 1.5
	 *                                                      (v1.5에서 추가됨)
	 *          string      $param['app_version']           어플리케이션 버전 예) Purplebook 4.1
	 *                                                      (v1.5에서 추가됨)
	 *          string      $param['button_name']           알림톡&친구톡 버튼이름
	 *          string      $param['button_url']            알림톡&친구톡 버튼URL
	 *
	 * @return  array       $data
	 *          string      $data['group_id']               R1G5B531D991B228
	 *          int         $data['success_count']          1
	 *          int         $data['error_count']            0
	 *          string      $data['result_code']            00
	 *          string      $data['result_message']         Success
	 */
	public function send ($param = array()) {
		$data = array();

		if (isset($param['to'], $param['text'])) {
			if (!isset($param['from'])) {
				$param['from'] = $this->data['senderid']['default'];
			}

			// 하이픈 제거
			$param['to'] = preg_replace('/[^0-9,]/', '', $param['to']);
			$param['from'] = preg_replace('/[^0-9]/', '', $param['from']);

			if (isset($param['datetime'])) {
				// 숫자만 남기고 제거
				$param['datetime'] = preg_replace('/[^0-9]/', '', $param['datetime']);
			}

			if ($this->srk) {
				$param['srk'] = $this->srk;
			}

			if (!isset($param['type'])) {
				// 문자 byte를 가져옴..
				$byte = $this->getByte($param['text']);

				if ($byte <= $this->data['byte']['sms']) {
					$param['type'] = 'SMS';
				} else if ($byte <= $this->data['byte']['lms']) {
					$param['type'] = 'LMS';
				}
			}

			if (isset($param['type'])) {
				if ($param['to'] && $param['from']) {
					$response = $this->post('sms', $this->version, 'send', $param);

					if (isset($response['response']['http_code']) && $response['response']['http_code'] == 200) {
						$data = $response['html'];
					}
				} else {
					$data['status'] = false;
					$data['message'] = '번호를 확인해주세요.';
				}
			} else {
				$data['status'] = false;
				$data['message'] = '문자 길이를 체크해주세요.';
			}
		} else {
			$data['status'] = false;
			$data['message'] = '문자 발송에 실패하였습니다.';
		}

		return $data;
	}

	/**
	 * cancel
	 *
	 * @param   array       $param
	 *          string      $param['mid']       메시지ID
	 *          string      $param['gid']       그룹ID
	 *
	 * @return  bool
	 */
	public function cancel ($param = array()) {
		if (isset($param['mid']) || isset($param['gid'])) {
			// 메시지ID 혹은 그룹ID 가 존재
			$data = $this->post('sms', $this->version, 'cancel', $param);

			if (isset($data['response']['http_code']) && $data['response']['http_code'] == 200) {
				return true;
			}
		}

		return false;
	}
}