<?php
/**
 * @package    Joomla.Language
 *
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * fr-FR localise class
 *
 * @package             Joomla.Language
 * @since               1.6
 */
abstract class Fr_FRLocalise
	{
		/**
		 * Returns the potential suffixes for a specific number of items
		 *
		 * @param 	int $count  The number of items.
		 * @return 	array  An array of potential suffixes.
		 * @since 	1.6
		 */
		public static function getPluralSuffixes($count)
		{
			if ($count == 0)
			{
				$return = array('0');
			}
			elseif($count == 1)
			{
				$return = array('1');
			}
			else
			{
				$return = array('MORE');
			}

			return $return;
		}
		/**
		 * Returns the ignored search words
		 *
		 * @return 	array  An array of ignored search words.
		 * @since 	1.6
		 */
		public static function getIgnoredSearchWords()
		{
			$search_ignore = array();
			$search_ignore[] = "et";
			$search_ignore[] = "si";
			$search_ignore[] = "ou";
			return $search_ignore;
		}
		/**
		 * Returns the lower length limit of search words
		 *
		 * @return	integer  The lower length limit of search words.
		 * @since	1.6
		 */
		public static function getLowerLimitSearchWord()
		{
			return 3;
		}
		/**
		 * Returns the upper length limit of search words
		 *
		 * @return	integer  The upper length limit of search words.
		 * @since	1.6
		 */
		public static function getUpperLimitSearchWord()
		{
			return 20;
		}
		/**
		 * Returns the number of chars to display when searching
		 *
		 * @return      integer  The number of chars to display when searching.
		 * @since      1.6
		 */
		public static function getSearchDisplayedCharactersNumber()
		{
			return 200;
		}

		/**
		 * This method processes a string and replaces all accented UTF-8 characters by unaccented
		 * ASCII-7 "equivalents"
		 *
		 * @param	string	$string	The string to transliterate
		 * @return	string	The transliteration of the string
		 * @since	1.6
		 */
		public static function transliterate($string)
		{
		$str = \Joomla\String\StringHelper::strtolower($string);
		// Specific language transliteration.
		// This one is for latin 1, latin supplement , extended A, Cyrillic, Greek

		$glyph_array = array(
		'a'		=>	'a,??,??,??,??,??,??,??,??,??,???,??,??',
		'ae'	=>	'??',
		'b'		=>	'??,??',
		'c'		=>	'c,??,??,??,??,??,??,??',
		'ch'	=>	'??',
		'd'		=>	'??,??,??,??,??,??,??',
		'dz'	=>	'??',
		'e'		=>	'e,??,??,??,??,??,??,??,??,??,??,??,??',
		'f'		=>	'??,??',
		'g'		=>	'??,??,??,??,??,??,??',
		'h'		=>	'??,??,??,??',
		'i'		=>	'i,??,??,??,??,??,??,??,??,??,??,??,??,??,??,??,??',
		'ij'	=>	'??',
		'j'		=>	'??,j',
		'ja'	=>	'??',
		'ju'	=>	'????',
		'k'		=>	'??,??,??',
		'l'		=>	'??,??,??,??,??,??,??',
		'lj'	=>	'??',
		'm'		=>	'??,??',
		'n'		=>	'??,??,??,??,??,??,??',
		'nj'	=>	'??',
		'o'		=>	'??,??,??,??,??,??,??,??,??,??,??,??',
		'oe'	=>	'??,??',
		'p'		=>	'??,??',
		'ph'	=>	'??',
		'ps'	=>	'??',
		'r'		=>	'??,??,??,??,??,??,??',
		's'		=>	'??,??,??,??,??,??',
		'ss'	=>	'??,??',
		'sh'	=>	'??',
		'shch'	=>	'??',
		't'		=>	'??,??,??,??,??',
		'th'	=>	'??',
		'u'		=>	'u,??,??,??,??,??,??,??,??,??,??,??',
		'v'		=>	'??',
		'w'		=>	'??',
		'x'		=>	'??,??',
		'y'		=>	'??,??,??,??',
		'z'		=>	'??,??,??,??,??,??'
		);

		foreach($glyph_array as $letter => $glyphs)
		{
			$glyphs = explode(',', $glyphs);
			$str = str_replace($glyphs, $letter, $str);
		}

		return $str;
		}
}
