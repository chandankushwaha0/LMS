<?php 

include_once("includes/header.php");

?>

<div class="login">
    <div class="login-form">
    <form>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Username</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 d-flex justify-content-between">
            <a href="">Forgot?</a>
            <a href="">Register new</a>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-dark" type="button">Sign in</button>
        </div>
        </form>
            </div>
        </div>

<?php
include_once("includes/footer.php");
?>
