<?php 

/**
 * Function to sanitize included file names
 *
 * @param string
 * @return string
 */
function sanitize_filename($filename) {
    // Whitelist of allowed file names
    $allowed_filenames = array("header.php", "menu.php", "content.php", "footer.php", "config.php", "index.php");
    
    // Check if the given filename is in the allowed list
    if (in_array($filename, $allowed_filenames)) {
        // Return the sanitized filename
        return $filename;
    } else {
        // Returning an empty string here
        return "";
    }
}



/**
 * Sanitize the URL in proper formate
 *
 * @param string
 * @return string
 */
function sanitize_url($input) {
    // Remove any non-alphanumeric characters, hyphens, and underscores
    $sanitized_input = preg_replace("/[^a-zA-Z0-9-_]/", "", $input);
    return $sanitized_input;
}



