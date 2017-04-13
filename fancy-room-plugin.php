<?php
/*
Plugin Name: Fancy Room Plugin
Plugin URI: http://izgool.com/
Description: Allow your visitors to convert website into fancy website .It contains only generic background.
Version: 1.0
Author: Fred Yalmeh 
Author URI: http://izgool.com/
License: GPL2
*/

//fancy Plugin Actions hooks

//Plugin Activation hook
register_activation_hook(__FILE__, 'fancy_room_plugin_install');

//Plugin Deactivation hook
register_deactivation_hook( __FILE__, 'fancy_room_plugin_uninstall' );

add_action('admin_menu', 'fancy_admin_menu' );		// For admin Menu option


add_shortcode("FANCY_ROOM","show_fancy_icons");

add_filter('upload_mimes', 'cwifw_custom_upload_mimes');

add_action( 'init', 'change_theme_frontpage' );

function change_theme_frontpage() {
	
	$frontpage = get_page_by_title('Fancy Room');   // 2 is the id of the page you want to show
	
	if(get_option('landing_page') == 'yes') {
		update_option('show_on_front', 'page');    // show on front a static page
		update_option('page_on_front', $frontpage->ID);
	
	} else {
		update_option('show_on_front', 'posts');
	}
}


//Function for plugin menu
function fancy_room_plugin_install() {
	
	
	global $current_user;
	
	$frontpage = get_page_by_title('Fancy Room');
	
	if($frontpage != NULL) {
		wp_delete_post( $frontpage->ID, true );
	
	}

	$my_post = array(
	  'post_title'    => 'Fancy Room',
	  'post_content'  => '[FANCY_ROOM]',
	  'post_status'   => 'publish',
	  'post_author'   => $current_user->ID,
	  'post_type'     => 'page'
	);
	
	// Insert the post into the database
	wp_insert_post( $my_post );




}
function fancy_room_plugin_uninstall() {

	$frontpage = get_page_by_title('Fancy Room');
	
	wp_delete_post( $frontpage->ID, true );

}

function fancy_admin_menu() {

	add_menu_page( 'fancy plugin', 'Fancy Room plugin',"administrator", 'fancywebsite','fancy_room_dashboard' );
	
	add_submenu_page( 'fancywebsite', 'Fancy Icons', 'Fancy image and landing page setting', 'manage_options', 'update-image-setting', 'fancy_image_setting' );

	add_submenu_page( 'fancywebsite', 'Fancy Icons', 'Fancy Icon and Text Hover Settings', 'manage_options', 'update-social-icons', 'fancy_icon_setting' );
	
	add_submenu_page( 'fancywebsite', 'Fancy Icons', 'Fancy Image background color', 'manage_options', 'update-background-color', 'fancy_image_background_color_setting' );
	
	add_submenu_page( 'fancywebsite', 'Fancy Icons', 'Fancy Audio setting', 'manage_options', 'fancy_icon_audio_setting', 'fancy_audio_icon_setting' );
	
	add_submenu_page( 'fancywebsite', 'Fancy Icons', 'Fancy Video URL setting', 'manage_options', 'fancy_icon_video_setting', 'fancy_video_icon_setting' );

}
function fancy_room_dashboard() {
?>
	<h1>Convert Website Into Fancy Room Website</h1>
	<p>This plugin creates a page called fancy room and set that page as landing page</p>
	<p>You can manage Manage Fancy Icons from sub-menu of fancy room plugin .</p>

<?php

}
function fancy_image_setting() {
?>
	<style>
		#fancy_table{}
		#fancy_table tr {}
		#fancy_table tr td { padding:20px; text-align: left;}
		#fancy_table tr th {}
		#fancy_table tr td input {margin:0px 20px;}
	</style>
    <div class="wrap">

		<form method="post" action="options.php"> 

		<?php wp_nonce_field('update-options'); ?>

		<!--<fieldset>-->
		<table id="fancy_table">
		<tr>
			<td>
				Set As Landing Page : <input type="checkbox" value="yes" name="landing_page" <?php echo get_option('landing_page')=='yes'?'checked':''; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Select Background Image:
				<?php 
				$background_image_array 	=   array('--','Fancy Room');
				
				$background_image			=	get_option('fancy_image');
				
				?>
				<select name="fancy_image" style="width:320px;">
					<?php
						foreach($background_image_array as $background_image_item) {
							if(	$background_image_item	==	$background_image) {
								echo '<option value="'.$background_image_item.'" selected="selected">'.ucfirst ($background_image_item).'</option>';
							} else if($annotation_series_item == "--") {
								echo '<option value="" disabled="disabled">'.$background_image_item.'</option>';
							} else {
								echo '<option value="'.$background_image_item.'">'.ucfirst ($background_image_item).'</option>';
							}
						}
					?>
			   </select>
				
			</td>
		</tr>
		</tr>
			<td>
				<p class="submit">

					<input type="hidden" name="action" value="update" />

					<input type="hidden" name="page_options" value="fancy_image,landing_page" />
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

				</p>
			</td>
		</tr>
		 </table>
		</form>
     
	</div>
<?php
}
//Function for fancy Icon URL setting

