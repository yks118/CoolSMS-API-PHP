# CoolSMS-API-PHP
최신버전 PHP 라이브러리입니다.  
생각날때마다 업그레이드 예정입니다.  
현재 PHP 7.4 버전에 최적화되어있습니다.

## 사용법
### API KEY 설정
/CoolSMS-API-PHP/V4/Coolsms.php
```php
class Coolsms
{
	/**
	 * @var string $apiKey
	 */
	public static string $apiKey = '{YOUR API KEY}';

	/**
	 * @var string $apiSecret
	 */
	public static string $apiSecret = '{YOUR API SECRET}';

	/**
	 * @var string $timeZone
	 */
	public static string $timeZone = '{YOUR TIMEZONE}';
}
```

### 라이브러리 로드
```php
require_once '{Your Path}/CoolSMS-API-PHP/V4/autoload.php';
$coolSMS = new \CoolSMS\V4\Coolsms();
```

## 잔액조회
```php
/** @var \CoolSMS\V4\Coolsms $coolSMS */
$response = $coolSMS->cash->balance();
print_r($response);
```

## 메세지 전송
### SMS, LMS, MMS 발송
```php
$requestMessage = new \CoolSMS\V4\Messages\RequestMessage([
    'to'    => '수신자 번호',
    'from'  => '등록된 발신자 번호',
    'text'  => '문자 내용'
]);

/** @var \CoolSMS\V4\Coolsms $coolSMS */
$response = $coolSMS->messages->send($requestMessage);
print_r($response);
```

### 카카오 알림톡 발송
```php
$requestMessage = new \CoolSMS\V4\Messages\RequestMessage([
    'to'    => '수신자 번호',
    'from'  => '등록된 발신자 번호',
    'text'  => '문자 내용',

    // 카카오 알림톡 필수 항목
    'kakaoOptions'  => [
        'pfId'          => 'COOLSMS와 연동된 플러스 친구 고유 아이디',
        'templateId'    => '알림톡 템플릿 아이디',
        'disableSms'    => '대체 발송 여부',

        // 버튼이 있는 경우만
        'buttons'   => [
            [
                'buttonName'    => '버튼 이름',
                'buttonType'    => '버튼 종류',
                'linkMo'        => '모바일 링크',
                'linkPc'        => '웹 링크',
                'linkAnd'       => '안드로이드 링크',
                'linkIos'       => 'IOS 링크'
            ]
        ]
    ]
]);

/** @var \CoolSMS\V4\Coolsms $coolSMS */
$response = $coolSMS->messages->send($requestMessage);
print_r($response);
```

## 메세지 전송 이력
```php
/** @var \CoolSMS\V4\Coolsms $coolSMS */
$response = $coolSMS->messages->lists();
print_r($response);
```

## 계정의 메시지 발송 한도 조회
```php
/** @var \CoolSMS\V4\Coolsms $coolSMS */
$response = $coolSMS->quota->me();
print_r($response);
```

## 발신번호 정보를 조회
```php
/** @var \CoolSMS\V4\Coolsms $coolSMS */
$response = $coolSMS->senderId->numbers();
print_r($response);
```
