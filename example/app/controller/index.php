<?php

(new Vieber\Page(function(Vieber\App $app) {
	$app->title('Page Title');

	$test = new \App\Test();
	$app->test = $test->foo();

	$foo = new \App\Foo\Bar();
	$foo->run();
}));