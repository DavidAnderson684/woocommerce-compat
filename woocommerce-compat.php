<?php

if (!defined('ABSPATH')) die('No direct access.');

/*

WooCommerce compatibility library, version 0.3.0

Get full/current info at:
https://github.com/DavidAnderson684/woocommerce-compat/

Copyright David Anderson 2017-
Licenced according to the MIT Licence; see the file LICENCE

*/

if (!class_exists('WooCommerce_Compat_0_3')):
class WooCommerce_Compat_0_3 {

	/**
	 * Get the ID of a passed object. This function abstracts the difference between objects with the get_id() method from WC 2.7 onwards, and before when the property was accessed directly.
	 *
	 * @param object $object Any WooCommerce object that has an ID (available via either a get_id() method or an id property)
	 */
	public function get_id($object) {
		return is_callable(array($object, 'get_id')) ? $object->get_id() : $object->id;
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
	
	/**
	 * Update meta data by key or ID, if provided.
	 * 
	 * This function can be called on any WC_Data object (e.g. a WC_Product, WC_Order). It is intended to replace calls to update_post_meta(). It does not support the fourth parameter ($meta_id) of WC_Data::update_meta_data, as there is no legacy equivalent.
	 * 
	 * Currently, only WC_Order objects are supported on WC < 2.7.
	 * 
	 * @param string $object
	 * @param string $key
	 * @param string $value
	 * 
	 * @return void 
	 */
	public function update_meta_data($object, $key, $value) {
		if (is_callable($object, 'update_meta_data')) {
			$meta_id = '';
			$object->update_meta_data($key, $value, $meta_id);
			$object->save();
		}
		if (is_a($object, 'WC_Order')) {
			update_post_meta($this->get_id($object), $key, $value);
		} else {
			throw new Exception('woocommerce-compat: unknown object type: '.gettype($object));
		}
	}
	
	/**
	 * Get meta data by key
	 * 
	 * Currently, only WC_Order objects are supported on WC < 2.7.
	 * 
	 * @since  0.2.0
	 * @param  string $object
	 * @param  string $key
	 * @param  bool $single return first found meta with key, or all with $key
	 * @param  string $context What the value is for. Valid values are view and edit. This is only used on WC 2.7+, and (in the current code) causes WC to run a filter on what is fetched.
	 * @return mixed
	 */
	public function get_meta($object, $key = '', $single = true, $context = 'view') {
		if (is_callable(array($object, 'get_meta'))) {
			return $object->get_meta($key, $single, $context);
		}
		return get_post_meta($this->get_id($object), $key, $single);
	}
	
	/**
	 * Get the order date
	 *
	 * @since 0.3.0
	 *
	 * @param WC_Order $order - the order object
	 *
	 * @return Integer - the date timestamp (epoch time)
	 */
	public function get_order_date($order) {
	
		if (version_compare(WC_VERSION, '2.7', '<')) return strtotime($order->completed_date);
	
		$try_these = array('completed', 'paid', 'created');
	
		$the_date = $order->get_date_completed();
		if (null == $the_date) $the_date = $order->get_date_paid();
		if (null == $the_date && is_callable(array($order, 'get_date_created'))) $the_date = $order->get_date_created();

		if (is_object($the_date) && is_callable(array($the_date, 'getTimestamp'))) $the_date = $the_date->getTimestamp();

		if (is_object($the_date)) $the_date = 0;
		
		return $the_date;
	
	}

}
endif;
