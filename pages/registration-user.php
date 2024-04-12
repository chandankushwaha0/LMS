<?php
include_once("config.php");

include_once("./DataValidator.php");

if(isset($_POST['add'])) {
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $student_id = $dataValidator->validateData($_POST['student_id']);
    $faculty = $dataValidator->validateData($_POST['faculty']);
    $semester = $dataValidator->validateData($_POST['semester']);
    $email = $dataValidator->validateEmail($_POST['email']);
    $name = $dataValidator->validateData($_POST['name']);

    $sql = "INSERT INTO all_student(student_id, faculty, semester, email, name ) 
            VALUES ( '{$student_id}', '{$fname}', '{$faculty}', '{$semester}', '{$email}', '{$name}')";

    $result = mysqli_query($conn, $sql);

    if($result) {
        ?>
        <script>
            window.addEventListener('load', function() {
                messagePopupHandle('Added Successfully');
            })
        </script>
        <?php
    } else {
        ?>
        <script>
            window.addEventListener('load', function() {
                messagePopupHandle('Added Failed!!!');
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
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID <span class="text-primary">(use this id for identify students)</span></label>
            <input name="student_id" value="1" type="text" readonly class="form-control" id="student_id" required>
        </div>
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
            <label for="email" class="form-label">Email <span>*</span></label>
            <input name="email" type="text" class="form-control" id="email" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name <span>*</span></label>
        <input name="name" type="text" class="form-control" id="name" required>
    </div>
    <div class="d-grid gap-2 my-3">
        <button class="btn btn-dark" name="add" type="submit">ADD</button>
    </div>
</form>

<?php 
