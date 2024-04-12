<?php

include_once ("./includes/header.php");
include_once ("config.php");
include_once ("DataValidator.php");

if (isset($_POST['register'])) {
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $fname = $dataValidator->validateData($_POST['fname']);
    $lname = $dataValidator->validateData($_POST['lname']);
    $faculty = $dataValidator->validateData($_POST['faculty']);
    $semester = $dataValidator->validateData($_POST['semester']);
    $gender = $dataValidator->validateData($_POST['gender']);
    $address = $dataValidator->validateData($_POST['address']);
    $password = $dataValidator->validatePassword($_POST['password'], $_POST['con_password']);
    $email = $dataValidator->validateEmail($_POST['email']);
    $phone = $dataValidator->validatePhoneNumber($_POST['phone']);

    // Upload image
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["img"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (!move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert data into database if image was successfully uploaded
    if ($uploadOk) {
        // Insert data into database
        $sql = "INSERT INTO register_users (fname, lname, faculty, semester, gender, images, phone, address, email, password)
                VALUES ('$fname', '$lname', '$faculty', '$semester', '$gender', '$targetFile', '$phone', '$address', '$email', '$password')";

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
                    messagePopupHandle("<div class='text-danger'>Register Failed!!!</div>");
                })
            </script>
            <?php
        }
    }
}


?>

<style>
    .card-registration .select-input.form-control[readonly]:not([disabled]) {
        font-size: 1rem;
        line-height: 2.15;
        padding-left: .75em;
        padding-right: .75em;
    }

    .card-registration .select-arrow {
        top: 13px;
    }

    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #a1c4fd;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
    }

    .bg-indigo {
        background-color: #4835d4;
    }

    @media (min-width: 992px) {
        .card-registration-2 .bg-indigo {
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }
    }

    @media (max-width: 991px) {
        .card-registration-2 .bg-indigo {
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
    }

    .password {
        position: relative;
    }

    i {
        position: absolute;
        right: 19px;
        top: 40px;
        color: #000;

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

    span {
        color: #870000;
        font-size: 17px;
        font-weight: 800;
        padding-left: 3px;
    }

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
        color: #fff;
    }
    .checkbtn i{
        position: inherit;
        color: #fff;
    }
    .popup-content .checkbtn{
        margin-top: -60px;
        border-radius: 50%;
        padding: 10px 18px;
        font-size: 30px;
        color: #fff;
    }

    button a {
        color: #000;
        text-decoration: none;
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
<section class="h-100 h-custom gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <h3 class="fw-normal mb-5" style="color: #4835d4;">General Infomation</h3>

                                        <div class="row">
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <input type="text" required name="fname" id="form3Examplev2"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="form3Examplev2">First
                                                        name<span>*</span></label>
                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <input type="text" required name="lname" id="form3Examplev3"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="form3Examplev3">Last
                                                        name<span>*</span></label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label for="Faculty">Faculty<span>*</span></label>
                                                    <select required id="faculty" name="faculty" class="select">
                                                        <option value="BCA">BCA</option>
                                                        <option value="BBA">BBA</option>
                                                        <option value="BHM">BHM</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-4 pb-2">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label for="semester">Semester<span>*</span></label>
                                                    <select required name="semester" id="semester" class="select">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <label class="form-label" for="form3Examplev3">Gender<span>*</span></label>
                                        <div class="form-check">
                                            <input class="form-check-input" value="female" type="radio" required
                                                name="gender" id="femae">
                                            <label class="form-check-label" for="femae">
                                                Female
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" required type="radio" value="male"
                                                name="gender" id="male">
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" required type="radio" value="others"
                                                name="gender" id="others">
                                            <label class="form-check-label" for="others">
                                                Others
                                            </label>
                                        </div>

                                        <div class="mb-4 pt-4">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <!-- Modified file input to trigger onchange event -->
                                                <input type="file" name="img" id="img"
                                                    class="form-control form-control-lg"
                                                    onchange="previewImage(event)" />
                                                <label class="form-label" for="img">Upload Image</label>
                                            </div>
                                        </div>
                                        <!-- Container for displaying uploaded image -->
                                        <div id="imagePreview" class="image-container">
                                            <!-- Initially hidden, shown when an image is selected -->
                                            <img id="preview" src="#" alt="Uploaded Image" style="display:none;">
                                            <div id="imageName" class="image-name">Image Name</div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-6 bg-indigo text-white">
                                    <div class="p-5">
                                        <h3 class="fw-normal mb-5">Contact Details</h3>

                                        <div class="mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <input name="phone" type="number" id="phone" required
                                                    class="form-control form-control-lg" />
                                                <label class="form-label" for="phone">Phone Number<span>*</span></label>
                                            </div>
                                        </div>

                                        <div class="mb-4 pb-2">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <input name="address" type="text" id="address" required
                                                    class="form-control form-control-lg" />
                                                <label class="form-label" for="address">Address<span>*</span></label>
                                            </div>
                                        </div>


                                        <div class="mb-4">
                                            <div data-mdb-input-init class="form-outline form-white">
                                                <input name="email" required type="email" id="form3Examplea9"
                                                    class="form-control form-control-lg" />
                                                <label class="form-label" for="form3Examplea9">Your
                                                    Email<span>*</span></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4 pb-2 password">

                                                <div data-mdb-input-init class="form-outline">
                                                    <p>
                                                        <label>Password<span>*</span></label>
                                                        <input type="password" required
                                                            class="form-control form-control-lg" name="password"
                                                            id="password" />
                                                        <i class="fa-solid fa-eye" id="togglePassword"></i>
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-4 pb-2 password">

                                                <div data-mdb-input-init class="form-outline">
                                                    <p>
                                                        <label>Confirm Password<span>*</span></label>
                                                        <input type="password" required
                                                            class="form-control form-control-lg" name="con_password"
                                                            id="new_password" />
                                                        <i class="fa-solid fa-eye" id="togglePassword2"></i>
                                                    </p>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-check d-flex justify-content-start mb-4 pb-3">
                                            <input class="form-check-input me-3" required type="checkbox" value=""
                                                id="form2Example3c" />
                                            <label class="form-check-label text-white" for="form2Example3">
                                                I do accept the <a href="#!" class="text-white"><u>Terms and
                                                        Conditions</u></a> of your
                                                site.
                                            </label>
                                        </div>

                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-light btn-lg" name="register"
                                            data-mdb-ripple-color="dark">Register</button>
                                        
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-light btn-lg" name="signin"
                                            data-mdb-ripple-color="dark"><a href="index.php">Sign In</a></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>




</script>

<?php include_once ("./includes/footer.php"); ?>

