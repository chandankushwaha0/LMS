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
        $faculty = $dataValidator->validateData($_POST['faculty']);
        
        // Combine all subjects into a comma-separated string
        $semesterArray = isset($_POST['semester']) ? $_POST['semester'] : [];
        $semester = implode(",", $semesterArray);

        // Update the database
        $sql = "UPDATE all_semester SET faculty = '{$faculty}', semester = '{$semester}' WHERE semester_id = $id";

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

    $sql1 = "SELECT * FROM all_semester where semester_id = $id";
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
                    <button class="btn btn-primary"><a href="dashboard.php?item=semester" class="text-light text-decoration-none">Go Back</a></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Choose Faculty</label>
                            <select name="faculty" class="form-select" aria-label="Default select example">
                                <option disabled selected>Select Faculty</option>
                                <?php
                                $sql2 = "SELECT faculty_name FROM faculty";
                                $result2 = mysqli_query( $conn, $sql2);
                                if( mysqli_num_rows( $result2 ) > 0  )  {
                                    while( $row2  = mysqli_fetch_assoc( $result2 ) ) {
                                        ?>
                                        <option class="text-uppercase" value="<?php echo $row2['faculty_name']; ?>"  <?php echo ($rows1['faculty'] ) == $row2['faculty_name'] ? 'selected' : '' ?>><?php echo $row2['faculty_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="chapter" class="form-label">Subjects</label><br>
                            <?php
                                function convert_string_to_array($str) {
                                    $dataArray = explode(",", $str);
                                    $result = "";
                                    foreach ($dataArray as $key => $value) {
                                        $result .= "<input type='text' name='semester[]' value='$value'><br>";
                                    }
                                    return $result;
                                }

                                echo convert_string_to_array($rows1['semester']);
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
