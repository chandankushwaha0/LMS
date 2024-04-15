<?php
include_once("config.php");
include_once("./DataValidator.php");

if (isset($_POST['add'])) {
    $error_msg = array();
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $student_id = isset($_POST['student_id']) ? $dataValidator->validateData($_POST['student_id']) : '';
    $faculty = isset($_POST['faculty']) ? $dataValidator->validateData($_POST['faculty']) : '';
    $semester = isset($_POST['semester']) ? $dataValidator->validateData($_POST['semester']) : ''; // Check if semester is set
    $email = isset($_POST['email']) ? $dataValidator->validateEmail($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $name = isset($_POST['name']) ? $dataValidator->validateData($_POST['name']) : '';

    // Check if any field is empty
    if (empty($student_id) || empty($faculty) || empty($semester) || empty($email) || empty($phone) || empty($name)) {
        $error_msg[] = "<div class='text-danger'>Please fill in all the required fields.</div>";
    } else {
        $sql = "INSERT INTO all_student(student_id, faculty, semester, email, phone, name ) 
                VALUES ( '{$student_id}', '{$faculty}', '{$semester}', '{$email}', '{$phone}', '{$name}')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
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
                    <?php
                    foreach( $error_msg as $error ) {
                        ?>
                        messagePopupHandle(<?php echo $error; ?>);
                        <?php
                    }
                    ?>
                })
            </script>
<?php
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
<form action="" method="POST" onsubmit="return validateForm()">
    <?php 
        // Fetch the maximum student ID from the database
        $sql_max_student_id = "SELECT MAX(student_id) AS max_student_id FROM all_student";
        $result_max_student_id = mysqli_query($conn, $sql_max_student_id);
        $row_max_student_id = mysqli_fetch_assoc($result_max_student_id);
        $next_student_id = $row_max_student_id['max_student_id'] + 1;
    ?>
    <div class="d-flex justify-content-between">
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID <span class="text-primary">(use this id for identify students)</span></label>
            <input name="student_id" value="<?php echo $next_student_id; ?>" type="text" readonly class="form-control" id="student_id" required>
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
    
    <div class="d-flex justify-content-between">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number <span>*</span></label>
            <input name="phone" type="number" class="form-control" id="phone" required>
        </div>
        <div class="mb-3 col-9">
            <label for="name" class="form-label">Name <span>*</span></label>
            <input name="name" type="text" class="form-control" id="name" required>
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
        <button class="btn btn-dark" name="add" type="submit">ADD</button>
    </div>
</form>

<script>
    function validateForm() {
        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].hasAttribute('required') && !inputs[i].value) {
                alert('Please fill in all required fields.');
                return false;
            }
        }
        return true;
    }
</script>

<?php
