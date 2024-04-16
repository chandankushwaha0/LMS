<?php
include_once("config.php");

if(isset($_POST['add'])) {
    if(isset($_POST['email'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
    }

    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $sub_name = mysqli_real_escape_string($conn, $_POST['sub_name']);
    $chapter = mysqli_real_escape_string($conn, $_POST['chapter']);
    $heading = mysqli_real_escape_string($conn, $_POST['heading']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "INSERT INTO task(email, faculty, semester, sub_name, chapter_no, heading, content) 
            VALUES ('{$email}', '{$faculty}', '{$semester}', '{$sub_name}', '{$chapter}', '{$heading}', '{$content}')";

    $result = mysqli_query($conn, $sql);

    if($result) {
        ?>
        <script>
            window.addEventListener('load', function() {
                messagePopupHandle('Your content added successfully!!!');
            })
        </script>
        <?php
    } else {
        ?>
        <script>
            window.addEventListener('load', function() {
                messagePopupHandle('Your content is not added!!!');
            })
        </script>
        <?php
    }
}
?>

<style>
    #thankyou {
        font-size: 25px;
    }

    /* Styles for the popup */
    .popup {
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .popup-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%;
        text-align: center;
        border-radius: 30px;
    }

    .popup-content button {
        padding: 10px 20px;
        margin-top: 10px;
        cursor: pointer;
        background-color: #6ED649;
    }
    .popup-content .checkbtn{
        margin-top: -60px;
        border-radius: 50%;
        padding: 10px 18px;
        font-size: 30px;
        color: #fff;
    }
</style>

<div class="popup d-none ">
    <div class="popup-content">
        <button class="btn checkbtn"><i class="fa-solid fa-check"></i></button>
        <h1 id="thankyou" class="text-dark">Thank You!</h1>
        <h5 id="message"  class="py-3 message"></h5>
        <div class="d-grid gap-2 my-3">
            <button class="btn popupOk" id="popupOk" name="" type="">OK</button>
        </div>

        
    </div>
</div>
<form action="" method="POST">
    <div class="d-flex justify-content-between">
        <input type="email" hidden value="" name="email">
        <div class="mb-3">
            <label for="chapter" class="form-label">Choose Faculty <span>*</span></label>
            <select name="faculty" class="form-select" aria-label="Default select example" required>
                <option disabled selected>Select Faculty</option>
                <option value="BCA">BCA</option>
                <option value="BHM">BHM</option>
                <option value="MBA">MBA</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="chapter" class="form-label">Choose Semester <span>*</span> </label>
            <select name="semester" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Semester</option>
                <option value="One">One</option>
                <option value="Two">Two</option>
                <option value="Three">Three</option>
                <option value="Four">Four</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="chapter" class="form-label">Choose Subject Name <span>*</span></label>
            <select name="sub_name" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Subject</option>
                <option value="English">English</option>
                <option value="Math">Math</option>
                <option value="Nepali">Nepali</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="chapter" class="form-label">Chapter No. <span>*</span></label>
            <input name="chapter" type="number" class="form-control" id="chapter" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="heading" class="form-label">Heading <span>*</span></label>
        <input name="heading" type="text" class="form-control" id="heading" required>
    </div>
    <div class="form-floating">
        <textarea name="content" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 300px"></textarea>
        <label for="floatingTextarea2">Comments</label>
    </div>
    <div class="d-grid gap-2 my-3">
        <button class="btn btn-dark" name="add" type="submit">ADD</button>
    </div>
</form>

<?php 



