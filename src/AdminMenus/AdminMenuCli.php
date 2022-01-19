<?php

/**
 * Class that registers WPCLI command for Admin menu creation.
 *
 * @package EightshiftLibs\AdminMenus
 */

declare(strict_types=1);

namespace EightshiftLibs\AdminMenus;

use EightshiftLibs\Cli\AbstractCli;

/**
 * Class AdminMenuCli
 */
class AdminMenuCli extends AbstractCli
{
	/**
	 * Output dir relative path.
	 *
	 * @var string
	 */
	public const OUTPUT_DIR = 'src' . DIRECTORY_SEPARATOR . 'AdminMenus';

	/**
	 * Define default develop props.
	 *
	 * @param string[] $args WPCLI eval-file arguments.
	 *
	 * @return array<string, mixed>
	 */
	public function getDevelopArgs(array $args): array
	{
		return [
			'title' => $args[1] ?? 'Admin Title',
			'menu_title' => $args[2] ?? 'Admin Title',
			'capability' => $args[3] ?? 'edit_posts',
			'menu_slug' => $args[4] ?? 'admin_title',
			'menu_icon' => $args[5] ?? 'dashicons-admin-generic',
			'menu_position' => $args[6] ?? 100,
		];
	}

	/**
	 * Get WPCLI command doc
	 *
	 * @return array<string, array<int, array<string, bool|string>>|string>
	 */
	public function getDoc(): array
	{
		return [
			'shortdesc' => 'Generates admin menu class file.',
			'synopsis' => [
				[
					'type' => 'assoc',
					'name' => 'title',
					'description' => 'The text to be displayed in the title tags of the page when the menu is selected.',
					'optional' => !getenv('DEVELOP_MODE') ?: false, // phpcs:ignore WordPress.PHP.DisallowShortTernary.Found
				],
				[
					'type' => 'assoc',
					'name' => 'menu_title',
					'description' => 'The text to be used for the menu.',
					'optional' => !getenv('DEVELOP_MODE') ?: false, // phpcs:ignore WordPress.PHP.DisallowShortTernary.Found
				],
				[
					'type' => 'assoc',
					'name' => 'capability',
					'description' => 'The capability required for this menu to be displayed to the user.',
					'optional' => !getenv('DEVELOP_MODE') ?: false, // phpcs:ignore WordPress.PHP.DisallowShortTernary.Found
				],
				[
					'type' => 'assoc',
					'name' => 'menu_slug',
					'description' => 'The slug name to refer to this menu by.
					Should be unique for this menu page and only include lowercase alphanumeric, dashes, and underscores characters to be compatible with sanitize_key().',
					'optional' => !getenv('DEVELOP_MODE') ?: false, // phpcs:ignore WordPress.PHP.DisallowShortTernary.Found
				],
				[
					'type' => 'assoc',
					'name' => 'menu_icon',
					'description' => 'The default menu icon for the admin menu. Example: dashicons-admin-generic.',
					'optional' => true,
				],
				[
					'type' => 'assoc',
					'name' => 'menu_position',
					'description' => 'The default menu position. Example: 20.',
					'optional' => true,
				],
			],
		];
	}

	/* @phpstan-ignore-next-line */
	public function __invoke(array $args, array $assocArgs) // phpcs:ignore
	{
		// Get Arguments.
		$title = $assocArgs['title'] ?? '';
		$menuTitle = $assocArgs['menu_title'] ?? '';
		$capability = $assocArgs['capability'] ?? '';
		$menuSlug = $this->prepareSlug($assocArgs['menu_slug'] ?? '');
		$menuIcon = $assocArgs['menu_icon'] ?? '';
		$menuPosition = (string)($assocArgs['menu_position'] ?? '');

		// Get full class name.
		$className = $this->getFileName($menuSlug);
		$className = $className . $this->getClassShortName();

		// Read the template contents, and replace the placeholders with provided variables.
		$class = $this->getExampleTemplate(__DIR__, $this->getClassShortName())
			->renameClassNameWithPrefix($this->getClassShortName(), $className)
			->renameNamespace($assocArgs)
			->renameUse($assocArgs)
			->renameTextDomain($assocArgs)
			->searchReplaceString('Admin Title', $title)
			->searchReplaceString('Admin Menu Title', $menuTitle)
			->searchReplaceString("'edit_posts'", "'{$capability}'")
			->searchReplaceString('example-menu-slug', $menuSlug);

		if (!empty($menuPosition)) {
			$class->searchReplaceString('100', $menuPosition);
		}

		if (!empty($menuIcon)) {
			$class->searchReplaceString('dashicons-admin-generic', $menuIcon);
		}

		// Output final class to new file/folder and finish.
		$class->outputWrite(static::OUTPUT_DIR, $className, $assocArgs);
	}
}
