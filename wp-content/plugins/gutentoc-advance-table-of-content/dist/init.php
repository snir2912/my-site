<?php
/**
 * Blocks Initializer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 */
function gutentocwp_cgb_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'gutentocwp-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'gutentocwp-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'gutentocwp-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'gutentocwp-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);
	

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-gutentocwp', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'gutentocwp-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'gutentocwp-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'gutentocwp-cgb-block-editor-css',
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'gutentocwp_cgb_block_assets' );

//  --------------------------

// -------------------------
 

/**
 * Admin menu.
 */

add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');
function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page(
        'options-general.php',
        'GutenTOC',
        'GutenTOC',
        'manage_options',
        'gutentoc',
        'gutentoc_admin_menu' );
}
function gutentoc_admin_menu() {
   ?>
   <div class='gutentoc__wrap'><div class="admin-title">
       <div class="wellcome_title">
           <h1>GutenTOC user Guide</h1>
           <div class="wellcome_btn">
               <ul>
                   <!-- <li class="demo"><a target="_blank" href="http://tauhidpro.com/gutentoc/#wp">Demos</a></li> -->
               </ul>
           </div>
       </div>

       <h2>How to Create Table of Content ?</h2>
       <p><strong>Go to  Gutenberg post or page editor -> Add Block -> find it under "Common blocks" category.</strong></p>
       <img src="http://tauhidpro.com/plugins/toc/toc-how.png" alt="">
   </div>
       
   </div>
<?php
}

 