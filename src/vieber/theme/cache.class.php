<?php
/**
 * [PRODUCT_HEADER]
 */

namespace Vieber\Theme;

class Cache {
	private $_app;
	private $_compiled_text;

	public function __construct(\Vieber\App $app, $data) {
		$this->_app = $app;

		$ldq = preg_quote('## ');
		$rdq = preg_quote(' ##');

		// remove all comments
		$data = preg_replace("/\/\*(.*?)\*\//s", "", $data);

		// Replace php code
		/*$data = str_replace(array('<?php', '<?', '?>'), '', $data);*/

		$text = preg_split("!{$ldq}.*?{$rdq}!s", $data);

		preg_match_all("!{$ldq}\s*(.*?)\s*{$rdq}!s", $data, $aMatches);
		$aTags = $aMatches[1];

		$compiledTags = array();
		$iCompiledTags = count($aTags);
		for ($i = 0, $iForMax = $iCompiledTags; $i < $iForMax; $i++)
		{
			$compiledTags[] = $this->_compile_tag($aTags[$i]);
		}

		$iCountCompiledTags = count($compiledTags);
		for ($i = 0, $iForMax = $iCountCompiledTags; $i < $iForMax; $i++)
		{
			if ($compiledTags[$i] == '')
			{
				$text[$i+1] = preg_replace('~^(\r\n|\r|\n)~', '', $text[$i+1]);
			}
			$this->_compiled_text .= $text[$i].$compiledTags[$i];
		}
		$this->_compiled_text .= $text[$i];

		$this->_compiled_text = preg_replace('!\?>\n?<\?php!', '', $this->_compiled_text);
	}

	public function parsed() {
		return $this->_compiled_text;
	}

	private function _compile_tag($tag) {
		if ($tag == 'content'){
			return $this->_app->content();
		}

		$return = '<?php ';
		if (substr($tag, 0, 1) == '$')
		{
			$return .= 'echo ' . $tag . ';';
		}
		else if (substr($tag, 0, 7) == 'foreach' || substr($tag, 0, 2) == 'if' || substr($tag, 0, 3) == 'for' || substr($tag, 0, 4) == 'else')
		{
			$return .= $tag . ':';
		}
		else if ($tag == '/foreach')
		{
			$return .= 'endforeach;';
		}
		else if ($tag == '/if')
		{
			$return .= 'endif;';
		}
		else if ($tag == '/for')
		{
			$return .= 'endfor;';
		}
		else if ($tag == 'title')
		{
			$return .= 'echo $app->title();';
		}
		else if ($tag == 'header')
		{
			$return .= 'echo $app->header();';
		}
		else if ($tag == 'footer')
		{
			$return .= 'echo $app->footer();';
		}
		else if (substr($tag, 0, 4) == 'url ')
		{
			$return .= 'echo (new \Vieber\Url())->link(\'' . substr($tag, 4) . '\');';
		}
		else
		{
			$return .= 'echo "<!-- PHP NOT ALLOWED: ' . htmlspecialchars($tag) . ' -->";';
		}
		$return .= ' ?>';

		return $return;
	}
}

?>