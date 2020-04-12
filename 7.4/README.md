# CoolSMS API PHP
https://www.coolsms.co.kr/ 의 PHP 7.4+ 라이브러리 입니다.

## 사용법
```php
// 라이브러리 require
require_once '{PHP 파일 경로}/7.4/autoload.php';

// 변수 지정
$coolsms = new \CoolSMS\PHP74\CoolSMS('API KEY', 'API Secret KEY');

// 전송 가능한 byte 정보 (SMS)
echo $coolsms->byte->sms;

// 전송 요금 (SMS)
echo $coolsms->charge->sms;

// 대표 발신 번호
$coolsms->senderIDDefault()->phone_number;

// 등록된 발신 번호 목록
$list = $coolsms->senderIDList();

// 잔액 확인
$data = $coolsms->balance();

// 전송 채널 상태 조회
$request = new \CoolSMS\PHP74\Request\SMS\GetStatus();

// 발송 문자 확인
$data = $coolsms->sent();

// 문자 발송
$request = new \CoolSMS\PHP74\Request\SMS\PostSend();
$request->to = '수신번호';
$request->text = '문자 내용';
$response = $coolsms->send($request);
```
