<?php
/**
 * @version    3.8.x
 * @package    Simple Image Gallery Pro
 * @author     JoomlaWorks - https://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2020 JoomlaWorks Ltd. All rights reserved.
 * @license    https://www.joomlaworks.net/license
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class SimpleImageGalleryProHelper
{
    public static function renderGallery($srcimgfolder, $thb_width, $thb_height, $smartResize, $jpg_quality, $sortorder, $showcaptions, $itemTitle, $wordLimit, $cache_expire_time, $downloadFile, $gal_id, $resizeSrcImage)
    {
        // API
        jimport('joomla.filesystem.folder');

        // Get site language
        $language = JFactory::getLanguage();
        $currentLanguage = $language->getTag();
        $defaultLanguage = $language->getDefault();

        // Path assignment
        $sitePath = JPATH_SITE.'/';
        if (JRequest::getCmd('format')=='feed') {
            $siteUrl = JURI::root(true).'';
        } else {
            $siteUrl = JURI::root(true).'/';
        }

        // Internal parameters
        $prefix = "jwsigpro_cache_";

        // Set the cache folder
        $cacheFolderPath = JPATH_SITE.DS.'cache'.DS.'jw_sigpro';
        if (file_exists($cacheFolderPath) && is_dir($cacheFolderPath)) {
            // all OK
        } else {
            mkdir($cacheFolderPath);
        }

        // Check if the source folder exists and read it
        $srcFolder = JFolder::files($sitePath.$srcimgfolder);

        // Proceed if the folder is OK or fail silently
        if (!$srcFolder) {
            return;
        }

        // Loop through the source folder for images
        $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
        // Create an array of file types
        $found = array();
        // Create an array for matching files
        foreach ($srcFolder as $srcImage) {
            $fileInfo = pathinfo($srcImage);
            if (array_key_exists('extension', $fileInfo) && in_array(strtolower($fileInfo['extension']), $fileTypes)) {
                $found[] = $srcImage;
            }
        }

        // Bail out if there are no images found
        if (count($found) == 0) {
            return;
        }

        // Sort array
        switch ($sortorder) {
            case 0:
                sort($found);
                break;
            case 1:
                // Sort in natural, case-sensitive order
                natsort($found);
                break;
            case 2:
                // Sort in natural, case-insensitive order
                natcasesort($found);
                break;
            case 3:
                rsort($found);
                break;
            case 4:
                shuffle($found);
                break;
        }

        // Caption handling
        $defaultCaptionFilePath = JPATH_SITE.DS.str_replace('/', DS, $srcimgfolder).DS.$defaultLanguage.'.labels.txt';
        $currentCaptionFilePath = JPATH_SITE.DS.str_replace('/', DS, $srcimgfolder).DS.$currentLanguage.'.labels.txt';
        $legacyCaptionFilePath = JPATH_SITE.DS.str_replace('/', DS, $srcimgfolder).DS.'labels.txt';

        if ($currentLanguage == $defaultLanguage) {
            if (file_exists($legacyCaptionFilePath)) {
                $captionFile = "labels.txt";
            } else {
                $captionFile = $defaultLanguage.".labels.txt";
            }
        } else {
            $captionFile = $currentLanguage.".labels.txt";
        }

        $captionFilePath = JPATH_SITE.DS.str_replace('/', DS, $srcimgfolder).DS.$captionFile;
        $captions = array();

        if (file_exists($captionFilePath) && is_readable($captionFilePath)) {
            // read the captions file into an array
            $captionsfile = file($captionFilePath);
            foreach ($captionsfile as $caption) {
                $temp = explode("|", $caption);
                if (isset($temp[0]) && file_exists(JPATH_SITE.DS.$srcimgfolder.DS.$temp[0])) {
                    $captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($temp[0])]['title'] = @$temp[1];
                    // maintain backwards compatibility regarding captions
                    if (isset($temp[2])) {
                        $captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($temp[0])]['description'] = @$temp[2];
                    } else {
                        $captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($temp[0])]['description'] = @$temp[1];
                    }
                }
            }
        } else {
            if ($showcaptions == 2) {
                // Check if a captions file exists and if not write a new captions file and fill it with the image file list and content placeholders
                $captionsfile = fopen($captionFilePath, 'w');
                foreach ($found as $filename) {
                    fwrite($captionsfile, "$filename||\n");
                }
                fclose($captionsfile);

                // Read the new file
                $newcaptionsfile = file($captionFilePath);
                foreach ($newcaptionsfile as $caption) {
                    $temp = explode("|", $caption);
                    if (isset($temp[0]) && file_exists(JPATH_SITE.DS.$srcimgfolder."/".$temp[0])) {
                        $captions[JPATH_SITE.DS.$srcimgfolder."/".strtolower($temp[0])]['title'] = (isset($temp[1])) ? $temp[1] : '';
                        $captions[JPATH_SITE.DS.$srcimgfolder."/".strtolower($temp[0])]['description'] = (isset($temp[2])) ? $temp[2] : '';
                    }
                }
            }
        }

        // Initiate array to hold gallery
        $gallery = array();

        // Fix the image array keys
        $found = array_values($found);

        // Loop through the image file list
        foreach ($found as $key => $filename) {
            // Determine thumb image filename
            if (strtolower(substr($filename, -4, 4)) == 'jpeg') {
                $thumbfilename = substr($filename, 0, -4).'jpg';
            } elseif (strtolower(substr($filename, -3, 3)) == 'gif' || strtolower(substr($filename, -3, 3)) == 'png' || strtolower(substr($filename, -3, 3)) == 'jpg') {
                $thumbfilename = substr($filename, 0, -3).'jpg';
            }

            // Object to hold each image elements
            $gallery[$key] = new JObject;

            // Assign source image and path to a variable
            $original = $sitePath.str_replace('/', DS, $srcimgfolder).DS.$filename;

            // Caption display
            if ($showcaptions == 2) {
                $gallery[$key]->captionTitle = (isset($captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($filename)]['title'])) ? $captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($filename)]['title'] : '';
                $gallery[$key]->captionDescription = (isset($captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($filename)]['description'])) ? $captions[JPATH_SITE.DS.$srcimgfolder.DS.strtolower($filename)]['description'] : '';
                $gallery[$key]->captionDescription = str_replace('$', '&dollar;', $gallery[$key]->captionDescription);
            } elseif ($showcaptions == 1) {
                $gallery[$key]->captionTitle = '';
                $gallery[$key]->captionDescription = JText::_('JW_SIGP_PLG_GENERIC_DESCRIPTION').'<br /><span class="sigProPopupCaption">'.$itemTitle."</span>";
            } else {
                $gallery[$key]->captionTitle = '';
                $gallery[$key]->captionDescription = '';
            }

            if ($wordLimit) {
                $gallery[$key]->captionTitle = self::wordLimit($gallery[$key]->captionTitle, $wordLimit);
            }

            $gallery[$key]->captionTitle = htmlentities(strip_tags($gallery[$key]->captionTitle), ENT_QUOTES, 'utf-8');
            $gallery[$key]->captionDescription = htmlentities($gallery[$key]->captionDescription, ENT_QUOTES, 'utf-8');

            if ($downloadFile) {
                $gallery[$key]->downloadLink = self::replaceHtml('<br /><a class="sigProDownloadLink" href="'.$downloadFile.'?file='.$srcimgfolder.'/'.self::replaceWhiteSpace($filename).'" download>'.JText::_('JW_SIGP_PLG_DOWNLOAD_IMG').'</a>');
            } else {
                $gallery[$key]->downloadLink = '';
            }

            // Check if thumb image exists already
            $thumbimage = $cacheFolderPath.DS.$prefix.$gal_id.'_'.strtolower(self::cleanThumbName($thumbfilename));

            if (file_exists($thumbimage) && is_readable($thumbimage) && (filemtime($thumbimage) + $cache_expire_time) > time()) {

                // do nothing
            } else {

                // Otherwise create the thumb image

                // begin by getting the details of the original
                list($width, $height, $type) = getimagesize($original);

                // strip the extension off the image filename (case insensitive)
                //$imagetypes = array('/\.gif$/i', '/\.jpg$/i', '/\.jpeg$/i', '/\.png$/i');
                //$name = preg_replace($imagetypes, '', basename($original));

                // create an image resource for the original
                switch ($type) {
                    case 1:
                        $source = @ imagecreatefromgif($original);
                        if (!$source) {
                            JError::raiseNotice('', JText::_('JW_SIGP_PLG_GIF_IMAGE_PROCESS_FAILED'));
                            return;
                        }
                        break;
                    case 2:
                        $source = imagecreatefromjpeg($original);
                        break;
                    case 3:
                        $source = imagecreatefrompng($original);
                        break;
                    default:
                        $source = null;
                }

                // Bail out if the image resource is not OK
                if (!$source) {
                    JError::raiseNotice('', JText::_('JW_SIGP_PLG_SRC_IMG_CONVERSION_FAILED'));
                    return;
                }

                // calculate thumbnails
                $thumbnail = self::thumbDimCalc($width, $height, $thb_width, $thb_height, $smartResize);

                $thumb_width = $thumbnail['width'];
                $thumb_height = $thumbnail['height'];

                // create an image resource for the thumbnail
                $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

                // create the resized copy
                imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);

                // convert and save all thumbs to .jpg
                $success = imagejpeg($thumb, $thumbimage, $jpg_quality);

                // bail out if there is a problem in the GD conversion
                if (!$success) {
                    return;
                }

                // remove the image resources from memory
                imagedestroy($source);
                imagedestroy($thumb);
            }

            // Assemble the image elements
            $gallery[$key]->filename = $filename;
            $gallery[$key]->sourceImageFilePath = $siteUrl.$srcimgfolder.'/'.self::replaceWhiteSpace($filename);
            if ($resizeSrcImage) {
                $gallery[$key]->sourceImageFilePath = '//ir0.mobify.com/'.$resizeSrcImage.'/'.JURI::root(false).$srcimgfolder.'/'.self::replaceWhiteSpace($filename);
            }
            $gallery[$key]->thumbImageFilePath = $siteUrl.'cache/jw_sigpro/'.$prefix.$gal_id.'_'.strtolower(self::cleanThumbName($thumbfilename));
            $gallery[$key]->width = $thb_width;
            $gallery[$key]->height = $thb_height;
        } // foreach loop

        // OUTPUT
        return $gallery;
    }

    /* ------------------ Helper Functions ------------------ */

    // Calculate thumbnail dimensions
    public static function thumbDimCalc($width, $height, $thb_width, $thb_height, $smartResize)
    {
        if ($smartResize) {

            // thumb ratio bigger that container ratio
            if ($width / $height > $thb_width / $thb_height) {
                // wide containers
                if ($thb_width >= $thb_height) {
                    // wide thumbs
                    if ($width > $height) {
                        $thumb_width = $thb_height * $width / $height;
                        $thumb_height = $thb_height;
                    }
                    // high thumbs
                    else {
                        $thumb_width = $thb_height * $width / $height;
                        $thumb_height = $thb_height;
                    }
                    // high containers
                } else {
                    // wide thumbs
                    if ($width > $height) {
                        $thumb_width = $thb_height * $width / $height;
                        $thumb_height = $thb_height;
                    }
                    // high thumbs
                    else {
                        $thumb_width = $thb_height * $width / $height;
                        $thumb_height = $thb_height;
                    }
                }
            } else {
                // wide containers
                if ($thb_width >= $thb_height) {
                    // wide thumbs
                    if ($width > $height) {
                        $thumb_width = $thb_width;
                        $thumb_height = $thb_width * $height / $width;
                    }
                    // high thumbs
                    else {
                        $thumb_width = $thb_width;
                        $thumb_height = $thb_width * $height / $width;
                    }
                    // high containers
                } else {
                    // wide thumbs
                    if ($width > $height) {
                        $thumb_width = $thb_height * $width / $height;
                        $thumb_height = $thb_height;
                    }
                    // high thumbs
                    else {
                        $thumb_width = $thb_width;
                        $thumb_height = $thb_width * $height / $width;
                    }
                }
            }
        } else {
            if ($width > $height) {
                $thumb_width = $thb_width;
                $thumb_height = $thb_width * $height / $width;
            } elseif ($width < $height) {
                $thumb_width = $thb_height * $width / $height;
                $thumb_height = $thb_height;
            } else {
                $thumb_width = $thb_width;
                $thumb_height = $thb_height;
            }
        }

        $thumbnail = array();
        $thumbnail['width'] = round($thumb_width);
        $thumbnail['height'] = round($thumb_height);

        return $thumbnail;
    }

    // Load Module Position
    public static function loadModulePosition($position, $style = '')
    {
        $document = JFactory::getDocument();
        $renderer = $document->loadRenderer('module');
        $params = array('style' => $style);

        $contents = '';
        foreach (JModuleHelper::getModules($position) as $mod) {
            $contents .= $renderer->render($mod, $params);
        }
        return $contents;
    }

    // Word Limiter
    public static function wordLimit($str, $limit = 100, $end_char = '...')
    {
        if (trim($str) == '') {
            return $str;
        }
        $str = strip_tags($str);
        preg_match('/\s*(?:\S*\s*){'.(int)$limit.'}/', $str, $matches);
        if (strlen($matches[0]) == strlen($str)) {
            $end_char = '';
        }
        return rtrim($matches[0]).$end_char;
    }

    // Path overrides
    public static function getTemplatePath($pluginName, $file, $tmpl)
    {
        $app = JFactory::getApplication();
        $p = new JObject;
        $pluginGroup = 'content';

        $jTemplate = $app->getTemplate();

        if ($app->isAdmin()) {
            $db = JFactory::getDBO();
            if (version_compare(JVERSION, '1.6', 'ge')) {
                $query = "SELECT template FROM #__template_styles WHERE client_id = 0 AND home = 1";
            } else {
                $query = "SELECT template FROM #__templates_menu WHERE client_id = 0 AND menuid = 0";
            }
            $db->setQuery($query);
            $jTemplate = $db->loadResult();
        }

        if (file_exists(JPATH_SITE.DS.'templates'.DS.$jTemplate.DS.'html'.DS.$pluginName.DS.$tmpl.DS.str_replace('/', DS, $file))) {
            $p->file = JPATH_SITE.DS.'templates'.DS.$jTemplate.DS.'html'.DS.$pluginName.DS.$tmpl.DS.$file;
            $p->http = JURI::root(true)."/templates/".$jTemplate."/html/{$pluginName}/{$tmpl}/{$file}";
        } else {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                // Joomla 1.6+
                $p->file = JPATH_SITE.DS.'plugins'.DS.$pluginGroup.DS.$pluginName.DS.$pluginName.DS.'tmpl'.DS.$tmpl.DS.$file;
                $p->http = JURI::root(true)."/plugins/{$pluginGroup}/{$pluginName}/{$pluginName}/tmpl/{$tmpl}/{$file}";
            } else {
                // Joomla 1.5
                $p->file = JPATH_SITE.DS.'plugins'.DS.$pluginGroup.DS.$pluginName.DS.'tmpl'.DS.$tmpl.DS.$file;
                $p->http = JURI::root(true)."/plugins/{$pluginGroup}/{$pluginName}/tmpl/{$tmpl}/{$file}";
            }
        }
        return $p;
    }

    // Entity replacements
    public static function replaceHtml($text_to_parse)
    {
        $source_html = array("&", "\"", "'", "<", ">", "\r", "\t", "\n");
        $replacement_html = array("&amp;", "&quot;", "&#039;", "&lt;", "&gt;", "", "", "");
        return str_replace($source_html, $replacement_html, $text_to_parse);
    }

    // Replace white space
    public static function replaceWhiteSpace($text_to_parse)
    {
        $source_html = array(" ");
        $replacement_html = array("%20");
        return str_replace($source_html, $replacement_html, $text_to_parse);
    }

    // Cleanup thumbnail filenames
    public static function cleanThumbName($text_to_parse)
    {
        $source_html = array(' ', ',');
        $replacement_html = array('_', '_');
        return str_replace($source_html, $replacement_html, $text_to_parse);
    }

    // Read remote file
    public static function readFile($url, $pluginName)
    {
        jimport('joomla.filesystem.file');

        // Set the cache folder
        $cacheFolderPath = JPATH_SITE.DS.'cache'.DS.$pluginName;
        if (file_exists($cacheFolderPath) && is_dir($cacheFolderPath)) {
            // all OK
        } else {
            mkdir($cacheFolderPath);
        }

        // Get file
        if (substr($url, 0, 4) == "http") {
            // remote file
            if (ini_get('allow_url_fopen')) {

                // file_get_contents
                $result = JFile::read($url);
            } elseif (in_array('curl', get_loaded_extensions())) {

                // cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $chOutput = curl_exec($ch);
                curl_close($ch);
                $tmpFile = $cacheFolderPath.DS.'curl_tmp_'.substr(md5($url), 0, 10);
                JFile::write($tmpFile, $chOutput);
                $result = JFile::read($tmpFile);
            } else {

                // fsockopen
                $readURL = parse_url($url);
                $relativePath = (isset($readURL['query'])) ? $readURL['path']."?".$readURL['query'] : $readURL['path'];

                $fp = fsockopen($readURL['host'], 80, $errno, $errstr, 5);
                if (!$fp) {
                    $result = "";
                } else {
                    $out = "GET ".$relativePath." HTTP/1.1\r\n";
                    $out .= "Host: ".$readURL['host']."\r\n";
                    $out .= "Connection: Close\r\n\r\n";
                    fwrite($fp, $out);
                    $header = '';
                    $body = '';
                    do {
                        $header .= fgets($fp, 128);
                    } while (strpos($header, "\r\n\r\n")=== false);// get the header data
                    while (!feof($fp)) {
                        $body .= fgets($fp, 128);
                    }
                    // get the actual content
                    fclose($fp);
                    $tmpFile = $cacheFolderPath.DS.'fsockopen_tmp_'.substr(md5($url), 0, 10);
                    JFile::write($tmpFile, $body);
                    $result = JFile::read($tmpFile);
                }
            }
        } else {
            // local file
            $result = JFile::read($url);
        }

        return $result;
    }
} // End class
