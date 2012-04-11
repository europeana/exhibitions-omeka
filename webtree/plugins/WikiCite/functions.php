<?php
/**
 * @copyright Copyright (c) 2011 Jeremy Boggs
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL3
 * @package WikiCiteOmeka
 * @version 1.0
 * @since 1.0
 */

/**
 * Generates Wikipedia citation code for an Omeka Item.
 *
 * @todo Add more citation parameters if available in item.
 * @since 1.0
 * @param boolean $textarea Whether to wrap the cite_web code in a textarea (true by default).
 * @param Item|null $item Check for this specific item record (current item if null).
 * @return string
 */
function wikicite_for_item($textarea = true, $item = null)
{
    if (!$item) {
        $item = get_current_item();
    }

    $html = wikicite_string(array(
                'url' => html_escape(abs_item_uri($item)),
                'title' => item('Dublin Core', 'Title', array(), $item)
                ), $textarea);

    echo $html;
}

/**
 * Generates Wikipedia citation code for an Omeka Collection.
 *
 * @todo Add more citation parameters if available in collection.
 * @since 1.0
 * @param boolean $textarea Whether to wrap the cite_web code in a textarea (true by default).
 * @param Collection|null $collection Check for this specific collection record (current collection if null).
 * @return string
 */
function wikicite_for_collection($textarea = true, $collection = null)
{
    if (!$collection) {
        $collection = get_current_collection();
    }

    $html = wikicite_string(array(
                'url' => html_escape(abs_uri(array('controller'=>'collections', 'action'=>'show', 'id'=>$collection->id), 'id')),
                'title' => collection('Name', array(), $collection)
                ), $textarea);

    echo $html;
}

/**
 * Generates Wikipedia citation string
 *
 * @since 1.0
 * @param array $props The properties to use in the citation
 * @param boolean $textarea Whether to wrap the cite_web code in a textarea (true by default).
 * @return string
 */
function wikicite_string($props = array(), $textarea = true)
{
    $html = '';

    if ($props) {
        $html = '{{cite web'
              . ' |url='.$props['url']
              . ' |title='.$props['title']
              . ' |work='.settings('site_title')
              . ' |accessdate='.date('d F Y')
              . '}}';
        if ($textarea) {
            $html = '<textarea rows="3" style="width:100%;" id="wikcite-code">'.$html.'</textarea>';
        }
    }

    return $html;
}