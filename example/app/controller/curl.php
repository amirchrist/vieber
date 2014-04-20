<?php

namespace Vieber;

(new Page(function(App $app) {
	$app->title('Testing CURL');

	$curl = new Curl('http://posttestserver.com/post.php?dump=1');
	$app->return = $curl->set(['foo' => 'bar'])
		->header([
			'TEST_HEADER_1' => 'TEST_VALUE_1'
		])
		->post();
}));