<?php

namespace Vieber;

(new Page(function(App $app) {
	$app->title('Testing Redis');

	$redis = new Redis();
	$redis->connect();
	$redis->set('foo', 'bar');
	$app->redis_data = $redis->get('foo');
}));