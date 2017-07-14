# WPKit TGMPA Integration

This is a Wordpress PHP Component to handle TGMPA Configuration. 

TGMPA (TGM Plugin Activation) is a PHP library that allows you to easily require or recommend plugins for your WordPress themes (and plugins). Read more about it [here](http://tgmpluginactivation.com/).

This PHP Component was built to run within an Illuminate Container so is perfect for frameworks such as Themosis.

## Installation

If you're using Themosis, install via composer in the Themosis route folder, otherwise install in your theme folder:

```php
composer require "wp-kit/tgmpa-integration"
```

## Registering Service Provider

**Within Themosis Theme**

Just register the service provider in the providers config:

```php
//inside themosis-theme/resources/config/providers.config.php

return [
	//,
	WPKit\Integrations\Tgmpa\TgmpaServiceProvider::class,   
	//
];
```

**Within functions.php**

If you are just using this component standalone then add the following the functions.php

```php
// within functions.php

// make sure composer has been installed
if( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	
	wp_die('Composer has not been installed, try running composer', 'Dependancy Error');
	
}

// Use composer to load the autoloader.
require __DIR__ . '/vendor/autoload.php';

$container = new Illuminate\Container\Container(); // create new app container

$provider = new WPKit\Integrations\gmpa\TgmpaServiceProvider($container); // inject into service provider

$provider->register(); //register service provider
```


## Config

Now just add the configuration file in your config directory:

```php
// In theme/resources/config/vc.config.php

return [

    /*
    |--------------------------------------------------------------------------
    | TGMPA Plguins
    |--------------------------------------------------------------------------
    |
    | Tell the Service Provider which plugins to register
    |
    */

    'plugins' => [
	    
	    
	    // This is an example of how to include a plugin bundled with a theme.
		[
			'name'               => 'TGM Example Plugin', // The plugin name.
			'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		],

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		[
			'name'      => 'BuddyPress',
			'slug'      => 'buddypress',
			'required'  => false,
		],
	    
	    
    ],

    /*
    |--------------------------------------------------------------------------
    | TGMPA Plugins Path
    |--------------------------------------------------------------------------
    |
    | Tell the Server Provider where to find Plugins to load
    | plugins from. By default the below function loads from:
    |
    | ~/theme/resources/plugins/
    |
    */

    'plugins_path' => resources_path('plugins')

];

```

## Requirements

Wordpress 4+

Visual Composer 4+

PHP 5.6+

## License

WPKit VC Integration is open-sourced software licensed under the MIT License.