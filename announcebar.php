<?php
/*
Plugin Name: Announcement Bar - Top/Bottom Notification Bar for Webmasters
Plugin URI: http://www.iwebslog.com/
Description: Announcement Bar is a simple, powerful and flexible plugin which allows you to add an informational bar on the top or bottom of your WordPress site to display any announcement or notifications with a call to action button. 
Author: Iwebslog.Com
Version: 1.1
Author URI: http://www.iwebslog.com
*/
// ----------------------------------------------------------------------------------

// ADD Styles and Script in head section
add_action('admin_init', 'announcebar_backend_scripts');
add_action('wp_enqueue_scripts', 'announcebar_frontend_scripts');

function announcebar_backend_scripts() {
	if(is_admin()){
		wp_enqueue_script ('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_script('announcebar_backend_scripts',plugins_url('admin/announcebar_admin.js',__FILE__), array('jquery'));
		wp_enqueue_style('announcebar_backend_scripts',plugins_url('admin/announcebar_admin.css',__FILE__), false, '1.0.0' );
		wp_enqueue_style('farbtastic');	
	}
}

function announcebar_frontend_scripts() {	
	if(!is_admin()){
		wp_enqueue_script('jquery');
		wp_enqueue_script('announcebar',plugins_url('js/announcebar.js',__FILE__), array('jquery'));
		wp_enqueue_style('announcebar',plugins_url('css/announcebar.css',__FILE__));
	}
}
//-------------------------------------------------------------------------------------

// Hook for adding admin menus
add_action('admin_menu', 'announcebar_plugin_admin_menu');
function announcebar_plugin_admin_menu() {
     add_menu_page('announcebar', 'Announcement Bar','administrator', 'announcebar', 'announcebar_backend_menu',plugins_url('images/icon.png',__FILE__));
}


//This function will create new database fields with default values
function announcebar_defaults(){
	    $default = array(
		'defaultposition' => 'top',
		'color_scheme' => '#0F67A1',
        'text_field' => 'Get my Website Updates',
		'msgtxt_color' => '#FFFFFF',
    	'link_url' => 'http://www.iwebslog.com',
    	'link_text' => 'Subscribe Me',
		'linktxt_color' => '#FFFFFF',
		'link_bgcolor' => '#0F67A1'
    );
return $default;
}

// Runs when plugin is activated and creates new database field
register_activation_hook(__FILE__,'announcebar_plugin_install');
add_action('admin_init', 'announcebar_plugin_redirect');
function announcebar_plugin_activate() {
    add_option('announcebar_plugin_do_activation_redirect', true);
}

function announcebar_plugin_redirect() {
    if (get_option('announcebar_plugin_do_activation_redirect', false)) {
        delete_option('announcebar_plugin_do_activation_redirect');
        wp_redirect('admin.php?page=announcebar');
    }
}

function announcebar_plugin_install() {
    add_option('announcebar_options', announcebar_defaults());
	announcebar_plugin_activate();
}	


// update the announcebar options
if(isset($_POST['announcebar_update'])){
	update_option('announcebar_options', announcebar_updates());
}

function announcebar_updates() {
	$options = $_POST['announcebar_options'];
	    $update_val = array(
		'defaultposition' => $options['defaultposition'],
		'color_scheme' => $options['color_scheme'],
    	'text_field' =>$options['text_field'],
    	'msgtxt_color' =>$options['msgtxt_color'],
    	'link_url' =>$options['link_url'],
    	'link_text' => $options['link_text'],
		'linktxt_color' => $options['linktxt_color'],
		'link_bgcolor' => $options['link_bgcolor']
    );
return $update_val;
}

// get announcebar version
function announcebar_get_version(){
	if ( ! function_exists( 'get_plugins' ) )
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

function announcebar_backend_menu()
{
wp_nonce_field('update-options'); $options = get_option('announcebar_options'); 
$options['defaultposition']

?>

<div class="wrap">
<div id="icon-themes" class="icon32"></div>
<h2><?php _e('Announcement Bar '.announcebar_get_version().' Setting\'s','announcebar'); ?></h2>
</div>

<div class="nbarlite-wrapper">
	<!-- WP-Banner Starts Here -->
		<div id="wp_banner" class="nbar-lite">
			<!-- Top Section Starts Here -->
			<div class="top_section">
				<!-- Begin MailChimp Signup Form -->
				<form style="border:1px solid #ccc;padding:3px;text-align:center;" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=IwebslogBlog', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p>Enter your email address:</p><p><input type="text" style="width:140px" name="email"/></p><input type="hidden" value="IwebslogBlog" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe" /><p>Delivered by <a href="http://feedburner.google.com" target="_blank">FeedBurner</a></p></form>
				</div>
			<!-- Top Section Ends Here -->
			
			<!-- Bottom Section Starts Here -->
			<div class="bot_section">
				<a href="http://www.iwebslog.com/" class="wplogo" target="_blank" title="Iwebslog.com"></a>
				<a href="https://www.facebook.com/pages/Iwebslog" class="fbicon" target="_blank" title="Facebook"></a>
				<a href="http://www.twitter.com/iwebslogtech" class="twicon" target="_blank" title="Twitter"></a>
				<div style="clear:both;"></div>
			</div>
			<!-- Bottom Section Ends Here -->
		</div>
	<!-- WP-Banner Ends Here -->
</div>

	
<div id="poststuff" style="position:relative;">
	<div class="postbox" id="announcebar_admin">
		<div class="handlediv" title="Click to toggle"><br/></div>
		<h3 class="hndle"><span><?php _e("Enter Announcement values:",'announcebar'); ?></span></h3>
		<div class="inside" style="padding: 15px;margin: 0;">
			<form method="post">
				<table>
				
					<tr>
						<td><?php _e("Default Position",'announcebar'); ?> :</td>
						<td><select name="announcebar_options[defaultposition]"><option value="top" <?php selected('top', $options['defaultposition']); ?>>Top</option><option value="bottom" <?php selected('bottom', $options['defaultposition']); ?>>Bottom</option></select></td>
					</tr>
							
					<tr>
						<td><?php _e("Color Scheme",'announcebar'); ?> :</td>
						<td>
							<div class="announcebar_colwrap">
								<input type="text" id="announcebar_colorScheme" class="announcebar_color_inp" value="<?php if($options['color_scheme']) echo $options['color_scheme']; else echo "#0F67A1"; ?>" name="announcebar_options[color_scheme]" />
								<div class="announcebar_colsel announcebar_colorScheme"></div>
							</div>
						</td>
					</tr>

					<tr>
						<td><?php _e("Text Message", 'announcebar'); ?> :</td>
						<td><textarea col="10" name="announcebar_options[text_field]"><?php echo $options['text_field'] ?></textarea></td>
					</tr>
					
					<tr>
						<td><?php _e("Text Message Color",'announcebar'); ?> :</td>
						<td>
							<div class="announcebar_colwrap">
								<input type="text" id="announcebar_txtclr" class="announcebar_color_inp" value="<?php if($options['msgtxt_color']) echo $options['msgtxt_color']; else echo "#FFFFFF"; ?>" name="announcebar_options[msgtxt_color]" />
								<div class="announcebar_colsel announcebar_txtclr"></div>
							</div>
						</td>
					</tr>

					<tr>
						<td><?php _e("Link URL", 'announcebar'); ?> :</td>
						<td><input type="text" name="announcebar_options[link_url]" value="<?php echo $options['link_url'] ?>" /></td>
					</tr>
					<tr>
						<td><?php _e("Link Button Text", 'announcebar'); ?> :</td>
						<td><input type="text" name="announcebar_options[link_text]" value="<?php echo $options['link_text'] ?>" /></td>
					</tr>
					
					<tr>
						<td><?php _e("Link Text Color",'announcebar'); ?> :</td>
						<td>
							<div class="announcebar_colwrap">
								<input type="text" id="announcebar_linktxtclr" class="announcebar_color_inp" value="<?php if($options['linktxt_color']) echo $options['linktxt_color']; else echo "#FFFFFF"; ?>" name="announcebar_options[linktxt_color]" />
								<div class="announcebar_colsel announcebar_linktxtclr"></div>
							</div>
						</td>
					</tr>
					
					<tr>
						<td><?php _e("Link Bg-Color",'announcebar'); ?> :</td>
						<td>
							<div class="announcebar_colwrap">
								<input type="text" id="announcebar_linkbg" class="announcebar_color_inp" value="<?php if($options['link_bgcolor']) echo $options['link_bgcolor']; else echo "#0F67A1"; ?>" name="announcebar_options[link_bgcolor]" />
								<div class="announcebar_colsel announcebar_linkbg"></div>
							</div>
						</td>
					</tr>

				</table>

				<p class="button-controls">
					<input type="submit" value="<?php _e('Save Settings','announcebar'); ?>" class="button-primary" id="announcebar_update" name="announcebar_update">	
				</p>
			</form>
		</div>
	</div>
	<iframe class="announcebar_iframe" src="http://feeds.feedburner.com/IwebslogBlog" width="350px" height="400px" scrolling="no" ></iframe> 
</div>
<?php
}
//--------------------------------------------------------------------------------------------------------------------------------------

function announcebar(){
$options = get_option('announcebar_options'); 
?>  
<style type="text/css">
#announcebar{<?php echo $options['defaultposition'] ?>:0px;}
#announcebar .announcebar_topsec .announcebar_center .announcebar_block {color:<?php echo $options['msgtxt_color'] ?>;}
#announcebar .announcebar_topsec .announcebar_center .announcebar_button {color:<?php echo $options['linktxt_color'] ?>;}

<?php if($options['defaultposition'] =="bottom"){ ?> 
#announcebar .announcebar_topsec{border-top:3px solid #fff;border-bottom:0;}
#announcebar a.announcebar_close{top: 17px;background-image:url("<?php echo plugins_url('images/sprite_bot.png',__FILE__); ?>");background-position:0 center;}
#announcebar a.announcebar_close:hover{background-position:0 center;opacity:0.6;filter:alpha(opacity = 60);}
<?php } ?>
#nbar_downArr.announcebar_botsec{<?php echo $options['defaultposition']; ?>:-41px;<?php if($options['defaultposition'] =="bottom"){ ?> background-image:url("<?php echo plugins_url('images/up_arrow.png',__FILE__); ?>");<?php } ?>}
</style>

	<div id="announcebar">
		<a class="nbar_downArr" href="#nbar_downArr" style="display:none;"></a>
		<div class="announcebar_topsec" style="background-color:<?php echo $options['color_scheme'] ?>">
		<?php $from_this = "http://www.iwebslog.com/".$_SERVER['SERVER_NAME']; ?>
		<a title="Get the Announcement Bar for your website and Attract visitors to your page" class="nb_fromthis" target="_blank" href="<?php echo $from_this; ?>" title=""><img src="<?php echo plugins_url('images/NB_32x32.png',__FILE__) ?>" /></a>
			<div class="announcebar_center">
				<?php if($options['text_field']){ ?><div class="announcebar_block"><?php echo $options['text_field'] ?></div><?php } ?>
				<?php if($options['link_url']){ ?><a href="<?php echo $options['link_url'] ?>" target="_blank" class="announcebar_block announcebar_button" style="background-color:<?php echo $options['link_bgcolor'] ?>"><?php echo $options['link_text'] ?></a><?php } ?>
			</div>
			<a href="JavaScript:void(0);" class="announcebar_close"></a>
		</div>
	</div>
	<a href="JavaScript:void(0);" class="announcebar_botsec" id="nbar_downArr" style="background-color:<?php echo $options['color_scheme'] ?>"></a>
	
<script type="text/javascript">
	jQuery(document).ready(function(){
		<?php 
		if($options['defaultposition'] =="bottom"){ ?>jQuery('body').append('<div class="announcebar_push"></div>');<?php } 
		else{ ?>jQuery('body').prepend('<div class="announcebar_push"></div>');<?php } ?>
		
		jQuery("#announcebar").announcebar();
	});
</script>

<?php
}
add_action('wp_footer', 'announcebar');

?>