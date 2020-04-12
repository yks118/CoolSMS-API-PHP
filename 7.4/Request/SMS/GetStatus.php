<?php
namespace CoolSMS\PHP74\Request\SMS;

use CoolSMS\PHP74\Request\Request;
use DateTime;

/**
 * Class GetStatus
 *
 * @package CoolSMS\PHP74\Request\SMS
 *
 * @property int $count
 * @property string $unit
 * @property DateTime $date
 * @property int $channel
 */
class GetStatus extends Request
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'count'     => '?int',
		'unit'      => '?string',
		'date'      => '?datetime',
		'channel'   => '?int'
	];

	/**
	 * @var int $count 기본값 1이며 1개의 최신의 레코드를 받을 수 있음, 10입력시 10분 동안의 레코드 목록을 리턴
	 */
	protected ?int $count = 1;

	/**
	 * @var string $unit minute / hour / day
	 */
	protected ?string $unit = 'minute';

	/**
	 * @var DateTime $date YYYYMMDDHHMISS
	 */
	protected ?DateTime $date = null;

	/**
	 * @var int $channel 1 (1건 발송 채널) / 2 (대량 발송 채널)
	 */
	protected ?int $channel = 1;

	public function getData(): array
	{
		$data = parent::getData();
		if (isset($data['date']))
			$data['date'] = $this->date->setTimezone($this->timeZone())->format('YmdHis');
		return $data;
	}
}
