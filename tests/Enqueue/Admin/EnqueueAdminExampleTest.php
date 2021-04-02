<?php

namespace Tests\Unit\Enqueue\Admin;

use Brain\Monkey;
use EightshiftBoilerplate\Enqueue\Admin\EnqueueAdminExample;
use EightshiftBoilerplate\Manifest\ManifestExample;

use function Tests\setupMocks;
use function Tests\mock;

beforeEach(function() {
	Monkey\setUp();
	setupMocks();

	mock('alias:EightshiftBoilerplate\Config\Config')
	->shouldReceive('getProjectName', 'getProjectVersion')
	->andReturn('tests/data');

	$manifest = new ManifestExample();
	$this->example = new EnqueueAdminExample($manifest);
});

afterEach(function() {
	Monkey\tearDown();
});


test('Register method will call login_enqueue_scripts and admin_enqueue_scripts hook', function () {
	$this->example->register();

	$this->assertSame(10, has_action('login_enqueue_scripts', 'EightshiftBoilerplate\Enqueue\Admin\EnqueueAdminExample->enqueueStyles()'));
	$this->assertSame(50, has_action('admin_enqueue_scripts', 'EightshiftBoilerplate\Enqueue\Admin\EnqueueAdminExample->enqueueStyles()'));
	$this->assertSame(10, has_action('admin_enqueue_scripts', 'EightshiftBoilerplate\Enqueue\Admin\EnqueueAdminExample->enqueueScripts()'));
	$this->assertNotSame(10, has_action('wp_enqueue_scripts', 'EightshiftBoilerplate\Enqueue\Admin\EnqueueAdminExample->enqueueStyles()'));
	$this->assertNotSame(10, has_action('wp_enqueue_scripts', 'EightshiftBoilerplate\Enqueue\Admin\EnqueueAdminExample->enqueueScripts()'));
});

test('getAssetsPrefix method will return string', function () {
	$assetsPrefix = $this->example->getAssetsPrefix();

	$this->assertIsString($assetsPrefix, 'getAssetsPrefix method must return a string');
});

test('getAssetsVersion method will return string', function () {
	$assetsVersion = $this->example->getAssetsVersion();

	$this->assertIsString($assetsVersion, 'getAssetsVersion method must return a string');
});
