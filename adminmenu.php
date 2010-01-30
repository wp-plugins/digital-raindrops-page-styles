<?php
/*	This file is part of the Digital Raindrops Page Styles Plugin */
/*	Copyright 2010  David Cox  (email : david.cox@digitalraindrops.net) */

/* Prevent direct access to this file */

/* This section creates the admin page Style Swapper area */
$themename = get_current_theme();
$themes = drf_get_theme_list();
$themehortname = 'drf_';
$themeoptions = array (
array("name" => "ADD THEMES STYLESHEETS TO INDIVDUAL PAGES",
	"type" => "heading",
	"desc" => "You can choose a different theme Stylesheet for any page<br/><br?> This will not change the theme just the Stylesheet"));
	
/* add each page to an array for the Style Switcher setup */
$drfpages = get_pages();
foreach ($drfpages as $pagg) {
	$drfpagetitle = $pagg->post_title;
	$drfpagename = $drfpagetitle." Page";
	array_push($themeoptions, array(
		"name" => $drfpagename,
		"type" => "heading"));        

	array_push($themeoptions, array(
		"name" => "Theme",
		"id" => drf_get_unique_id($drfpagetitle),
		"type" => "select",
		"options" => $themes,
		"std" => $themename));
}

$thisplugin->plug_domain;

/* Get a list of Installed Themes */
function drf_get_theme_list()
{
$dirname = get_theme_root().'/';
	foreach(scandir($dirname) as $item)
	{
	if (is_dir($item)) 
		{
			continue;
		}
		if (!is_file($item))
			{
			$theme[] = $item;
			}
	}
	return $theme;
}

function drf_styles_update_option($key, $value){
	drf_update_option($key, (get_magic_quotes_gpc()) ? stripslashes($value) : $value);
}

function drf_styles_add_admin() {

	global $themename, $themeshortname, $themeoptions, $thisplugin;

    if ( $_GET['page'] == basename(__FILE__)) {
   
        if ('save' == $_REQUEST['action'] ) {

                foreach ($themeoptions as $value) {
                    if($value['type'] != 'multicheck'){
                        drf_styles_update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                    }else{
                        foreach($value['options'] as $mc_key => $mc_value){
                            $up_opt = $value['id'].'_'.$mc_key;
                            drf_styles_update_option($up_opt, $_REQUEST[$up_opt] );
                        }
                    }
                }
                foreach ($themeoptions as $value) {
                    if($value['type'] != 'multicheck'){
                        if( isset( $_REQUEST[ $value['id'] ] ) ) drf_styles_update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
                    }else{
                        foreach($value['options'] as $mc_key => $mc_value){
                            $up_opt = $value['id'].'_'.$mc_key;
                            if( isset( $_REQUEST[ $up_opt ] ) )  drf_styles_update_option( $up_opt, $_REQUEST[ $up_opt ] ); 
                        }
                    }
                }
                header("Location: themes.php?page=adminmenu&saved=true");
                die;
        } 
    }
	add_theme_page( __("Manage Pagestyles", 'drfss'), __("Page Styles", 'drfss'), MANAGEMENT_PERMISSION, basename(__FILE__), "drf_styles_admin");
 }

// Create the admin form
function drf_styles_admin() {
    global $themename, $themeshortname, $themeoptions, $thisplugin;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>settings saved.</strong></p></div>';
?>
<div class="wrap">
	<h2>Page Stylesheets</h2>
		<p></p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="11214958">
		<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
		<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
		</form>
 
	<form method="post">

		<table class="optiontable" style="width:100%;">

<?php foreach ($themeoptions as $value) {
   
    switch ( $value['type'] ) {
        case 'text':
        drf_option_wrapper_header($value);
        ?>
                <input style="width:35%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( drf_get_settings( $value['id'] ) != "") { echo drf_get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
        <?php
        drf_option_wrapper_footer($value);
        break;
       
        case 'select':
        drf_option_wrapper_header($value);
        ?>
                <select style="width:40%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                    <?php foreach ($value['options'] as $option) { ?>
                    <option<?php if ( drf_get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
        <?php
        drf_option_wrapper_footer($value);
        break;
       
        case 'textarea':
        $ta_options = $value['options'];
        drf_option_wrapper_header($value);
        ?>
                <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width:100%;height:100px;"><?php
                if( drf_get_settings($value['id']) !== false) {
                        echo get_settings($value['id']);
                    }else{
                        echo $value['std'];
                }?></textarea>
        <?php
        drf_option_wrapper_footer($value);
        break;

        case "radio":
        drf_option_wrapper_header($value);
       
        foreach ($value['options'] as $key=>$option) {
                $radio_setting = drf_get_settings($value['id']);
                if($radio_setting != ''){
                    if ($key == drf_get_settings($value['id']) ) {
                        $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                }else{
                    if($key == $value['std']){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                }?>
                <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
        <?php
        }
        
        drf_option_wrapper_footer($value);
        break;
       
        case "checkbox":
        drf_option_wrapper_header($value);
                        if(drf_get_settings($value['id'])){
                            $checked = "checked=\"checked\"";
                        }else{
                            $checked = "";
                        }
                    ?>
                    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        <?php
        drf_option_wrapper_footer($value);
        break;

        case "multicheck":
        drf_option_wrapper_header($value);
       
        foreach ($value['options'] as $key=>$option) {
                 $pn_key = $value['id'] . '_' . $key;
                $checkbox_setting = drf_get_settings($pn_key);
                if($checkbox_setting != ''){
                    if (drf_get_settings($pn_key) ) {
                        $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                }else{
                    if($key == $value['std']){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                }?>
                <input type="checkbox" name="<?php echo $pn_key; ?>" id="<?php echo $pn_key; ?>" value="true" <?php echo $checked; ?> /><label for="<?php echo $pn_key; ?>"><?php echo $option; ?></label><br />
        <?php
        }
        
        drf_option_wrapper_footer($value);
        break;
       
        case "heading":
        ?>
        <tr valign="top">
            <td colspan="2" style="text-align: left;"><h3><?php echo $value['name']; ?></h3></td>
        </tr>
        <?php
        break;
       
        default:

        break;
    }
}
?>

		</table>

		<p class="submit">
			<input name="save" type="submit" value="Save changes" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>
</div>
<?php
}

function drf_option_wrapper_header($values){
    ?>
    <tr valign="top">
        <th scope="row" style="width:1%;white-space: nowrap;"><?php echo $values['name']; ?>:</th>
        <td>
    <?php
}

function drf_option_wrapper_footer($values){
    ?>
        </td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td><td><small><?php echo $values['desc']; ?></small></td>
    </tr>
    <?php
}

add_action('admin_menu', 'drf_styles_add_admin'); 

?>