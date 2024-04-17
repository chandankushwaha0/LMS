<?php
include_once ("config.php");
include_once ("./DataValidator.php");

if (isset($_POST['add'])) {
    $error_msg = array();
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $faculty = isset($_POST['faculty']) ? $dataValidator->validateData($_POST['faculty']) : '';
    $semester = isset($_POST['semesters']) ? $dataValidator->validateData($_POST['semesters']) : '';

    
        $sql = "INSERT INTO all_semester(faculty, semester ) 
                VALUES ( '{$faculty}', '{$semester}')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            ?>
            <script>
                window.addEventListener('load', function () {
                    messagePopupHandle('Semester Added Successfully');
                })
            </script>
            <?php
        } else {
        //     ?>
            <script>
                window.addEventListener('load', function () {
                    <?php
                    foreach ($error_msg as $error) {
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

?>



<style>
    /* Define styles for the textarea */
    .added-subject {
        background-color: #ECECEC;
        border-radius: 10px;
        color: #000;
        padding: 5px 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        display: inline-block;
    }

    .remove-button {
        font-size: 20px;
        cursor: pointer;
        color: red;
        margin-left: 5px;
        padding: 0px 5px;
        position: relative;
        right: 0;
        top: 0;
    }
    #subjectListContainer{
        background-color: #fff;
        padding: 10px;
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
    }

    .popup-content .checkbtn {
        margin-top: -60px;
        border-radius: 50%;
        padding: 7px 10px;
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
<div class="table-headin text-left  text-dark">
    <h3 class="text-bold">Add New Courses</h3>
</div>
<form action="" method="POST">


    <div class="d-flex justify-content-between">
        <div>
            <label for="chapter" class="form-label">Choose Faculty <span>*</span> </label>
            <select name="faculty" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Faculty</option>
                <?php
                $sqls = "SELECT faculty_name FROM faculty";
                $res = mysqli_query( $conn, $sqls );
                if( mysqli_num_rows( $res ) > 0 ) {
                    while( $rows2 = mysqli_fetch_assoc( $res ) ) {
                        ?>
                        <option value="<?php echo $rows2['faculty_name']; ?>"><?php echo $rows2['faculty_name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="mb-3 col-9">
            <div class="mb-3 ">
                <label for="subject" class="form-label">Semester <span>*</span><span class="text-primary">(Press Enter to add)</span></label>
                <input name="subject" type="text" class="form-control" id="subjectInput">
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class=" col-6 ">
            <!-- Input field to store subjects -->
            <input type="hidden" class="subjectsInput" name="semesters" id="subjectsInput">
            <label for="subjectsInput">List of Semesters</label>
            <div class="subjectListContainer" id="subjectListContainer"></div> <!-- Container for subject list -->
        </div>
    </div>
        <div class="d-grid gap-2 my-3">
            <button class="btn btn-dark" name="add" type="submit">ADD</button>
        </div>
</form>

<div class="search-box py-3">
    <input type="text" onkeyup="searchByName()" class="p-2 searchName" placeholder="search by semester...">
</div>

<?php
include ('config.php');

$limit = 10;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}


$offsets = ($page - 1) * $limit;

$sql1 = "SELECT * FROM all_semester LIMIT {$offsets}, {$limit}";

$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) > 0) {



    ?>
    <div class="table-headin text-left  text-dark">
        <h3 class="text-bold">Semester List</h3>
    </div>
    <table id="smsTable" class="table table-striped table-hover">
        <tr>
            <th>Faculty</th>
            <th>Semester</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result1)) {
            ?>
            <tr class="fs-5">
                <td>
                    <p><?php echo $row['faculty']; ?></p>
                </td>
                <td>
                    <?php
                    $sub = $row['semester'];
                    $sub_array = explode(",", $sub);
                    $result = "";
                    foreach ($sub_array as $number => $subject) {
                        $result .= " " . " " . ($number + 1) . "." . $subject . "</br>";
                    }
                    $result = rtrim($result, ", ");
                    ?>
                    <p><?php echo $result; ?></p>
                </td>
                <td class="">
                    <button class="edit-btn btn btn-primary mt-2">
                        <a href="./dashboard.php?item=edit-courses&id=<?php echo $row['semester_id']; ?>"
                            class="text-light">Edit</a>
                    </button>
                    <button class="edit-btn btn btn-danger mt-2 delete-btn">
                        <a href="./dashboard.php?item=delete-courses&id=<?php echo $row['semester_id']; ?>"
                            class="text-light">Delete</a>
                    </button>
                </td>
            </tr>
            <?php
        }
}

?>
</table>



<div class="pagination py-5 text-center">
    <nav aria-label="Page navigation example mx-auto">
        <?php

        $sql2 = "SELECT * FROM all_semester";

        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            $total_records = mysqli_num_rows($result2);

            $total_pages = ceil($total_records / $limit);
            ?>
            <ul class="pagination justify-content-center">

                <?php
                if ($page > 1) {
                    ?>
                    <li class="page-item"><a class="page-link"
                            href="http://localhost/lms/dashboard.php?item=semester&&page= <?php echo $page - 1; ?>">Prev</a>
                    </li>
                    <?php
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <li class="page-item <?php echo $active; ?>"><a class="page-link"
                            href="http://localhost/lms/dashboard.php?item=semester&&page= <?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php
                }
                if ($total_pages > $page) {
                    ?>
                    <li class="page-item"><a class="page-link"
                            href="http://localhost/lms/dashboard.php?item=semester&&page= <?php echo $page + 1; ?>">Next</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>
    </nav>
</div>
<!-- SCRIPT FOR ADD SUBJECT LIST -->
<script>

function updateSubjectsInput() {
    var subjects = document.getElementsByClassName("added-subject");
    var subjectValues = [];
    for (var i = 0; i < subjects.length; i++) {
        subjectValues.push(subjects[i].textContent.substr(subjects[i].textContent.indexOf(". ") + 2));
    }
    document.getElementById("subjectsInput").value = subjectValues.join(",");
}

function removeSubject(subjectElement) {
    // Remove event listener before removing the button
    var removeButton = subjectElement.querySelector('.remove-button');
    removeButton.removeEventListener('click', removeSubjectHandler);
    
    subjectElement.remove();
    updateSubjectsInput();
}

function removeSubjectHandler(event) {
    var subjectLine = event.target.parentElement;
    removeSubject(subjectLine);
}

document.getElementById("subjectInput").addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent form submission
        var subject = this.value.trim();
        if (subject !== "") {
            // Create a <span> element to wrap the added subject line
            var subjectLine = document.createElement("span");
            subjectLine.classList.add("added-subject"); // Add the 'added-subject' class
            subjectLine.textContent = subject;

            // Create a remove button
            var removeButton = document.createElement("span");
            removeButton.classList.add("remove-button");
            removeButton.textContent = "x";

            // Append the remove button to the subject line
            subjectLine.appendChild(removeButton);

            // Append the subject line to the subject list container
            document.getElementById("subjectListContainer").appendChild(subjectLine);

            // Update the subjects input field
            updateSubjectsInput();

            // Add event listener to dynamically created remove button
            removeButton.addEventListener('click', removeSubjectHandler);

            this.value = ""; // Clear the input field after adding the subject
        }
    }
});

// Add event listener to dynamically created remove buttons
document.getElementById("subjectListContainer").addEventListener("click", function (event) {
    if (event.target.classList.contains("remove-button")) {
        var subjectLine = event.target.parentElement;
        removeSubject(subjectLine);
    }
});
</script>
