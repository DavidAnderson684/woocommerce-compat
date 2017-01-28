<?php

if (!defined('ABSPATH')) die('No direct access.');

/*

WooCommerce compatibility library, version 1.0

Get full/current info at:
https://github.com/DavidAnderson684/woocommerce-compat/

Copyright David Anderson 2017-
Licenced according to the MIT Licence; see the file LICENCE

*/

if (!class_exists('WooCommerce_Compat_1_0')):
class WooCommerce_Compat_1_0 {

	/**
	 * Get the ID of a passed object. This function abstracts the difference between objects with the get_id() method from WC 2.7 onwards, and before when the property was accessed directly.
	 *
	 * @param object $object Any WooCommerce object that has an ID (available via either a get_id() method or an id property)
	 */
	public function get_id($object) {
		return method_exists($object, 'get_id') ? $object->get_id() : $object->id;
	}
	
	/** 
	 * Get the price including tax of a product. This function abstracts the difference between WC_Product::get_price_including_tax (before WC 2.7) and wc_get_price_including_tax (2.7+).
	 * 
	 * @param WC_Product $product - a product
	 * @param array $args - arguments. Valid keys for WC < 2.7 are 'qty' and 'price'. Others will be ignored on these versions.
	 */
	public function get_price_including_tax($product, $args = array()) {
		if (function_exists('wc_get_price_including_tax')) return wc_get_price_including_tax($product, $args);
		
		// Enforce the pre-WC-2.7 defaults
		$qty = isset($args['qty']) ? $args['qty'] : 1;
		$price = isset($args['price']) ? $args['price'] : '';
		
		return $product->get_price_including_tax($qty, $price);
	}
	
	/** 
	 * Get the price excluding tax of a product. This function abstracts the difference between WC_Product::get_price_excluding_tax (before WC 2.7) and wc_get_price_excluding_tax (2.7+).
	 * 
	 * @param WC_Product $product - a product
	 * @param array $args - arguments. Valid keys for WC < 2.7 are 'qty' and 'price'. Others will be ignored on these versions.
	 */
	public function get_price_excluding_tax($product, $args = array()) {
		if (function_exists('wc_get_price_excluding_tax')) return wc_get_price_excluding_tax($product, $args);
		
		// Enforce the pre-WC-2.7 defaults
		$qty = isset($args['qty']) ? $args['qty'] : 1;
		$price = isset($args['price']) ? $args['price'] : '';
		
		return $product->get_price_excluding_tax($qty, $price);
	}

}
endif;
