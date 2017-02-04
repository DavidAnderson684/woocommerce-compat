# woocommerce-compat

A library to provide some help with abstracting away differences between WooCommerce versions.

WooCommerce changes its internals quite a lot. Most extension authors like their extensions to run across a range of versions. This library is code that I wrote to help with abstracting away some of the differences with my extensions (https://www.simbahosting.co.uk/s3/shop/).  

It is not my personal aim to create a comprehensive library. If you wish it to contain something that it does not, then please consider contributing a pull request. I am happy to accept pull requests, but will not be coding compatibility methods that I have no personal use for. As such, you should expect this library to be incomplete, by design. It is being shared because it may be useful to someone; and perhaps people will contribute and increase its usefulness.

## Requirements:

- A PHP version supported by WordPress (see: https://wordpress.org/about/requirements/ - N.B. don't confuse supported versions with recommended versions).

## Use

- Add davidanderson684/woocommerce-compat to your requirements in composer.json, and then run a "composer update". Or, just `require_once('woocommerce-compat.php');`

- To see the currently available public methods, read the code!

## Upgrading between versions

- Any API-breaking changes will be accompanied by a bump in the class name, which includes the version number. Addition of new functionality will also result in a bump. We will try to stick to semantic versioning (http://semver.org).

## Etcetera

- Author homepage: https://david.dw-perspective.org.uk

- Donations: https://david.dw-perspective.org.uk/donate

