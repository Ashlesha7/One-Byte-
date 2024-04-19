<?php 
	
	// Function to escape HTML entities in a string
	function excape($string) {
		// Check if the POST variable exists, then escape it, otherwise return an empty string
		echo isset($_POST[$string]) ? htmlentities($_POST[$string],  ENT_QUOTES, 'UTF-8') : "";
	}
	
	// Function to escape and trim a string
	function escape($string) {
		// Escape HTML entities and trim the string, then return the result
		return htmlentities(trim($string), ENT_QUOTES, 'UTF-8');
	}
	
	// Function to generate HTML options for a select element based on a range of values
	function generate_option($lower_limit, $upper_limit) {
		// Initialize an empty string to store the options
		$option = "";
		
		// Loop through the range of values and create an option for each value
		for($i = (int)$lower_limit; $i <= (int)$upper_limit; $i++) {
			// Append the option HTML to the $option string
			$option .= "<option value='".$i."'>$i</option>";
		}
		
		// Return the generated options
		return $option;
	}
	
	// Function to render options for a select element with a specified quantity and ID
	function render_options($qty, $id) {
		// Initialize an empty string to store the options
		$option = "";
		
		// Loop through a range of values (1 to 50) and create an option for each value
		for($x = 1; $x <= 50; $x++) {
			// Check if the current value matches the specified quantity, then set the option as selected
			if($x == $qty) {
				$option .= "<option value='".$x."_".$id."' selected>$x</option>";
			} else {
				$option .= "<option value='".$x."_".$id."'>$x</option>";
			}
		}
		
		// Return the rendered options
		return $option;
	}
	
?>
