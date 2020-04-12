<?php
namespace CoolSMS\PHP74\Request\SMS;

use CoolSMS\PHP74\Request\Request;
use DateTime;

/**
 * Class GetSent
 *
 * @package CoolSMS\PHP74\Request\SMS
 *
 * @property int $count
 * @property int $page
 * @property string $rcpt
 * @property DateTime $start
 * @property DateTime $end
 * @property int $status
 * @property string $resultcode
 * @property string $notin_resultcode
 * @property string $mid
 * @property string $gid
 */
class GetSent extends Request
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'count'             => '?int',
		'page'              => '?int',
		'rcpt'              => '?string',
		'start'             => '?datetime',
		'end'               => '?datetime',
		'status'            => '?int',
		'resultcode'        => '?string',
		'notin_resultcode'  => '?string',
		'mid'               => '?string',
		'gid'               => '?string'
	];

	/**
	 * @var int $count 기본값 20이며 20개의 목록을 받을 수 있음. 40입력시 40개의 목록이 리턴
	 */
	protected ?int $count = 20;

	/**
	 * @var int $page 1부터 시작하는 페이지값
	 */
	protected ?int $page = 1;

	/**
	 * @var string $rcpt 수신번호로 검색
	 */
	protected ?string $rcpt = null;

	/**
	 * @var DateTime $start 검색 시작일시 접수 날짜와 시간으로 검색 YYYY-MM-DD HH:MI:SS 포맷의 날짜와 시간
	 */
	protected ?DateTime $start = null;

	/**
	 * @var DateTime 검색 종료일시 접수 날짜와 시간으로 검색 YYYY-MM-DD HH:MI:SS 포맷의 날짜와 시간
	 */
	protected ?DateTime $end = null;

	/**
	 * @var int $status 메시지 상태 값으로 검색
	 */
	protected ?int $status = null;

	/**
	 * @var string $resultcode 전송결과 값으로 검색
	 */
	protected ?string $resultcode = null;

	/**
	 * @var string $notin_resultcode 입력된 전송결과 값 이외의 건들만 조회
	 */
	protected ?string $notin_resultcode = null;

	/**
	 * @var string $mid 메시지ID
	 */
	protected ?string $mid = null;

	/**
	 * @var string $gid 그룹ID
	 */
	protected ?string $gid = null;

	public function getData(): array
	{
		$data = parent::getData();
		if (isset($data['start']))
			$data['start'] = $this->start->setTimezone($this->timeZone())->format('Y-m-d H:i:s');
		if (isset($data['end']))
			$data['end'] = $this->end->setTimezone($this->timeZone())->format('Y-m-d H:i:s');
		return $data;
	}
}
