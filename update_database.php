<?php
// Fetch subject list data sent from JavaScript
$subjectList = json_decode(file_get_contents('php://input'), true);

// Format the subject list data as an array for input fields
$inputFields = '<input type="hidden" name="subjects[]" value="' . implode('" /><input type="hidden" name="subjects[]" value="', $subjectList) . '" />';

// Send the formatted subject list data back to JavaScript
echo $inputFields;
?>
