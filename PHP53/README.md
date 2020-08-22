# CoolSMS-API-PHP
PHP 5.3+ 라이브러리입니다.  
업그레이드 예정은 없습니다.  
버그가 있는 경우 이슈트래커에 남겨주시거나, 풀리퀘스트 주시면 수정 및 반영하도록 하겠습니다.  
CoolSMS API V4 를 사용하고 있기 때문에, 여러개의 버튼으로 이루어진 카카오 알림톡 발송이 가능합니다.

## 사용법
### API KEY 설정
/CoolSMS-API-PHP/PHP53/Coolsms.php
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
require_once '{Your Path}/CoolSMS-API-PHP/PHP53/Coolsms.php';
$coolSMS = new \CoolSMS\PHP53\Coolsms();
```

## 잔액조회
```php
/** @var \CoolSMS\PHP53\Coolsms $coolSMS */
$response = $coolSMS->cashBalance();
print_r($response);
```

## 메세지 전송
### SMS, LMS, MMS 발송
```php
/** @var \CoolSMS\PHP53\Coolsms $coolSMS */
$response = $coolSMS->messagesSend(array(
    'to'    => '수신자 번호',
    'from'  => '등록된 발신자 번호',
    'text'  => '문자 내용'
));
print_r($response);
```

### 카카오 알림톡 발송
```php
/** @var \CoolSMS\PHP53\Coolsms $coolSMS */
$response = $coolSMS->messagesSend(array(
    'to'    => '수신자 번호',
    'from'  => '등록된 발신자 번호',
    'text'  => '문자 내용',

    // 카카오 알림톡 필수 항목
    'kakaoOptions'  => array(
        'pfId'          => 'COOLSMS와 연동된 플러스 친구 고유 아이디',
        'templateId'    => '알림톡 템플릿 아이디',
        'disableSms'    => '대체 발송 여부',

        // 버튼이 있는 경우만
        'buttons'   => array(
            array(
                'buttonName'    => '버튼 이름',
                'buttonType'    => '버튼 종류',
                'linkMo'        => '모바일 링크',
                'linkPc'        => '웹 링크',
                'linkAnd'       => '안드로이드 링크',
                'linkIos'       => 'IOS 링크'
            )
        )
    )
));
print_r($response);
```

## 메세지 전송 이력
```php
/** @var \CoolSMS\PHP53\Coolsms $coolSMS */
$response = $coolSMS->messageslist();
print_r($response);
```

## 계정의 메시지 발송 한도 조회
```php
/** @var \CoolSMS\PHP53\Coolsms $coolSMS */
$response = $coolSMS->quotaMe();
print_r($response);
```

## 발신번호 정보를 조회
```php
/** @var \CoolSMS\PHP53\Coolsms $coolSMS */
$response = $coolSMS->senderIdNumbers();
print_r($response);
```
