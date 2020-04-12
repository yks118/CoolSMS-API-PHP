# CoolSMS API PHP
https://www.coolsms.co.kr/ 의 PHP 5.3+ 라이브러리 입니다.

## 사용법
Coolsms.php 파일의 #17 에 발급받은 API KEY 와 #22 에 발급받은 API API Secret KEY 를 입력합니다.

```php
// 라이브러리 require
require_once '{PHP 파일 경로}/5.3/Coolsms.php';

// 변수 지정
$coolsms = new \Coolsms\PHP53\Coolsms();

// 문자 발송
$result = $coolsms->send(array(
    'to'    => '수신번호',
    'from'  => '발신번호',
    'text'  => '문자내용'
));

// 발송된 문자메시지의 목록을 가져옵니다.
$list = $coolsms->getSent();

// 예약 문자 취소
$result = $coolsms->cancel();

// 남은 잔액
$data = $coolsms->getBalance();

// 기본 발신번호를 리턴
$data = $coolsms->getSenderidDefault();

// 등록된 발신번호 리스트를 리턴
$data = $coolsms->getSenderidList();

// 전송채널의 상태를 조회합니다.
$data = $coolsms->getStatus();
```
