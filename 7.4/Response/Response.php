<?php
namespace CoolSMS\PHP74\Response;

use DateTime;
use DateTimeZone;
use function GuzzleHttp\Psr7\str;

/**
 * Class Response
 *
 * @package CoolSMS\PHP74\Response
 */
class Response
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [];

	/**
	 * @var array $original
	 */
	private array $original = [];

	public function __construct(array $data)
	{
		$this->original = $data;
		$timezone = new DateTimeZone('Asia/Seoul');

		foreach ($data as $key => $value)
		{
			if (!isset($this->castings[$key]) || empty($value))
				continue;

			switch ($this->castings[$key])
			{
				case 'int' :
				case '?int' :
					$this->$key = (int) $value;
					break;
				case 'datetime' :
				case '?datetime' :
					try
					{
						$this->$key = new DateTime($value, $timezone);
					}
					catch (\Exception $e)
					{
						echo 'Response Error : ' . $key;
					}
					break;
				case 'array' :
				case '?array' :
					if (is_array($value))
						$this->$key = $value;
					break;
				default :
					$this->$key = (string) $value;
					break;
			}
		}
	}

	public function __get(string $name)
	{
		if (isset($this->$name))
			return $this->$name;
		return null;
	}
}
