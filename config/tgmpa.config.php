<?php
	
	// In theme/resources/config/tgmpa.config.php

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