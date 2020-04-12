<?php
namespace CoolSMS\PHP74;

/**
 * Trait TypeTrait
 *
 * @package CoolSMS\PHP74
 */
trait TypeTrait
{
	/**
	 * @var int $sms 단문문자
	 */
	public ?int $sms = null;

	/**
	 * @var int $lms 장문문자
	 */
	public ?int $lms = null;

	/**
	 * @var int $mms 사진문자
	 */
	public ?int $mms = null;

	/**
	 * @var int $ata 카카오 알림톡
	 */
	public ?int $ata = null;

	/**
	 * @var int $cta 카카오 친구톡
	 */
	public ?int $cta = null;

	/**
	 * @var int $cti 친구톡 이미지
	 */
	public ?int $cti = null;
}
