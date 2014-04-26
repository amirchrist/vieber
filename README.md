vieber
======

Vieber is a small, lightweight PHP framework with the goal to create fast PHP apps. It was developed as a default framework
for the creation of Apps for [Moxi9](http://moxi9.com/)

## Requirements

PHP 5.5 or higher

## Install

Clone and check out a working example in the **example/** folder.

Make sure the following folders are writeable:
 /static/cache/
 /static/css/
 /static/jscript/
 /static/uploads/

To boot up Vieber from your own PHP App just require the **boot.php** file.
```
require('/src/vieber/boot.php');
```

Next, define your enviroment:
```
Vieber\Engine::start([
	'app_path' => dirname(__FILE__) . '/app/',
	'theme_path' => dirname(__FILE__) . '/theme/',
	'jscript_path' => dirname(__FILE__) . '/jscript/',
	'static_path' => dirname(__FILE__) . '/static/',
	'static_url' => 'http://localhost/moxi9/vieber/example/static/',
	'url' => 'http://localhost/moxi9/vieber/example/',
	'dev_mode' => true
]);
```

These are the basic params that are required to get you up and running. With those settings in mind you then
need to create the following file structure.
* /app/
 * /controller/index.php
 * /model/
 * /view/index.html
* /jscript/main.js
* /static/
 * /cache/
 * /css/
 * /jscript/
 * /uploads/
* /theme/
 * /css/layout.css
 * /html/layout.html
