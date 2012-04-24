<?php

		function ve_translate($label, $default)
		{
		    $lang = isset($_COOKIE['ve_lang']) ? $_COOKIE['ve_lang'] : 'en';
		    $xml = simplexml_load_file(WEB_ROOT . '/themes/main/translations.xml');
		    $translation = $xml->{strtolower(trim($label))}->$lang;
		    if (trim($translation) != '') {
		        return $translation;
		    }
		    else {
		        return $default;
		    }
		}

