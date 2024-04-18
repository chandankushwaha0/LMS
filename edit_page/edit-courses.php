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

        
        $semester = isset($_POST['semester']) ? $dataValidator->validateData($_POST['semester']) : '';
        
        // Combine all subjects into a comma-separated string
        $subjectArray = isset($_POST['subject']) ? $_POST['subject'] : [];
        $subject = implode(",", $subjectArray);

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
                    <button class="btn btn-primary"><a href="dashboard.php?item=courses" class="text-light text-decoration-none">Go Back</a></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <label for="chapter" class="form-label">Choose Faculty</label>
                            <select name="faculty" id="faculty" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Faculty</option>
                <!-- Populate options dynamically using PHP -->
                <?php
                // Assuming $conn is your database connection
                $sql3 = "SELECT faculty_name FROM faculty";
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        ?>
                        <option <?php  echo ( $row3['faculty_name'] ) == $rows1['faculty'] ? 'selected' : ''; ?> value="<?php echo $row3['faculty_name'] ?>"><?php echo $row3['faculty_name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
                        </div>
                        <div>
            <label for="semester" class="form-label">Choose Semester <span class="text-primary">(If no semester then
                    leave blank)</span></label>
            <select name="semester" id="semester" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Semester</option>
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



<script>
    // for fetch semester related to faculty

    // Add event listener to the faculty select element
    document.getElementById("faculty").addEventListener("change", function () {
        // Get the selected faculty value
        var faculty = this.value;

        // Get the semester select element
        var semesterSelect = document.getElementById("semester");

        // Clear existing options
        semesterSelect.innerHTML = '<option selected disabled>Select Semester</option>';

        // Make an AJAX request to fetch related semesters
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the response as JSON
                    var semesterData = JSON.parse(xhr.responseText);

                    // Check if semesterData is an array
                    if (Array.isArray(semesterData)) {
                        // Iterate over each semester in the array
                        semesterData.forEach(function (semester) {
                            // Trim any leading or trailing whitespace
                            var trimmedSemester = semester.trim();

                            // Split the semester data into individual years
                            var years = trimmedSemester.split(',');

                            // Iterate over each year and create an option element for it
                            years.forEach(function (year) {
                                var trimmedYear = year.trim();

                                // Create an option element
                                var option = document.createElement("option");

                                // Set the value and text content of the option
                                option.value = trimmedYear;
                                option.textContent = trimmedYear;

                                // Append the option to the select element
                                semesterSelect.appendChild(option);
                            });
                        });
                    } else {
                        console.error('Semester data is not in the expected format');
                    }
                } else {
                    console.error('Error fetching semesters');
                }
            }
        };
        // Replace "get_semesters.php" with the path to your server-side script
        xhr.open("GET", "pages/get_semesters.php?faculty=" + encodeURIComponent(faculty), true);
        xhr.send();
    });
</script>
