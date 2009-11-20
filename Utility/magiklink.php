<?
/**
 * MagikLink
 * 
 * @author Casey Pugh
 * @about Convert any plaintext link into an anchored link.
 * @example
 * 	vimeo.com 			 -> <a href="http://vimeo.com" target="_blank" rel="nofollow">vimeo.com</a>
 * 	http://www.vimeo.com -> <a href="http://www.vimeo.com" target="_blank" rel="nofollow">vimeo.com</a>
 */
class Utility 
{	
	public static function convertToLink($text, $args = false)
	{	
		if (!$args) 
			$args = array();
			
		if (!$args['target']) 
			$args['target'] = '_blank';
			
		if ($args['class']) 
			$args['class'] = " class=\"{$args['class']}\"";
		
		
		$valid_url   		= "[-a-zA-Z0-9@\$:%_\+.~#?&//=\']+[-a-zA-Z0-9@:%_\+~#?&//=\']+";
		$domain_extensions  = array('com', 'net', 'org', 'co\.uk', 'edu', 'info', 'biz', 'mobi', 'eu', 'bz', 'de', 'us', 'tv');
		
		// Some link preparation
		$text = eregi_replace("([[:space:]]*)?((www\.)?([-a-zA-Z0-9@:%_\+.~#?&//=\']+\.(".implode('|',$domain_extensions).")))","\\1http://\\2", $text);  
		
		// Clean up extra https
		$text = eregi_replace('((http://)(([a-z]+)://))',"\\4://", $text);  
		$text = eregi_replace('(http://)([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',"\\2", $text);  
	
		// Convert emails to links
		$text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})','<a href="mailto:\\1"'.$args['class'].'>\\1</a>', $text);
		
		// convert all the urls to links
		$text = eregi_replace("([[:space:]]+)(((f|ht){1}tp(s)?://)(www\.)?($valid_url))",'\\1<a href="\\2" target="{$args['target']}"{$args['class']} rel="nofollow">\\7</a>', $text);  

		// strip out the delim stuff from above
		if (strpos($text, $delim) !== false)
			$text = str_replace($delim, '', $text );
			
		// berak up the string with a space. it will line break if it needs to.
		$text = str_replace($uniq_vimeo_br, ' ', $text);
		
		// special case for converting links at beginning of string
		$text = eregi_replace("^(((f|ht){1}tp(s)?://)(www\.)?($valid_url))",'<a href="\\1" target="{$args['target']}"{$args['class']} rel="nofollow">\\6</a>', $text);  

		return $text;
	}
}