<?php
namespace CoolSMS\V4\Messages;

use CoolSMS\V4\Coolsms;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ResponseListMessageListLogOriginalData
 *
 * @package CoolSMS\V4\Messages
 */
class ResponseListMessageListLogOriginalData
{
	/**
	 * @var string $PLATFORM_MSGID
	 */
	public string $PLATFORM_MSGID;

	/**
	 * @var int $MSG_SEQ
	 */
	public int $MSG_SEQ;

	/**
	 * @var int $CUR_STATE
	 */
	public int $CUR_STATE;

	/**
	 * @var DateTime $SENT_DATE
	 */
	public DateTime $SENT_DATE;

	/**
	 * @var DateTime $RSLT_DATE
	 */
	public DateTime $RSLT_DATE;

	/**
	 * @var DateTime $REPORT_DATE
	 */
	public DateTime $REPORT_DATE;

	/**
	 * @var int $RSLT_CODE
	 */
	public int $RSLT_CODE;

	/**
	 * @var string $RSLT_CODE2
	 */
	public string $RSLT_CODE2;

	/**
	 * @var string $RSLT_NET
	 */
	public string $RSLT_NET;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value)
		{
			if (in_array($key, ['SENT_DATE', 'RSLT_DATE', 'REPORT_DATE']))
			{
				try
				{
					$dateTime = new DateTime($value);
					$this->$key = $dateTime->setTimezone(new DateTimeZone(Coolsms::$timeZone));
				}
				catch (Exception $e)
				{}
			}
			else
				$this->$key = $value;
		}
	}
}
