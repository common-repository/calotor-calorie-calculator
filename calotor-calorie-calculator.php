<?php
/*
Plugin Name: Calotor Calorie Counter
Plugin URI: http://www.calotor.com
Description: Figure out your basal metabolic rate
Author: Lucian Apostol
Version: 1.4
Author URI: http://www.calotor.com
*/

function calotor() 
{
  $return = '
	<script type="text/javascript">
		function mod(div,base) {
				return Math.round(div - (Math.floor(div/base)*base));
		}


		function bmr_calculator(formhandler)  {
			
			var w = formhandler.bmr_weight.value * 1;
			var a = formhandler.bmr_age.value * 1;

			displaybmr = (Math.round( (10 * w * 0.4535 ) + ( 5 * 180 ) - ( 5 * a )  + 66.5       ));
			var rvalue = true;
			if ( (w <= 35) || (w >= 500)  || (a <= 1) || (a >= 120) ) {
				document.getElementById("bmr_result").innerHTML = "Invalid data";
				rvalue = false;
				return false;
			}
			if (rvalue) {
					document.getElementById("bmr_result").innerHTML = "You should eat " + displaybmr + " calories a day";
			}


			return false;
		}
	</script> 

	<form id="calotorform" onsubmit="return bmr_calculator(this);" method="post">
		Weight: <input type="text" name="bmr_weight" id="bmi_weight" size="9"; /> lbs.<br />
		Age: <input type="text" name="bmr_age" id="bmr_age" size="9"; /> years <br />
		<br><input type="submit" name="submit" id="submit" value="Calculate" /><br />
		<div id="bmr_result"></div>
	</form>

 		';
 		return $return;
}

function widgetCalotor($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>How many calories you should eat a day.<?php echo $after_title;
  echo calotor();
  echo $after_widget;
}

function calotor_shortcode() {
	return calotor();	
}

function calotorInit()
{
  wp_register_sidebar_widget('calotor_bmr',__('Calotor Base Metabolic Rate'), 'widgetCalotor');     
  add_shortcode( 'calotor', 'calotor_shortcode' );
}
add_action("plugins_loaded", "calotorInit");



function calotor_create_menu_page(){
	add_menu_page( 
		__( 'Calotor', 'calotor' ),
		'Calotor',
		'manage_options',
		'calotoradmin',
		'calotor_admin_menu_page',
		'dashicons-drumstick',
		null
	); 
}
add_action( 'admin_menu', 'calotor_create_menu_page' );

function calotor_admin_menu_page(){
	echo '<h2>';
	esc_html_e( 'Calotor Calorie Counter', 'calotor' );	
	echo '</h2>';
	echo '<br /><br />';
	esc_html_e( 'To add the Calorie Counter, you can either use shrotcode [calotor], or you can use the Calotor widget from Appearance -> Widgets', 'calotor' );	
}


?>