<?php

namespace Vieber;

(new Page(function(App $app) {
	$app->title('Testing File Uploads');

	if (!empty($_FILES['file'])) {
		$file = new File\Upload($_FILES['file']);
		if (!$file->upload()) {
			$app->upload_failed = $file->error_msg();
		} else {
			$app->uploaded_file = $file->url();
		}
	}
}));