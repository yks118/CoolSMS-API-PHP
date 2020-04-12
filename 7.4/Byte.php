<?php
namespace CoolSMS\PHP74;

/**
 * Class Byte
 *
 * @package CoolSMS\PHP74
 */
class Byte
{
	use TypeTrait;

	public function __construct()
	{
		$this->sms = 90;
		$this->lms = 2000;
		$this->mms = 2000;
	}
}
