<?php

/**
 * Helpers for media.
 *
 * @package EightshiftLibs\Helpers
 */

declare(strict_types=1);

namespace EightshiftLibs\Helpers;

use EightshiftLibs\Media\AbstractMedia;
use EightshiftLibs\Media\UseWebPMediaCli;

/**
 * Class MediaTrait Helper
 */
trait MediaTrait
{
	/**
	 * Return WebP format from the original path.
	 *
	 * @param string $path Path to original media file.
	 *
	 * @return string
	 */
	public static function getWebPMedia(string $path): string
	{
		$typeData = \wp_check_filetype($path);
		$ext = $typeData['ext'];
		$allowed = \array_flip(AbstractMedia::WEBP_ALLOWED_EXT);

		if (!isset($allowed[$ext])) {
			return '';
		}

		return \str_replace(".{$ext}", '.webp', $path);
	}

	/**
	 * Check if WebP Media is used based on the options setting.
	 *
	 * @return boolean
	 */
	public static function isWebPMediaUsed(): bool
	{
		return (bool) \get_option(UseWebPMediaCli::USE_WEBP_MEDIA_OPTION_NAME, 'true');
	}

	/**
	 * Check if WebP media exist by testing the original media.
	 *
	 * @param integer $attachmentId Id of the media.
	 *
	 * @return boolean
	 */
	public static function existsWebPMedia(int $attachmentId): bool
	{
		$filePath = \get_attached_file($attachmentId);

		$image = self::getWebPMedia($filePath);

		return \file_exists($image);
	}
}
