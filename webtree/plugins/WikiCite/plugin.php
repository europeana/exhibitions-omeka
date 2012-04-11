<?php
/**
 * @copyright Copyright (c) 2011 Jeremy Boggs
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL3
 * @package WikiCiteOmeka
 * @version 1.0
 * @since 1.0
 */
 
/*
Based on Cite_web template at http://en.wikipedia.org/wiki/Template:Cite_web,
and inspired by Seb Chan implementation for Powerhouse Museum at
http://www.powerhousemuseum.com/dmsblog/index.php/2011/01/20/quick-wikipedia-citation-code-added-to-collection/

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once 'functions.php';

add_plugin_hook('public_append_to_items_show', 'wikicite_for_item');
add_plugin_hook('public_append_to_collections_show', 'wikicite_for_collection');