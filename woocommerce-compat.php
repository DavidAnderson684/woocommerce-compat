<?php

if (!defined('ABSPATH')) die('No direct access.');

/*

WooCommerce compatibility library, version 1.0

Get full/current info at:
https://github.com/DavidAnderson684/woocommerce-compat/

Copyright David Anderson 2017-
Licenced according to the MIT Licence; see the file LICENCE

*/

class WooCommerce_Compat_1_0 {

	/**
	 * Get the ID of a passed object
	 *
	 * @param object $object Any WooCommerce object that has an ID (available via either a get_id() method or an id property)
	 */
	public function get_id($object) {
		return method_exists($object, 'get_id') ? $object->get_id() : $object->id;
	}

}
