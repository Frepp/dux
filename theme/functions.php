<?php
/**
 * Theme related functions. 
 *
 */
 
/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @return string/null wether the favicon is defined or not.
 */

function get_title($title) {
  global $dux;
  return $title . (isset($dux['title_append']) ? $dux['title_append'] : null);
}

/** 
* Set up a dynamic navigationbar
*
* Array $items and the @class variable are defined in the config file
*/

function get_navbar($menu) {
  $html = "<nav class='{$menu['class']}'>\n";
  foreach($menu['items'] as $item) {
    $selected = $menu['callback_selected']($item['url']) ? " class='selected' " : null;
    $html .= "<a {$selected} href='{$item['url']}' title='{$item['title']}'>{$item['text']}</a>\n";
  }
  $html .= "</nav>\n";
  return $html;
}