function fancy_icon_setting() {

	?>
	<style>
		#fancy_table{}
		#fancy_table tr {}
		#fancy_table tr td { text-align:center; padding:20px;}
		#fancy_table tr th {}
		#fancy_table tr td input {margin:0px 20px;}
	</style>
    <div class="wrap">
		<form method="post" action="options.php"> 
		<?php wp_nonce_field('update-options'); ?>
		<!--<fieldset>-->
		<table id="fancy_table">
		<tr>
			<th>Icon URL</th>
			<th>Text On hover</th>
			<th>Enable/Disable</th>
			
		</tr>
		<tr>
			<td>
				Facebook: <input type="text" style="width:300px;" name="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="facebook_url_text" value="<?php echo get_option('facebook_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="facebook_url_enable" value="on" <?php echo get_option('facebook_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Twitter: <input type="text" style="width:300px;" name="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="twitter_url_text" value="<?php echo get_option('twitter_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="twitter_url_enable" value="on" <?php echo get_option('twitter_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Contact: <input type="text" style="width:300px;" name="contact_url" value="<?php echo get_option('contact_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="contact_url_text" value="<?php echo get_option('contact_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="contact_url_enable" value="on" <?php echo get_option('contact_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Help Desk: <input type="text" style="width:300px;" name="helpdesk_url" value="<?php echo get_option('helpdesk_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="helpdesk_url_text" value="<?php echo get_option('helpdesk_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="helpdesk_url_enable" value="on" <?php echo get_option('helpdesk_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Linkedin: <input type="text" style="width:300px;" name="linkedin_url" value="<?php echo get_option('linkdin_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="linkedin_url_text" value="<?php echo get_option('linkedin_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="linkedin_url_enable" value="on" <?php echo get_option('linkedin_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				FAQ: <input type="text" style="width:300px;" name="faq_url" value="<?php echo get_option('faq_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="faq_url_text" value="<?php echo get_option('faq_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="faq_url_enable" value="on" <?php echo get_option('faq_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Skype: <input type="text" style="width:300px;" name="skype_url" value="<?php echo get_option('skype_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="skype_url_text" value="<?php echo get_option('skype_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="skype_url_enable" value="on" <?php echo get_option('skype_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Instagram: <input type="text" style="width:300px;" name="instagram_url" value="<?php echo get_option('instagram_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="instagram_url_text" value="<?php echo get_option('instagram_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="instagram_url_enable" value="on" <?php echo get_option('instagram_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Pinterest: <input type="text" style="width:300px;" name="pinterest_url" value="<?php echo get_option('pinterest_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="pinterest_url_text" value="<?php echo get_option('pinterest_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="pinterest_url_enable" value="on" <?php echo get_option('pinterest_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Money: <input type="text" style="width:300px;" name="money_url" value="<?php echo get_option('money_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="money_url_text" value="<?php echo get_option('money_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="money_url_enable" value="on" <?php echo get_option('money_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Video: <input type="text" style="width:300px;" name="video_url" value="<?php echo get_option('video_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="video_url_text" value="<?php echo get_option('video_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="video_url_enable" value="on" <?php echo get_option('video_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Earn Points: <input type="text" style="width:300px;" name="contest_url" value="<?php echo get_option('contest_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="contest_url_text" value="<?php echo get_option('contest_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="contest_url_enable" value="on" <?php echo get_option('contest_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Testimonials: <input type="text" style="width:300px;" name="testimonial_url" value="<?php echo get_option('testimonial_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="testimonial_url_text" value="<?php echo get_option('testimonial_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="testimonial_url_enable" value="on" <?php echo get_option('testimonial_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Google +: <input type="text" style="width:300px;" name="google_url" value="<?php echo get_option('google_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="google_url_text" value="<?php echo get_option('google_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="google_url_enable" value="on" <?php echo get_option('google_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Gallery: <input type="text" style="width:300px;" name="gallery_url" value="<?php echo get_option('gallery_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="gallery_url_text" value="<?php echo get_option('gallery_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="gallery_url_enable" value="on" <?php echo get_option('gallery_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Blog: <input type="text" style="width:300px;" name="blog_url" value="<?php echo get_option('blog_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="blog_url_text" value="<?php echo get_option('blog_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="blog_url_enable" value="on" <?php echo get_option('blog_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Press: <input type="text" style="width:300px;" name="press_url" value="<?php echo get_option('press_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="press_url_text" value="<?php echo get_option('press_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="press_url_enable" value="on" <?php echo get_option('press_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Calender: <input type="text" style="width:300px;" name="calender_url" value="<?php echo get_option('calender_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="calender_url_text" value="<?php echo get_option('calender_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="calender_url_enable" value="on" <?php echo get_option('calender_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Pics: <input type="text" style="width:300px;" name="pics_url" value="<?php echo get_option('pics_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="pics_url_text" value="<?php echo get_option('pics_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="pics_url_enable" value="on" <?php echo get_option('pics_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<tr>
			<td>
				Notes: <input type="text" style="width:300px;" name="notes_url" value="<?php echo get_option('notes_url'); ?>" />
			</td>
			<td>
				<input type="text" style="width:300px;" name="notes_url_text" value="<?php echo get_option('notes_url_text'); ?>" />
			</td>
			<td>
				<input type="checkbox"  name="notes_url_enable" value="on" <?php echo get_option('notes_url_enable')!=''?"checked=checked":""; ?> />
			</td>
		</tr>
		<!--</fieldset>-->
		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<p class="submit">

					<input type="hidden" name="action" value="update" />

					<input type="hidden" name="page_options" value="facebook_url,twitter_url,contact_url,helpdesk_url,linkedin_url,faq_url,skype_url,
					instagram_url,pinterest_url,money_url,video_url,facebook_url_enable,twitter_url_enable,contact_url_enable,helpdesk_url_enable,linkedin_url_enable
					,faq_url_enable,skype_url_enable,instagram_url_enable,pinterest_url_enable,money_url_enable,video_url_enable,
					facebook_url_text,twitter_url_text,contact_url_text,helpdesk_url_text,linkedin_url_text,faq_url_text,skype_url_text,
					instagram_url_text,pinterest_url_text,money_url_text,video_url_text,contest_url,contest_url_enable,contest_url_text,
					testimonial_url,testimonial_url_enable,testimonial_url_text,google_url,google_url_enable,google_url_text,gallery_url,
					gallery_url,gallery_url_text,gallery_url_enable,press_url,press_url_enable,press_url_text,blog_url,blog_url_enable,blog_url_text,
					calender_url,calender_url_enable,calender_url_text,pics_url,pics_url_enable,pics_url_text,notes_url,notes_url_text,notes_url_enable" />
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

				</p>
			</td>
		</tr>
		 </table>
		</form>
     
	</div>

    <?php

}

function fancy_audio_icon_setting()	{
		//print_r($_POST);
		//exit;
		$medifile=$_FILES["mp3_file"]["name"];
		$ext = substr($medifile, strrpos($medifile, '.') + 1);
		
		if($_FILES) {
			// print_r($_FILES);
			if($_FILES["mp3_file"]["name"]!='' && $ext=='mp3') {
				if ( ! function_exists( 'wp_handle_upload' ) ) 
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
				$uploadedfile = $_FILES['mp3_file'];
				$upload_overrides = array( 'test_form' => false );
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
				//print_r($movefile);
				if ( $movefile ) {
					echo "File is valid, and was successfully uploaded.n";
					//var_dump( $movefile);
					if($ext == 'mp3') {
						update_option( 'fancy_audio_mp3', $medifile );
						update_option( 'fancy_audio_mp3_url', $movefile['url'] );
					}
					if($ext == 'ogg') {
						update_option( 'fancy_audio_ogg', $medifile );
						update_option( 'fancy_audio_ogg_url', $movefile['file'] );
					}
				} else {
					echo "Possible file upload attack!n";
				}
			}
		} 
		
		$medifile=$_FILES["ogg_file"]["name"];
		$ext = substr($medifile, strrpos($medifile, '.') + 1);
		
		if($_FILES) {
			// print_r($_FILES);
			if($_FILES["ogg_file"]["name"]!='' && $ext=='ogg') {
				if ( ! function_exists( 'wp_handle_upload' ) ) 
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
				$uploadedfile = $_FILES['ogg_file'];
				$upload_overrides = array( 'test_form' => false );
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
				//print_r($movefile);
				if ( $movefile ) {
					echo "File is valid, and was successfully uploaded.n";
					//var_dump( $movefile);
					if($ext == 'ogg') {
						update_option( 'fancy_audio_ogg', $medifile );
						update_option( 'fancy_audio_ogg_url', $movefile['file'] );
					}
				} else {
					echo "Possible file upload attack!n";
				}
			}
		}
	?>
	<div class="wrap">
		<h2>MP3 and OGG files should be with same name other than extention.</h2><br><br>
		<form method="post" action="" enctype="multipart/form-data"> 
			<h2>Previous MP3.  File: <?php echo get_option('fancy_audio_mp3'); ?> </h2><br><br>
			<input type="file" name="mp3_file"><br><br><br><br>
			<h2>Previous OGG.  File: <?php echo get_option('fancy_audio_ogg'); ?> </h2><br><br>
			<input type="file" name="ogg_file"><br><br><br><br>
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Submit') ?>" />
		</form>
	</div>
	<?php

}

function fancy_image_background_color_setting() {
?>
		<script src="<?php echo plugins_url('/js/jquery-ui.js', __FILE__); ?>" type="text/javascript">
		</script>
		<link rel="stylesheet" href="<?php echo  plugins_url('/css/jquery-ui.css', __FILE__);  ?>">
		<link rel="stylesheet" media="screen" type="text/css" href="<?php echo  plugins_url('/colorpicker/css/colorpicker.css', __FILE__);  ?>" />
		<script type="text/javascript" src="<?php echo plugins_url('/colorpicker/js/colorpicker.js', __FILE__); ?>"></script>
		<script language="JavaScript">

			jQuery(document).ready(function() {

				// var hideit = function(e, ui) { jQuery(this).val('#'+ui.hex); 
				// jQuery('.ui-colorpicker').css('display', 'none'); };
				
				// jQuery('#bg #background_color').colorpicker({ hide: hideit, submit: hideit });
				
				jQuery('#background_color').ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
						jQuery(el).val(hex);
						jQuery(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						jQuery(this).ColorPickerSetColor(this.value);
					},
					onChange: function (hsb, hex, rgb) {
						jQuery('#background_color').css('backgroundColor', '#' + hex);
					}
				})
				.bind('keyup', function(){
					jQuery(this).ColorPickerSetColor(this.value);
				});
				

			});

		</script>
		<div class="wrap">
		<form method="post" id="bg" action="options.php"> 
			<?php wp_nonce_field('update-options'); ?>
			 Background Color: <input type="text" style="width:300px; background-color:#<?php echo get_option('background_color');  ?>;" id="background_color" name="background_color" value="<?php echo get_option('background_color')!=''?get_option('background_color'):'#F3F1F2'; ?>" /> i.e d3d3d3 <br><br><br><br>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="background_color" />
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Submit') ?>" />
		</form>
	</div>
<?php
}

function fancy_video_icon_setting() {
?>
	<style>
		#fancy_table{}
		#fancy_table tr {}
		#fancy_table tr td { padding:20px; text-align: end;}
		#fancy_table tr th {}
		#fancy_table tr td input {margin:0px 20px;}
	</style>
    <div class="wrap">

		<form method="post" action="options.php"> 

		<?php wp_nonce_field('update-options'); ?>

		<!--<fieldset>-->
		<table id="fancy_table">
		<tr>
			<th>Video URL</th>
		</tr>
		<tr>
			<td>
				Youtube Video 1: <input type="text" style="width:300px;" name="youtube_url" value="<?php echo get_option('youtube_url'); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				Youtube Video 2: <input type="text" style="width:300px;" name="youtube_url_2" value="<?php echo get_option('youtube_url_2'); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				Youtube Video 3: <input type="text" style="width:300px;" name="youtube_url_3" value="<?php echo get_option('youtube_url_3'); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				Youtube Video 4: <input type="text" style="width:300px;" name="youtube_url_4" value="<?php echo get_option('youtube_url_4'); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				Youtube Video 5: <input type="text" style="width:300px;" name="youtube_url_5" value="<?php echo get_option('youtube_url_5'); ?>" />
			</td>
		</tr>
			<td>
				<p class="submit">

					<input type="hidden" name="action" value="update" />

					<input type="hidden" name="page_options" value="youtube_url ,youtube_url_2,youtube_url_3,youtube_url_4,youtube_url_5" />
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

				</p>
			</td>
		</tr>
		 </table>
		</form>
     
	</div>
<?php

}

function show_fancy_icons () {
	ob_start();
	$background_image			=	get_option('fancy_image');
	if($background_image == 'Fancy Room') {
		
		require_once("css/fancy-room-css.php");
	
	} else if($background_image == 'Fancy Bar') {
	
		require_once("css/fancy-bar-css.php");
	
	} else if($background_image == 'Fancy Resturent') {
	
		require_once("css/fancy-resturent-css.php");
	
	} else {
		require_once("css/fancy-room-css.php");
	}
?>
     <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery-1.7.min.js', __FILE__); ?>"></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery.easing.1.3.js', __FILE__); ?>"></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery.mousewheel.min.js', __FILE__); ?>"></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery.jscrollpane.min.js', __FILE__); ?>"></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/soundmanager2-nodebug-jsmin.js', __FILE__); ?>" ></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery.html5audio.min.js', __FILE__); ?>"></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery.apPlaylistManager.min.js', __FILE__); ?>"></script>
	 <script type="text/javascript" src="<?php echo plugins_url('/audio/js/jquery.apTextScroller.min.js', __FILE__); ?>"></script>
	  <script type="text/javascript">	
			function audioPlayerSetupDone(){
				/* This will get called when component is ready to receive public function calls. */
				//console.log('audioPlayerSetupDone');
			}
			// SETTINGS
			var ap_settings = {
				/*defaultVolume: 0-1 */
				defaultVolume:0.5,
				/*autoPlay: true/false (false on mobile by default) */
				autoPlay:false,
				/*autoPlayAfterFirst: true/false (if autoPlay=false, after first song play, autoPlay=true) */
				autoPlayAfterFirst:true,
				/*randomPlay: true/false */
				randomPlay:false,
				/*loopingOn: true/false (loop on the end of the playlist) */
				loopingOn:true,
				/* autoOpenPlaylist: true/false. Auto open playlist on beginning. Set this to false if you dont want to use (visible) playlist. */
				autoOpenPlaylist: false,
				/* addNumbersInPlaylist: true/false. Prepend numbers in playlist items. */
				addNumbersInPlaylist: true,
				/* useSongNameScroll: true/false. Use song name scrolling. */
				useSongNameScroll: true,
				/* scrollSeparator: String to append between scrolling song name. */
				scrollSeparator: '&nbsp;&#42;&#42;&#42;&nbsp;',
				/* mediaTimeSeparator: String between current and total song time. */
				mediaTimeSeparator: '&nbsp;-&nbsp;',
				/* seekTooltipSeparator: String between current and total song position. */
				seekTooltipSeparator: '&nbsp;/&nbsp;',
				/* scrollSpeed: speed of the scroll. */
				scrollSpeed: 1,
				/* activePlaylist: set active playlist that will be loaded on beginning (pass element 'id' attributte) */
				activePlaylist: 'playlist2',
				/* soundcloudApiKey: register you own api key here for free : http://soundcloud.com/you/apps/new and enter Client ID */
				soundcloudApiKey: '',
				/* buttonsUrl: url of the buttons for normal and rollover state (rollover state is optional), so I dont hardcode them in jquery. */
				buttonsUrl: {prev: '<?php echo plugins_url('/audio/media/data/icons/set1/prev.png', __FILE__); ?>', prevOn: '<?php echo plugins_url('/audio/media/data/icons/set1/prev_on.png', __FILE__); ?>', 
						  	 next: '<?php echo plugins_url('/audio/media/data/icons/set1/next.png', __FILE__); ?>', nextOn: '<?php echo plugins_url('/audio/media/data/icons/set1/next_on.png', __FILE__); ?>', 
						 	 pause: '<?php echo plugins_url('/audio/media/data/icons/set1/pause.png', __FILE__); ?>', pauseOn: '<?php echo plugins_url('/audio/media/data/icons/set1/pause_on.png', __FILE__); ?>',
						 	 play: '<?php echo plugins_url('/audio/media/data/icons/set1/play.png', __FILE__); ?>', playOn: '<?php echo plugins_url('/audio/media/data/icons/set1/play_on.png', __FILE__); ?>',
						 	 volume: '<?php echo plugins_url('/audio/media/data/icons/set1/volume.png', __FILE__); ?>', volumeOn: '<?php echo plugins_url('/audio/media/data/icons/set1/volume_on.png', __FILE__); ?>', 
							 mute: '<?php echo plugins_url('/audio/media/data/icons/set1/mute.png', __FILE__); ?>', muteOn: '<?php echo plugins_url('/audio/media/data/icons/set1/mute_on.png', __FILE__); ?>', 
						  	 loop: '<?php echo plugins_url('/audio/media/data/icons/set1/loop.png', __FILE__); ?>', loopOn: '<?php echo plugins_url('/audio/media/data/icons/set1/loop_on.png', __FILE__); ?>',
						  	 shuffle: '<?php echo plugins_url('/audio/media/data/icons/set1/shuffle.png', __FILE__); ?>', shuffleOn: '<?php echo plugins_url('/audio/media/data/icons/set1/shuffle_on.png', __FILE__); ?>',
						  	 playlist: '<?php echo plugins_url('/audio/media/data/icons/set1/playlist.png', __FILE__); ?>', playlistOn: '<?php echo plugins_url('/audio/media/data/icons/set1/playlist_on.png', __FILE__); ?>'}
			};
			
			//sound manager settings (http://www.schillmania.com/projects/soundmanager2/)
			soundManager.allowScriptAccess = 'always';
			soundManager.debugMode = false;
			soundManager.noSWFCache = true;
			soundManager.useConsole = false;
			soundManager.waitForWindowLoad = true;
			soundManager.url = 'swf/';
			soundManager.flashVersion = 9;
			soundManager.preferFlash = false; // use HTML5 audio for MP3/MP4, if available
			soundManager.useHTML5Audio = true;
			
			var audio = document.createElement('audio'), mp3Support, oggSupport;
			if (audio.canPlayType) {
			   mp3Support = !!audio.canPlayType && "" != audio.canPlayType('audio/mpeg');
			   oggSupport = !!audio.canPlayType && "" != audio.canPlayType('audio/ogg; codecs="vorbis"');
			}else{
				//for IE<9
				mp3Support = true;
				oggSupport = false;
			}
			//console.log('mp3Support = ', mp3Support, ' , oggSupport = ', oggSupport);
			
			/*
			FF - false, true
			OP - false, true
			
			IE9 - true, false 
			SF - true, false 
			
			CH - true, true
			*/
			
		    soundManager.audioFormats = {
			  'mp3': {
				'type': ['audio/mpeg; codecs="mp3"', 'audio/mpeg', 'audio/mp3', 'audio/MPA', 'audio/mpa-robust'],
				'required': mp3Support
			  },
			  'mp4': {
				'related': ['aac','m4a'], // additional formats under the MP4 container
				'type': ['audio/mp4; codecs="mp4a.40.2"', 'audio/aac', 'audio/x-m4a', 'audio/MP4A-LATM', 'audio/mpeg4-generic'],
				'required': false
			  },
			  'ogg': {
				'type': ['audio/ogg; codecs=vorbis'],
				'required': oggSupport
			  },
			  'wav': {
				'type': ['audio/wav; codecs="1"', 'audio/wav', 'audio/wave', 'audio/x-wav'],
				'required': false
			  }
			};
			
			jQuery(window).load(function() {
				jQuery.noConflict();
				
				jQuery('#m3').children('a').css({
				   background : '#ccc',
				   cursor : 'default'
				});
				
				//init component
			    jQuery.html5audio('#componentWrapper', ap_settings, 'sound_id1');
			    ap_settings = null;
    	    });
			
    </script>
	<script src="<?php echo plugins_url('/opentip/js/adapter-jquery.js', __FILE__); ?>" type="text/javascript">
	</script>
	<script src="<?php echo plugins_url('/opentip/js/opentip.js', __FILE__); ?>" type="text/javascript">
	</script>
	<script src="<?php echo plugins_url('/opentip/js/adapter-prototype.js', __FILE__); ?>" type="text/javascript">
	</script>
	<script src="<?php echo plugins_url('/opentip/js/adapter-native.js', __FILE__); ?>" type="text/javascript">
	</script>
	<script src="<?php echo plugins_url('/opentip/js/adapter-ender.js', __FILE__); ?>" type="text/javascript">
	</script>
	<script src="<?php echo plugins_url('/opentip/js/adapter-component.js', __FILE__); ?>" type="text/javascript">
	</script>
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('/audio/css/jquery.jscrollpane.css', __FILE__); ?>" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('/audio/css/html5audio4.css', __FILE__); ?>" />
	
	<link rel="stylesheet" href="<?php echo plugins_url('/opentip/css/opentip.css', __FILE__); ?>" type="text/css" >
	<script type="text/javascript" src="<?php echo plugins_url('/slider/js/jquery.aw-showcase.js', __FILE__); ?>"></script>
	<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery("#showcase").awShowcase(
		{
			content_width:			408,
			content_height:			<?php echo $background_image == 'Fancy Resturent'?'208':'230'; ?>,
			fit_to_parent:			false,
			auto:					false,
			interval:				4000,
			continuous:				true,
			loading:				true,
			tooltip_width:			200,
			tooltip_icon_width:		32,
			tooltip_icon_height:	32,
			tooltip_offsetx:		18,
			tooltip_offsety:		0,
			arrows:					true,
			buttons:				false,
			btn_numbers:			false,
			keybord_keys:			true,
			mousetrace:				false, /* Trace x and y coordinates for the mouse */
			pauseonover:			true,
			stoponclick:			false,
			transition:				'hslide', /* hslide/vslide/fade */
			transition_delay:		0,
			transition_speed:		1000,
			show_caption:			'onload', /* onload/onhover/show */
			thumbnails:				false,
			thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
			thumbnails_direction:	'vertical', /* vertical/horizontal */
			thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
			dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
			speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
			viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
			custom_function:		null /* Define a custom function that runs on content change */
		});
	});

	</script>
	<script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function(){
					var new1	=	new Opentip("#facebook_url a", "<?php echo get_option('facebook_url_text'); ?>", "Facebook",
					{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#facebook_url a" });
					
					var new2	=	new Opentip("#twitter_url a", "<?php echo get_option('twitter_url_text'); ?>", "Twitter",
					{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#twitter_url a"});
				
					var new3	=	new Opentip("#contact_url a", "<?php echo get_option('contact_url_text'); ?>", "Contact",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#contact_url a"});
					
					var new4	=	new Opentip("#helpdesk_url a", "<?php echo get_option('helpdesk_url_text'); ?>", "Help Desk",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#helpdesk_url a"});
						
					var new5	=	new Opentip("#linkedin_url a", "<?php echo get_option('linkedin_url_text'); ?>", "Linkedin",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#linkedin_url a"});
						

					var new6	=	new Opentip("#faq_url a", "<?php echo get_option('faq_url_text'); ?>", "FAQ",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#faq_url a"});
				
					var new20	=	new Opentip("#skype_url a", "<?php echo get_option('skype_url_text'); ?>", "Skype",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#skype_url a"});
						
					var new7	=	new Opentip("#instagram_url a", "<?php echo get_option('instagram_url_text'); ?>", "Instagram",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#instagram_url a"});
						
					var new8	=	new Opentip("#money_url a", "<?php echo get_option('money_url_text'); ?>", "Money",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#money_url a"});
					
					var new9	=	new Opentip("#video_url a", "<?php echo get_option('video_url_text'); ?>", "Video",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#video_url a"});
						
					var new10	=	new Opentip("#pinterest_url a", "<?php echo get_option('pinterest_url_text'); ?>", "Pinterest",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#pinterest_url a"});
						
					var new11	=	new Opentip("#contest_url a", "<?php echo get_option('contest_url_text'); ?>", "Contest",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#contest_url a"});
					
					var new12	=	new Opentip("#testimonial_url a", "<?php echo get_option('testimonial_url_text'); ?>", "Testimonials",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#testimonial_url a"});
						
					var new13	=	new Opentip("#google_url a", "<?php echo get_option('google_url_text'); ?>", "Google",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#google_url a"});
						

					var new14	=	new Opentip("#press_url a", "<?php echo get_option('press_url_text'); ?>", "Press",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#press_url a"});
						
					var new15	=	new Opentip("#blog_url a", "<?php echo get_option('blog_url_text'); ?>", "Blog",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#blog_url a"});
				
					var new16	=	new Opentip("#calender_url a", "<?php echo get_option('calender_url_text'); ?>", "Calender",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#calender_url a"});
					
					var new17	=	new Opentip("#pics_url a", "<?php echo get_option('pics_url_text'); ?>", "Pictures",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#pics_url a"});
					
					var new18	=	new Opentip("#notes_url a", "<?php echo get_option('notes_url_text'); ?>", "Notes",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#notes_url a"});
					
					var new19	=	new Opentip("#audio_url a", "<?php echo get_option('audio_url_text'); ?>", "Audio",
						{showOn:"mouseover",hideOn:"mouseout",group:"funny" ,hideTrigger:"closeButton", delay: 0.5,hideDelay: 0.5,background:"#E5E4E2" , stem:true ,tipJoint : 
					"center top", fixed:true ,stemBase: 10,stemLength:15,closeButtonCrossColor:"#FF0000",target:"#audio_url a"});

		});	
	</script>
	<style>
	.showcase-content a img{
							margin:15px; 
							box-shadow: 0 0 1px #000000 !important; 
							float:left; 
							width:239px !important;
							height:160px !important ;
							float:left;
	}
	.showcase-content a img:hover{
									/*border:solid 1px #79C700;*/ 
									border:solid 1px #008bf5 ; 
									width:238px !important; 
									height:162px !important ;
									margin:13px !important;
	}
	.showcase-arrow-previous, .showcase-arrow-next
	{
		position: absolute;
		background: url("<?php echo  plugins_url('slider/images/gffg.png', __FILE__);  ?>") no-repeat scroll 0 0 transparent;
		width: 18px;
		height: 11px;
		cursor: pointer;
	}
	</style>
	<link rel="stylesheet" href="<?php echo  plugins_url('/slider/css/style.css', __FILE__);  ?>">
	
	<div class="social">
		<?php if(get_option('facebook_url_enable') == 'on') { ?>
		<div  id="facebook_url">
			<a  target="_blank" href="<?php echo get_option('facebook_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('twitter_url_enable') == 'on') { ?>
		<div id="twitter_url">
			<a  target="_blank" href="<?php echo get_option('twitter_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('contact_url_enable') == 'on') { ?>
		<div id="contact_url">
			<a  target="_blank" href="<?php echo get_option('contact_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('helpdesk_url_enable') == 'on') { ?>
		<div id="helpdesk_url">
			<a  target="_blank" href="<?php echo get_option('helpdesk_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('linkedin_url_enable') == 'on') { ?>
		<div id="linkedin_url">
			<a  target="_blank" href="<?php echo get_option('linkedin_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('faq_url_enable') == 'on') { ?>
		<div id="faq_url">
			<a  target="_blank" href="<?php echo get_option('faq_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('skype_url_enable') == 'on') { ?>
		<div id="skype_url">
			<a  href="#<?php //echo get_option('skype_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('instagram_url_enable') == 'on') { ?>
		<div id="instagram_url">
			<a  target="_blank" href="<?php echo get_option('instagram_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('money_url_enable') == 'on') { ?>
		<div id="money_url">
			<a  target="_blank" href="<?php echo get_option('money_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('video_url_enable') == 'on') { ?>
		<div id="video_url">
			<a  target="_blank" href="<?php echo get_option('video_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('pinterest_url_enable') == 'on') { ?>
		<div id="pinterest_url">
			<a  target="_blank" href="<?php echo get_option('pinterest_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('contest_url_enable') == 'on') { ?>
		<div id="contest_url">
			<a  target="_blank" href="<?php echo get_option('contest_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('testimonial_url_enable') == 'on') { ?>
		<div id="testimonial_url">
			<a  target="_blank" href="<?php echo get_option('testimonial_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('google_url_enable') == 'on') { ?>
		<div id="google_url">
			<a  target="_blank" href="<?php echo get_option('google_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('gallery_url_enable') == 'on') { ?>
		<div id="gallery_url">
			<a  target="_blank" href="<?php echo get_option('gallery_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('press_url_enable') == 'on') { ?>
		<div id="press_url">
			<a  target="_blank" href="<?php echo get_option('press_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('blog_url_enable') == 'on') { ?>
		<div id="blog_url">
			<a  target="_blank" href="<?php echo get_option('blog_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('calender_url_enable') == 'on') { ?>
		<div id="calender_url">
			<a  target="_blank" href="<?php echo get_option('calender_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('pics_url_enable') == 'on') { ?>
		<div id="pics_url">
			<a  target="_blank" href="<?php echo get_option('pics_url'); ?>"></a>
		</div>
		<?php } ?>
		<?php if(get_option('notes_url_enable') == 'on') { ?>
		<div id="notes_url">
			<a  style="text-decoration:none; font-size:13px; color:black;" target="_blank" href="<?php echo get_option('notes_url'); ?>">
				<p style="margin-left:5px; margin-top:5px; text-decoration:none; margin-right:5px;">
				<?php if($background_image != 'Fancy Room') { echo get_option('notes_url_text'); } ?><p>
			</a>
		</div>
		<?php } ?>
		<div id="audio_url" style="display:block;">
			<!--<a  onclick="playSound('<?php //echo get_option('fancy_audio_url'); ?>')" href="javascript:void(0)"></a>-->
			        <!-- wrapper for the whole component -->
			<div id="componentWrapper">
			
				 <!-- for audio code -->
				 <div class="audioHolder"></div>	
			
				 <div class="playerHolder">
					 
					  <div class="player_controls">
						  <!-- pause/play -->
						  <div class="controls_toggle"><img src='<?php echo plugins_url('/audio/media/data/icons/set1/play.png', __FILE__); ?>' width='24' height='24' alt='controls_toggle'/></div>
						  
						  <!-- volume -->
						  <div class="player_volume"><img src='<?php echo plugins_url('/audio/media/data/icons/set1/volume.png', __FILE__); ?>' width='24' height='24' alt='player_volume'/></div>
						  <div class="volume_seekbar">
							 <div class="volume_bg"></div>
							 <div class="volume_level"></div>
						  </div>
					  </div>
					  
					  <!-- progress -->
					  <div class="player_progress">
						  <div class="progress_bg"></div>
						  <div class="load_level"></div>
						  <div class="progress_level"></div>
					  </div>
					 
					  <!-- song name -->
					  <div class="player_mediaName_Mask">
						  <div class="player_mediaName">Artist Name - Artist Title</div>
					  </div>
					  
					  <!-- volume tooltip -->
					  <div class="player_volume_tooltip">
						  <div class="player_volume_tooltip_value">0</div>
					  </div>
					  
					  <!-- progress tooltip -->
					  <div class="player_progress_tooltip">
						  <div class="player_progress_tooltip_value">0:00&nbsp;/&nbsp;0:00</div>
					  </div>
				 
				  </div>
				  
				  <div class="playlistHolder">
				 
					 <div class="componentPlaylist">
						 <!-- playlist_inner: container for scroll -->
						 <div class="playlist_inner">
						 
						 <!-- List of playlists. NO EXTENSION for music file names! -->
							 <?php 
									$mp3_url = explode(".mp",get_option('fancy_audio_mp3_url'));
									$ogg_url = explode(".og",get_option('fancy_audio_ogg_url'));
							 ?>
							 <!-- local playlist -->
							 <ul id='playlist1' data-type='local'>
								 <li class= "playlistItem" data-path="<?php echo $mp3_url[0]; ?>" ><a class="playlistNonSelected" href='#'><?php echo get_option('fancy_audio_mp3'); ?></a></li>
							 	 <li class= "playlistItem" data-path="<?php echo $ogg_url[0]; ?>" ><a class="playlistNonSelected" href='#'><?php echo get_option('fancy_audio_ogg'); ?></a></li>
							 </ul>
							 
							 <!-- local playlist -->
							 <ul id='playlist2' data-type='local'>
								 <li class= "playlistItem" data-path="<?php echo $mp3_url[0]; ?>" ><a class="playlistNonSelected" href='#'><?php echo get_option('fancy_audio_mp3'); ?></a></li>
							 	 <li class= "playlistItem" data-path="<?php echo $ogg_url[0]; ?>" ><a class="playlistNonSelected" href='#'><?php echo get_option('fancy_audio_ogg'); ?></a></li>

							 </ul>

							 
						 </div>
					 </div>
					
					 <!-- for parsing podcast feeds -->
					 <div class="feedParser"></div>
				 
				 </div>
				 
				 <!-- font calculations -->
				 <div class="fontMeasure"></div>
			
			</div>
			   		<!-- public function calls -->
    	<div id='publicFunctions'>
       		<p>PUBLIC METHODS</p><br/>
            <ul>
                <!-- play active media -->
                <li><a href='#' onClick="jQuery.html5audio.playAudio(); return false;">Play current media</a></li>
                
                <!-- stop active media -->
                <li><a href='#' onClick="jQuery.html5audio.stopAudio(); return false;">Pause current media</a></li>
                
                <!-- play next media -->
                <li><a href='#' onClick="jQuery.html5audio.nextAudio(); return false;">Play next</a></li>
                
                <!-- play previous media -->
                <li><a href='#' onClick="jQuery.html5audio.previousAudio(); return false;">Play previous</a></li>
                
                <!-- play media number -->
                <li><a href='#' onClick="jQuery.html5audio.loadAudio(2); return false;">Play media number 2</a></li>
                
                <!-- toggle playlist -->
                <li><a href='#' onClick="jQuery.html5audio.togglePlaylistState(); return false;">Toggle playlist</a></li>
                
                <!-- toggle shuffle -->
                <li><a href='#' onClick="jQuery.html5audio.toggleShuffle(); return false;">Toggle shuffle</a></li>
                
                <!-- toggle loop -->
                <li><a href='#' onClick="jQuery.html5audio.toggleLoop(); return false;">Toggle loop</a></li>
                
                <!-- set volume (0-1) -->
                <li><a href='#' onClick="jQuery.html5audio.setVolume(0.5); return false;">Set volume (0.5)</a></li>
                
                <!-- load new playlist (pass element id) -->
                <li><a href='#' onClick="jQuery.html5audio.inputPlaylist('playlist1'); return false;">Load playlist 1</a></li>

                <!-- load new playlist (pass element id) -->
                <li><a href='#' onClick="jQuery.html5audio.inputPlaylist('playlist2'); return false;">Load playlist 2</a></li>
                
                <!-- destroy audio -->
                <li><a href='#' onClick="jQuery.html5audio.destroyAudio(); return false;">Destroy audio</a></li>
                
                <!-- reinitialize scroll (check help for more info when to use this) 
                <li><a href='#' onClick="jQuery.html5audio.reinitScroll(); return false;">Reinitialize scroll</a></li>-->
            </ul>
         </div>
		</div>
		<div id="showcase" class="showcase">
			<?php if(get_option('youtube_url') !='') { ?>
			<div class='showcase-slide'>
				<?php $youtube_video_id	= fancy_room_youtube_id_from_url(get_option('youtube_url')); ?>
				<iframe src="http://www.youtube.com/watch_popup?v=<?php echo $youtube_video_id; ?>&amp;vq=medium" height="<?php echo $background_image == 'Fancy Resturent'?'208':'230'; ?>" width="408" allowfullscreen="" frameborder="0"></iframe>
			</div>
			<?php } ?>
			<?php if(get_option('youtube_url_2') !='') { ?>
			<div class='showcase-slide'>
				<?php $youtube_video_id	= fancy_room_youtube_id_from_url(get_option('youtube_url_2')); ?>
				<iframe src="http://www.youtube.com/watch_popup?v=<?php echo $youtube_video_id; ?>&amp;vq=medium" height="<?php echo $background_image == 'Fancy Resturent'?'208':'230'; ?>" width="408" allowfullscreen="" frameborder="0"></iframe>
			</div>
			<?php } ?>
			<?php if(get_option('youtube_url_3') !='') { ?>
			<div class='showcase-slide'>
				<?php $youtube_video_id	= fancy_room_youtube_id_from_url(get_option('youtube_url_3')); ?>
				<iframe src="http://www.youtube.com/watch_popup?v=<?php echo $youtube_video_id; ?>&amp;vq=medium" height="<?php echo $background_image == 'Fancy Resturent'?'208':'230'; ?>" width="408" allowfullscreen="" frameborder="0"></iframe>
			</div>
			<?php } ?>
			<?php if(get_option('youtube_url_4') !='') { ?>
			<div class='showcase-slide'>
				<?php $youtube_video_id	= fancy_room_youtube_id_from_url(get_option('youtube_url_4')); ?>
				<iframe src="http://www.youtube.com/watch_popup?v=<?php echo $youtube_video_id; ?>&amp;vq=medium" height="<?php echo $background_image == 'Fancy Resturent'?'208':'230'; ?>" width="408" allowfullscreen="" frameborder="0"></iframe>
			</div>
			<?php } ?>
			<?php if(get_option('youtube_url_5') !='') { ?>
			<div class='showcase-slide'>
				<?php $youtube_video_id	= fancy_room_youtube_id_from_url(get_option('youtube_url_5')); ?>
				<iframe src="http://www.youtube.com/watch_popup?v=<?php echo $youtube_video_id; ?>&amp;vq=medium" height="<?php echo $background_image == 'Fancy Resturent'?'208':'230'; ?>" width="408" allowfullscreen="" frameborder="0"></iframe>
			</div>
			<?php } ?>
			<!--<div class='showcase-slide'>
				<img src="<?php //echo plugins_url('/images/background.jpg', __FILE__); ?>">
			</div>-->
		</div>
	</div>
   <?php
	$buffer	=	ob_get_contents();
	ob_end_clean();
	return $buffer;
}

function cwifw_custom_upload_mimes ( $existing_mimes=array() ) {
 
// Add file extension 'extension' with mime type 'mime/type'
$existing_mimes['extension'] = 'mime/type';
 
// add as many as you like e.g. 

$existing_mimes['mp3'] = 'application/mp3'; 
$existing_mimes['ogg'] = 'application/ogg';

// remove items here if desired ...
 
// and return the new full result
return $existing_mimes;

 
}

function fancy_room_youtube_id_from_url($url) {
    $pattern = 
        '%^
        (?:https?://)? 
        (?:www.)?
        (?:
          youtu.be/
        | youtube.com
          (?:           
            /embed/     
          | /v/         
          | /watch?v=  
          )            
        )              
        ([w-]{10,12})
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}
add_filter( 'template_include', 'include_template_files' );
function include_template_files() {
    global $wp;
    $plugindir = dirname( __FILE__ );
    $templatefilename = 'page-fancy-room.php';
    $template = $plugindir .'/'. $templatefilename;
    return $template;

}
?>