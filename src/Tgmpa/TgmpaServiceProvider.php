<?php
	
	namespace WPKit\Integrations\Tgmpa;
	
	use WPKit\Integrations\Integration;
	
	class TgmpaServiceProvider extends Integration {
		
		/**
	     * Boot the service provider.
	     *
	     * @return void
	     */
		public function boot() {
		
			$this->publishes([
				__DIR__.'/../../config/tgmpa.config.php' => config_path('tgmpa.config.php')
			], 'config');

		}
		
		/**
	     * Start the integration
	     *
	     * @return void
	     */
		public function startIntegration() {
			
			if( defined( 'WP_CLI' ) && WP_CLI ) {
				
				return false;
				
			}
			
			if( ! isset( $GLOBALS['tgmpa'] ) ) {
			
				if ( did_action( 'plugins_loaded' ) ) {
					load_tgm_plugin_activation();
				} else {
					add_action( 'plugins_loaded', 'load_tgm_plugin_activation' );
				}
				
			}
			
			$this->settings = $this->app['config.factory']->get('tgmpa', [
				'plugins' => [],
				'plugins_path' => resources_path('plugins')
			]);
			
			if( empty( $this->settings['plugins'] ) ) {
				return;
			}
			
			add_action( 'tgmpa_register', function() {
    				
				$plugins = array_map(function($plugin) {
    				
    				return array_merge(array(
        				'name'			=> '', // The plugin name
                        'slug'			=> '', // The plugin slug (typically the folder name)
                        'source'			=> '', // The plugin source
                        'required'			=> true, // If false, the plugin is only 'recommended' instead of required
                        'version'			=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                        'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'		=> '', // If set, overrides default API URL and points to an external URL
    				), $plugin);
    				
				}, $this->settings['plugins']);
				
				foreach( $plugins as &$plugin ) {
					
					if( ! empty( $plugin['source'] ) && ! file_exists( $plugin['source'] ) && ( $source = $this->settings['plugins_path'] . DS . $plugin['source']  ) ) {
					
    					$plugin['source'] = $source;
    					
                    }
					
				}
			
				tgmpa( $plugins, 
					array(
				        'domain'		=> 'wpkit', // Text domain - likely want to be the same as your theme.
				        'menu'			=> 'install-required-plugins', // Menu slug
				        'has_notices'		=> true, // Show admin notices or not
				        'is_automatic'		=> false, // Automatically activate plugins after installation or not
				        'message'		=> '', // Message to output right before the plugins table
				        'strings'		=> array(
				            'page_title'			=> __( 'Install Required Plugins', 'wpkit' ),
				            'menu_title'			=> __( 'Install Plugins', 'wpkit' ),
				            'installing'			=> __( 'Installing Plugin: %s', 'wpkit' ), // %1$s = plugin name
				            'oops'				=> __( 'Something went wrong with the plugin API.', 'wpkit' ),
				            'notice_can_install_required'	=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
				            'notice_can_install_recommended'	=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
				            'notice_cannot_install'		=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
				            'notice_can_activate_required'	=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				            'notice_can_activate_recommended'	=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				            'notice_cannot_activate'		=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
				            'notice_ask_to_update'		=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
				            'notice_cannot_update'		=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
				            'install_link'			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				            'activate_link'			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				            'return'				=> __( 'Return to Required Plugins Installer', 'wpkit' ),
				            'plugin_activated'			=> __( 'Plugin activated successfully.', 'wpkit' ),
				            'complete'				=> __( 'All plugins installed and activated successfully. %s', 'wpkit' ), // %1$s = dashboard link
				            'nag_type'				=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
				        )
				    ) 
				);
			    
			});
			
		}
		
	}
