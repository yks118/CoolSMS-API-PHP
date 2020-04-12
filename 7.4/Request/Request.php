<?php
namespace CoolSMS\PHP74\Request;

use DateTime;
use DateTimeZone;
use function GuzzleHttp\Psr7\str;

/**
 * Class Request
 *
 * @package CoolSMS\PHP74\Request
 */
class Request
{
	/**
	 * @var array $castings
	 */
	protected array $castings = [];

	/**
	 * @var DateTimeZone $timezone
	 */
	private ?DateTimeZone $timezone = null;

	public function __construct(array $data = [])
	{
		foreach ($data as $key => $value)
		{
			if (isset($this->castings[$key]))
				$this->casting($key, $value);
		}
	}

	public function __set(string $name, $value)
	{
		if (isset($this->$name))
			$this->casting($name, $value);
	}

	/**
	 * getData
	 *
	 * @return  array
	 */
	public function getData(): array
	{
		$vars = get_object_vars($this);
		unset($vars['castings']);
		unset($vars['timezone']);
		return array_filter($vars);
	}

	private function casting(string $key, $value)
	{
		if (isset($this->castings[$key]))
		{
			switch ($this->castings[$key])
			{
				case 'int' :
				case '?int' :
					$this->$key = (int) $value;
					break;
				case 'datetime' :
				case '?datetime' :
					if (get_class($value) === 'DateTime')
						$this->$key = $value;

					try
					{
						$this->$key = new DateTime($value, $this->timeZone());
					}
					catch (\Exception $e)
					{
						die('Error : Request datetime');
					}
					break;
				case 'bool' :
				case '?bool' :
					if ($value === 'true' || $value)
						$this->$key = true;
					else
						$this->$key = false;
					break;
				default :
					$this->$key = (string) $value;
					break;
			}
		}
	}

	protected function timeZone(): DateTimeZone
	{
		if (is_null($this->timezone))
			$this->timezone = new DateTimeZone('Asia/Seoul');
		return $this->timezone;
	}
}
