<?php
namespace CoolSMS\PHP74;

/**
 * Class Charge
 *
 * @package CoolSMS\PHP74
 */
class Charge
{
	use TypeTrait;

	public function __construct()
	{
		$this->sms = 20;
		$this->lms = 50;
		$this->mms = 120;
		$this->ata = 13;
		$this->cta = 19;
		$this->cti = 26;
	}
}
