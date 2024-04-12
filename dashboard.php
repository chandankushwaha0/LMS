<?php

include_once("functions.php");

include_once("includes/header.php");
?>

<div class="content-and-menu d-flex">
    <div class="menu">
        <?php include_once("includes/menu.php"); ?>
    </div>

    <div class="content">
        <?php include_once(sanitize_filename("content.php")); ?>
    </div>
</div>

<?php
include_once("includes/footer.php");
?>
