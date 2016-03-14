<?php
/**
 * StudioPress CLI
 *
 * @package     StudioPressCLI
 * @author      Nick Cernis
 * @copyright   2016 Nick Cernis
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: StudioPress CLI
 * Description: Install StudioPress themes with WP CLI. Requires an active My StudioPress account.
 * Version:     0.1.0
 * Author:      Nick Cernis
 * Author URI:  https://modernnerd.net
 * Text Domain: studiopress-cli
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {

	class StudioPress_Theme_CLI extends WP_CLI_Command {


		/**
		 * The list of all available StudioPress theme download IDs.
		 *
		 * The logged-in account must have purchased the theme to be able to download it.
		 *
		 * List compiled from StudioPress downloads page: http://my.studiopress.com/downloads/
		 * This does not currently include “archived” themes.
		 *
		 * @var array
		 */
		public $available_themes = array(
			'genesis'              => 's91046d629e74d525b3f2978e404e7ffa',
			'genesis-sample'       => 'a3f794f7db3498333cbaf7094b3828d2',
			'adorable'             => 'c8594817d092f1cc5a8739c44f4fc8f4',
			'agency-pro'           => '35603bbf8bce70078c1796ce6a0b4603',
			'agentpress-pro'       => '2a2c3259913fb9c007592b2c060bdab5',
			'altitude-pro'         => '175b1dafa878111d0c6e171681c9950b',
			'ambiance-pro'         => '0d81e8f674361fdfe1cfed16fb0f380b',
			'apparition'           => 'a8c7329ce570a10bb8f59a25aa6b1227',
			'aspire-pro'           => '47b40e4c59957e008769156232b9a053',
			'associate'            => '684fd34460884910862cd4cd3f430e38',
			'atmosphere-pro'       => '02cec9aecee9241a1c30b59c4a57a2a0',
			'author-pro'           => 'ef6c4ccafa119f1d04f99446844d0692',
			'backcountry'          => '072a47335d3c3541a641535d2bf765ac',
			'balance'              => 'a20dc3675efcfef7c7f7cbe36ddba433',
			'beautiful-pro'        => '8ab2d075cd22b701fa199d28d9bdbf00',
			'beecrafty'            => '13e01b934a74e8a8375cacfa18550f02',
			'blingless'            => '906e26e9a817abdee7dc775328dbf17d',
			'blissful'             => 'b2b8c6da3d54ba1f3bd2727f2c37f142',
			'brunch-pro'           => 'aeaffa9116f49abcf5206b6c076f6df7',
			'cafe-pro'             => 'a8a6ee61eb36ad8504b08f58e8f868c5',
			'centric-pro'          => '4c2a62d9372cf37cb04d00bfe8067bd9',
			'clipcart'             => '5a38b6a7f7ad263a206395a5cba94c76',
			'community-pro'        => '894e36b7e309ec045f04e17a0af788b6',
			'corporate'            => 'd7d383aae77cf4d8b909372fd3dd9487',
			'craftiness'           => '2a8f738b3e0f8806a64546290cd360b1',
			'crave'                => '9bcee7ae383e21ddabd503def900a656',
			'cre8tive'             => 'cd6408062c9bea9bff08f97af8160595',
			'crystal'              => '6ac1ab4ed0f9f524ffb20b68ca60fbe6',
			'curtail'              => '5e8ab2cc718c6eea3b17e665aa7828aa',
			'daily-dish-pro'       => '357473c009aea44c8277c2f2fd3f134d',
			'darling'              => '47f2bc2c8f1d2c9e1f9535a80a8d04f8',
			'dear'                 => '85ff20d97f3a24be9d494a3c5ad51104',
			'decor'                => '50266c72e127dfa5a95a64a9875e103e',
			'decor8ted'            => '50266c72e127dfa5a95a64a9875e103e',
			'delicious'            => 'e1ff9d42891f13445bcd286e2c0c8712',
			'divine'               => 'e0028177e6135c4496dde27c360fff6a',
			'driskill'             => '7f6ca782c1fbb358defa6b6c970f1abd',
			'education-pro'        => 'cad21ed35a2347715ffff7c5c0f33b99',
			'eleven40-pro'         => 'a34711ae7cc23475fd3515b4b75c1453',
			'elle'                 => '106568c651e275654e5e11005bd1508f',
			'enterprise-pro'       => '898bde22dc67491572488e630e64ac16',
			'epik'                 => 'b3759628a77db14b06e25bafdd59f72e',
			'executive-pro'        => '3b5686b6a40865dc67e7a1ea3ea72d83',
			'expose-pro'           => '14e370c69ce8090553060952e8e59892',
			'fabric'               => 'a9d45135627f1c20d56600e3ed1aaff5',
			'familytree'           => 'c19462cc9a271ee73808f19452d03dd8',
			'fashionista'          => '5bcd238b55d9d82f2d0f1b1380649c87',
			'focus-pro'            => '477013df5fab41d8145d28935cbb8b67',
			'freelance'            => 'af03d543d4e6f7a9c878becff5ebe00e',
			'fun'                  => '394608bb4ad459815c628640be203e9f',
			'generate-pro'         => 'e6ec68ed49e68def52651ac3ea99dbd6',
			'glam-pro'             => 'ca7d2680aa622c901904dd146428e42f',
			'glitter'              => 'b7d51b2b3c6758eb6a4eb4eb9c7b92cb',
			'going-green-pro'      => 'df9b79a1a881e123ab82bec05dbfbc8f',
			'innov8tive'           => '8033ff70d355d5e52b64f38c0da630a4',
			'inspired'             => '2a91bd7fa9f4fbae3e669b052ff929f4',
			'inspyr'               => '2f7efa2896d4d00387a62397abcad4d1',
			'jane'                 => '433a490987ed5c6ab0bf33d540ffd4bd',
			'jessica'              => '9fdda7b5b54e96644a5acfd9b3050782',
			'kickstart-pro'        => '670bb7caf49beb3ab8f6972b09a3b403',
			'landscape'            => '5f8ad1d6276c8437d32f37e2777a949c',
			'legacy'               => '62e3263c7ecd6dc41732c2dda12843c8',
			'lexicon'              => '4ef1ef75d2452ca766515fc20a6c90dc',
			'lifestyle-pro'        => 'e7e374e17d04c2e9901b0e0b41772a24',
			'luscious'             => '1af22fda79243c25cf76b36629e93cc9',
			'magazine-pro'         => 'a8fc4b94da8e7d06daa8593a8d7104da',
			'manhattan'            => 'db7f89b8c630f8655fb8d4c13b6107d7',
			'maximum'              => 'cd250799f3a6a967a1d734c15c7fbb82',
			'megalithe'            => 'baa4ae9e1fd5b1ec66515f134abd2484',
			'metric'               => '7a44532f2e7d50387212fa6b21f3bd64',
			'metro-pro'            => '380df416fac3ea26a5b02736f9f8353e',
			'midnight'             => '208564c7e45b426a663b130de29f99d5',
			'mindstream'           => '36ffa1eb0e2675a31ad841c32d0322dd',
			'minimum-pro'          => 'af6cc4126d869a1181c2288c5e71d7d5',
			'mocha'                => '3b20588d8f20b30e3a686ed9cf8b3213',
			'modern-blogger-pro'   => '45db5819af1a3094055f1ace83c925b2',
			'modern-portfolio-pro' => '8756bd5a47134685e7f6dda0c6034838',
			'modern-studio-pro'    => '25cae32b1d915fbbd4ebeb711e433167',
			'mompreneur'           => '5dbb9a97de5534b18c0ca9c1ef259d55',
			'news-pro'             => 'f5251a2e95eedac4e94f9767732a66a3',
			'nitrous'              => '2ae4df44628546718dbbe442fecfb3ce',
			'no-sidebar-pro'       => 'd74b596d102abe13924dd5a680659d2f',
			'optimal'              => 'b0b3e3963eb923244df2c3a9d1d46e7b',
			'outreach-pro'         => '359f086caf8877a860dda5e9615df35c',
			'parallax-pro'         => 'a9a420567412660f1524f4edff5cdaa0',
			'pixelhappy'           => '45113b7ccf8fda33732d9dfd6fc51cdf',
			'platinum'             => '6352716235efb0f6e8a1dd9b0f92fc84',
			'politica'             => 'dfb4b6bc836e35bb363a332a9222a49c',
			'pretty-chic'          => '266caf89277bd2b77ad6a6006dfa75af',
			'pretty-creative'      => '76ba8971fde0a2cf6955526c00754546',
			'pretty-pictures'      => '564e274e142abd045ca0f0d43c2e0694',
			'pretty'               => 'dee13cba0b250e771ebe9c4ce39854fd',
			'production'           => 'a25ac9316811617c78aa240fa0bc93ad',
			'prose'                => 'd95b8757c750ddbc862654109abbda59',
			'pureelegance'         => 'b48faa22a4550f2f332997657b14817b',
			'quattro'              => 'abb0c50bc59576764da354e785e7ef52',
			'realpro'              => '811cb65a0e3e1385999184fb394f4049',
			'remobile-pro'         => '7e6629e5eb6ca1cef2ac43ff5592d07b',
			'runwaypro'            => '6d0f0f169ce7d720e182cc8c7085e5c7',
			'scribble'             => 'da6439ed9318b2b4a4f0a8e8e34ea256',
			'showcase-pro'         => 'c95a1bc47fb021eaa6eceb7bc54beb77',
			'simply'               => '4707013227740e5fe39422d1398e8f73',
			'sixteen-nine-pro'     => 'd7d24603c2014531cf4641c497867a23',
			'sleek'                => '3ff4a543c15fe39aeaf9e6f328dbe58f',
			'socialeyes'           => '141ad77128898657cc0553676d4f3234',
			'startup'              => '93c9518831356fdb11702da24684ec02',
			'streamline-pro'       => 'b6bd3f863f5ff6a3fb96ce0498aa149b',
			'stretch'              => 'b7f16106b84fbc13c369151bedeb1eb3',
			'swank'                => '8d63e41c30ab635c4d2255dc24300dac',
			'tapestry'             => '7986eb97b94a29d67df93de5c860a936',
			'the-411-pro'          => '12682bb953911913599b6971c56dc04f',
			'venture'              => '227451c7849a50c9559e2772a4dc818b',
			'vintage'              => 'c8e769ed8c989eb9469120cf8130decd',
			'whitespace-pro'       => '585a7681d982e2abcbffa70d62027913',
			'winning-agent'        => 'b788702045391223252aa536aa420a44',
			'wintersong-pro'       => 'df5c8e9f37ca1a7634b8903826299730',
			'workstation-pro'      => '171c5af06e7b6c48296d06343cc12a3f',
		);

		/**
		 * Path to WP upload directory for storing theme zips and login cookie
		 * @var string
		 */
		public $upload_path;

		/**
		 * StudioPress_Theme_CLI constructor.
		 */
		public function __construct() {
			$upload_dir        = wp_upload_dir();
			$this->upload_path = $upload_dir['path'] . '/';
		}

		/**
		 * List all StudioPress themes available to download.
		 *
		 * (You can only download themes you have paid for.)
		 *
		 * ## EXAMPLES
		 *
		 *     wp sp-theme list
		 *
		 * @subcommand list
		 */
		function _list( $args, $assoc_args ) {

			$theme_names = array_keys( $this->available_themes );

			WP_CLI::print_value( implode( "\n", $theme_names ) );

		}

		/**
		 * Download and install a named StudioPress theme.
		 *
		 * ## OPTIONS
		 *
		 * <theme-name>
		 * : The name of the theme to download.
		 *
		 * ## EXAMPLES
		 *
		 *     wp sp-theme install genesis --spuser=test@example.com --sppass=password
		 *     wp sp-theme install genesis-sample --spuser=test@example.com --sppass=password --activate
		 *
		 * @synopsis <theme-name> --spuser=<username> --sppass=<password> [--activate]
		 */
		function install( $args, $assoc_args ) {

			$download_url = false;
			$theme_name   = $args[0];

			if ( array_key_exists( $theme_name, $this->available_themes ) ) {
				$download_url = $this->available_themes[ $theme_name ];
			}

			if ( ! $download_url ) {
				WP_CLI::error( 'Theme name not recognised. Use "wp sp-theme list" for a list of available themes.' );
			}

			if ( ! function_exists( 'curl_version' ) ) {
				WP_CLI::error( 'Your version of PHP is missing the CURL module, which "sp-theme install" currently requires.' );
			}

			WP_CLI::log( 'Logging in...' );

			$logged_in = $this->studiopress_login( array(
				'log' => $assoc_args['spuser'],
				'pwd' => $assoc_args['sppass']
			) );

			if ( ! $logged_in ) {
				WP_CLI::error( 'Login failed. You can reset your password at https://my.studiopress.com/wp-login.php?action=lostpassword.' );
			}

			WP_CLI::log( "Downloading $theme_name..." );

			$this->studiopress_download_theme( $theme_name );

			unlink( $this->upload_path . "sp-cookie.txt" );

			WP_CLI::log( "Installing theme..." );

			$install_args = array( 'theme', 'install', $this->upload_path . "/$theme_name.zip" );
			$extra_args   = array_key_exists( 'activate', $assoc_args ) ? array( 'activate' => true ) : array();

			WP_CLI::run_command( $install_args, $extra_args );

			unlink( $this->upload_path . "$theme_name.zip" );

		}

		/**
		 * Log in and store the authentication cookie
		 *
		 * @param $auth_data
		 *
		 * @return bool
		 */
		private function studiopress_login( $auth_data ) {

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, 'https://my.studiopress.com/wp-login.php' );
			curl_setopt( $ch, CURLOPT_NOBODY, true );
			curl_setopt( $ch, CURLOPT_COOKIEJAR, $this->upload_path . 'sp-cookie.txt' );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $auth_data );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$output = curl_exec( $ch );
			curl_close( $ch );

			// Check that login was successful
			$cookie_contents = file_get_contents( $this->upload_path . 'sp-cookie.txt' );
			if ( strpos( $cookie_contents, 'wordpress_logged_in' ) ) {
				return true;
			} else {
				return false;
			}

		}

		/**
		 * Download a StudioPress theme
		 *
		 * @param $theme_name
		 *
		 * @return bool
		 */
		private function studiopress_download_theme( $theme_name ) {

			$download_url = 'http://my.studiopress.com/?download_id=' . $this->available_themes[ $theme_name ];

			$ch   = curl_init();
			$file = fopen( $this->upload_path . "/$theme_name.zip", 'w+' );
			curl_setopt( $ch, CURLOPT_URL, $download_url );
			curl_setopt( $ch, CURLOPT_COOKIEFILE, $this->upload_path . 'sp-cookie.txt' );
			curl_setopt( $ch, CURLOPT_FILE, $file );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
			$output = curl_exec( $ch );
			curl_close( $ch );

			// TODO: only return true if theme zip file is not empty
			return true;

		}

	}

	WP_CLI::add_command( 'sp-theme', 'StudioPress_Theme_CLI' );
}
