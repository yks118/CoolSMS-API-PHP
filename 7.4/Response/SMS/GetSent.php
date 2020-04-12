<?php
namespace CoolSMS\PHP74\Response\SMS;

use CoolSMS\PHP74\Response\Response;

/**
 * Class GetSent
 *
 * @package CoolSMS\PHP74\Response\SMS
 *
 * @property int $total_count
 * @property int $list_count
 * @property int $page
 * @property array $data
 */
class GetSent extends Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [
		'total_count'   => '?int',
		'list_count'    => '?int',
		'page'          => '?int',
		'data'          => '?array'
	];

	/**
	 * @var int $total_count
	 */
	protected ?int $total_count = null;

	/**
	 * @var int $list_count
	 */
	protected ?int $list_count = null;

	/**
	 * @var int $page
	 */
	protected ?int $page = null;

	/**
	 * @var array $data
	 */
	protected ?array $data = null;

	public function __construct(array $data)
	{
		parent::__construct($data);

		if (isset($data['data']) && is_array($data['data']))
		{
			foreach ($data['data'] as $key => $row)
			{
				$this->data[$key] = new GetSentData($row);
			}
		}
	}
}
