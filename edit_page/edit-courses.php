<?php
// echo 'hello';
include_once ("./config.php");
include_once ("./DataValidator.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['update'])) {
        // Create a new instance of DataValidator
        $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

        // Validate and sanitize form data
        $faculty = $dataValidator->validateData($_POST['faculty']);
        $semester = $dataValidator->validateData($_POST['semester']);
        
        // Combine all subjects into a comma-separated string
        $subjectArray = isset($_POST['subject']) ? $_POST['subject'] : [];
        $subject = implode(",", $subjectArray);

        echo $subject;

        // Update the database
        $sql = "UPDATE courses SET faculty = '{$faculty}', semester = '{$semester}', subject = '{$subject}' WHERE course_id = $id";

        if (mysqli_query($conn, $sql)) {
            ?>
            <script>
                window.addEventListener("load", function () {
                    messagePopupHandle("Update Successfully!!!");
                })
            </script>
            <?php
        } else {
            ?>
            <script>
                window.addEventListener("load", function () {
                    messagePopupHandle("Update Failed!!");
                })
            </script>
            <?php
        }
    }

    $sql1 = "SELECT * FROM courses where course_id = $id";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        ?>
        <div class="edit-form">
            <?php
            while ($rows1 = mysqli_fetch_assoc($result1)) {
                ?>
                <style>
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
                <div class="go-back">
                    <button class="btn btn-primary"><a href="dashboard.php?item=all-teachers" class="text-light text-decoration-none">Go Back</a></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Choose Faculty</label>
                            <select name="faculty" class="form-select" aria-label="Default select example">
                                <option disabled selected>Select Faculty</option>
                                <option value="BCA">BCA</option>
                                <option value="BHM">BHM</option>
                                <option value="MBA">MBA</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Choose Semester </label>
                            <select name="semester" class="form-select" aria-label="Default select example">
                                <option selected disabled>Select Semester</option>
                                <option value="<?php echo  $rows1['semester']; ?>"><?php echo  $rows1['semester']; ?></option>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="chapter" class="form-label">Subjects</label><br>
                            <?php
                                function convert_string_to_array($str) {
                                    $dataArray = explode(",", $str);
                                    $result = "";
                                    foreach ($dataArray as $key => $value) {
                                        $result .= "<input type='text' name='subject[]' value='$value'><br>";
                                    }
                                    return $result;
                                }

                                echo convert_string_to_array($rows1['subject']);
                            ?>
                        </div>
                    </div>
                    <div class="d-grid gap-2 my-3">
                        <button class="btn btn-dark" name="update" type="submit">Update</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    <?php }
} ?>
