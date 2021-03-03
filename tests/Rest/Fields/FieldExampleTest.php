<?php

namespace Tests\Unit\CustomPostType;

use Brain\Monkey;
use Brain\Monkey\Functions;
use EightshiftBoilerplate\Rest\Fields\FieldExample;

use function Tests\setupMocks;

beforeEach(function() {
	Monkey\setUp();
	setupMocks();

	$this->field = new FieldExample();
});

afterEach(function() {
	Monkey\tearDown();
});


test('Register method will call init hook', function () {
	$this->field->register();

	$this->assertSame(10, has_action('rest_api_init', 'EightshiftBoilerplate\Rest\Fields\FieldExample->fieldRegisterCallback()'));
});

test('Field has a valid callback', function () {
	$output = $this->field->fieldCallback(new class{}, 'attr', new class{}, 'post');

	$this->assertStringContainsString($output, 'output data');
});

test('Field registers the callback properly', function () {
	$action = 'field_registered';
	Functions\when('register_rest_field')->justReturn(putenv("SIDEAFFECT={$action}"));

	$this->field->fieldRegisterCallback(new \WP_REST_Server(), 'attr', new class{}, 'post');

	$this->assertEquals(getenv('SIDEAFFECT'), $action);

	// Cleanup.
	putenv('SIDEAFFECT=');
});
