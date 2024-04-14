<?php

include_once ("./includes/header.php");
include_once ("config.php");
include_once ("./DataValidator.php");

if (isset($_POST['save'])) {
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $name = $dataValidator->validateData($_POST['name']);
    $faculty = $dataValidator->validateData($_POST['faculty']);
    $subject = $dataValidator->validateData($_POST['subject']);
    $semester = $dataValidator->validateData($_POST['semester']);
    $gender = $dataValidator->validateData($_POST['gender']);
    $address = $dataValidator->validateData($_POST['address']);
    // $images = $dataValidator->$_POST['images'];
    $email = $dataValidator->validateEmail($_POST['email']);
    $phone = $dataValidator->validateData($_POST['phone']);

    // Upload image
$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["images"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["images"]["tmp_name"]);
if ($check === false) {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["images"]["size"] > 2000000) { // 2MB
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
$allowedExtensions = array("jpg", "jpeg", "png", "gif");
if (!in_array($imageFileType, $allowedExtensions)) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // if everything is ok, try to upload file
    if (move_uploaded_file($_FILES["images"]["tmp_name"], $targetFile)) {
        // Insert data into database
        $sql = "INSERT INTO teachers (name, faculty, subject, semester, email, phone, gender, address, images)
                VALUES ('{$name}', '{$faculty}', '{$subject}', '{$semester}', '{$email}', '{$phone}', '{$gender}', '{$address}', '{$targetFile}' )";

// echo $sql;
        if (mysqli_query($conn, $sql)) {
            ?>
            <script>
                window.addEventListener("load", function() {
                    messagePopupHandle("Register Successfully!!!");
                })
            </script>
            <?php
        } else {
            ?>
            <script>
                window.addEventListener("load", function() {
                    messagePopupHandle("Register Failed!!");
                })
            </script>
            <?php
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
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

    .popup-content .checkbtn {
        margin-top: -60px;
        border-radius: 50%;
        padding: 10px 18px;
        font-size: 30px;
        color: #fff;
    }

    .image-container {
        border: 2px solid #ccc;
        padding: 10px;
        width: 200px;
        height: 200px;
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-name {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px;
        text-align: center;
    }
</style>

<div class="popup d-none ">
    <div class="popup-content">
        <button class="btn checkbtn"><i class="fa-solid fa-check"></i></button>
        <h1 id="thankyou" class="text-dark">Thank You!</h1>
        <h5 id="message" class="py-3 message"></h5>
        <div class="d-grid gap-2 my-3">
            <button class="btn popupOk" id="popupOk" name="" type="">OK</button>
        </div>


    </div>
</div>


</style>

<form action="" method="POST" enctype="multipart/form-data">
    <?php
    ?>
    <div class="mb-3 ">
        <label for="name" class="form-label">Name <span>*</span></label>
        <input name="name" type="text" class="form-control" id="name" required>
    </div>
    <div class="d-flex justify-content-between">
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
            <label for="chapter" class="form-label">Choose Subject <span>*</span> </label>
            <select name="subject" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Subject</option>
                <option value="science">science</option>
                <option value="math">math</option>
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
        <div class="mb-3 col-4">
            <label for="email" class="form-label">Email <span>*</span></label>
            <input name="email" type="text" class="form-control" id="email" required>
        </div>
    </div>


    <div class="d-flex py-4 justify-content-between">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number <span>*</span></label>
            <input name="phone" type="number" class="form-control" id="phone" required>
        </div>

        <div class="mb-3">
            <lable>Gender *</lable><br>
            <input value="male" type="radio" name="gender" id="">Male
            <input value="female" type="radio" name="gender" id="">Female
            <input value="others" type="radio" name="gender" id="">Others
        </div>
        <div class="form-floating col-6">
            <textarea name="address" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                style="height: 200px"></textarea>
            <label for="floatingTextarea2">Address</label>
        </div>
    </div>
    <div class="d-flex">
    <div class="col-4">
        <div data-mdb-input-init class="form-outline form-white">
            <!-- Modified file input to trigger onchange event -->
            <input type="file" name="images" id="img" class="form-control form-control-lg"
                onchange="previewImage(event)" />
            <label class="form-label" for="img">Upload Image</label>
        </div>
    </div>
    <!-- Container for displaying uploaded image -->
    <div id="imagePreview" class="image-container ms-5">
        <!-- Initially hidden, shown when an image is selected -->
        <img id="preview" src="#" alt="Uploaded Image" style="display:none;">
        <div id="imageName" class="image-name">Image Name</div>
    </div>
    </div>
    <div class="d-grid gap-2 my-3">
        <button class="btn btn-dark" name="save" type="submit">ADD</button>
    </div>
</form>
