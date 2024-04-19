<?php
// echo 'hello';
include_once ("./config.php");
include_once ("./DataValidator.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // echo $id;

    if (isset($_POST['update'])) {
        // Create a new instance of DataValidator
        $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

        // Validate and sanitize form data
        $university = $dataValidator->validateData($_POST['university']);
        $faculty = $dataValidator->validateData($_POST['faculty']);
        $program = $dataValidator->validateData($_POST['program']);
        $program = strtoupper( $program );

        // Update the database
        $sql = "UPDATE faculty SET affliated_university = '{$university}', faculty_name = '{$faculty}', program = '{$program}' WHERE faculty_id = $id";

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

    $sql1 = "SELECT * FROM faculty where faculty_id = $id";
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
                    <button class="btn btn-primary"><a href="dashboard.php?item=faculty" class="text-light text-decoration-none">Go Back</a></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Affliated University</label></br>
                            <input type="text" class="w-100" name="university" value="<?php echo $rows1['affliated_university']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Faculty</label></br>
                            <input type="text" class="w-100" name="faculty" value="<?php echo $rows1['faculty_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Program</label></br>
                            <input type="text" class="w-100" name="program" value="<?php echo $rows1['program']; ?>">
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
