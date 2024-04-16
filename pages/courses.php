<?php
include_once ("config.php");
include_once ("./DataValidator.php");

if (isset($_POST['add'])) {
    $error_msg = array();
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $faculty = isset($_POST['faculty']) ? $dataValidator->validateData($_POST['faculty']) : '';
    $semester = isset($_POST['semester']) ? $dataValidator->validateData($_POST['faculty']) : '';
    $subjects = isset($_POST['subjects']) ? $dataValidator->validateData($_POST['subjects']) : ''; 

    
        $sql = "INSERT INTO courses(faculty, semester, subject ) 
                VALUES ( '{$faculty}', '{$semester}', '{$subjects}')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            ?>
            <script>
                window.addEventListener('load', function () {
                    messagePopupHandle('Courses Added Successfully');
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
                <option value="One">One</option>
                <option value="Two">Two</option>
                <option value="Three">Three</option>
                <option value="Four">Four</option>
            </select>
        </div>
        <div>
            <label for="chapter" class="form-label">Choose Semester<span class="text-primary">(If no semseter then leave
                    blank)</span></label>
            <select name="semester" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Semester</option>
                <option value="One">One</option>
                <option value="Two">Two</option>
                <option value="Three">Three</option>
                <option value="Four">Four</option>
                <option value="Five">Five</option>
                <option value="Six">Six</option>
                <option value="Seven">Seven</option>
                <option value="Eight">Eight</option>
            </select>
        </div>
        <div class="mb-3">
            <div class="mb-3 ">
                <label for="subject" class="form-label">Subject Name <span>*</span></label>
                <input name="subject" type="text" class="form-control" id="subjectInput">
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class=" col-6 ">
            <!-- Input field to store subjects -->
            <input type="hidden" name="subjects" id="subjectsInput">
            <label for="subjectsInput">List of Subjects</label>
            <div id="subjectListContainer"></div> <!-- Container for subject list -->
        </div>
    </div>
        <div class="d-grid gap-2 my-3">
            <button class="btn btn-dark" name="add" type="submit">ADD</button>
        </div>
</form>


<style>

    td {
        font-size: 16px;
    }

    td p {
        padding-top: 15px;
    }

    td button a {
        text-decoration: none;
    }
</style>


<div class="search-box py-3">
    <input type="text" onkeyup="searchByName()" class="p-2 searchName" placeholder="search by Name...">
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

$sql1 = "SELECT * FROM courses LIMIT {$offsets}, {$limit}";

$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) > 0) {



    ?>
<div class="table-headin text-left  text-dark">
    <h3 class="text-bold">Courses List</h3>
</div>
    <table id="smsTable" class="table table-striped table-hover">
        <tr>
            <th>Faculty</th>
            <th>Semester</th>
            <th>Subjects</th>


        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result1)) {
            ?>
            <tr class="fs-5">
                <td>
                    <p><?php echo $row['faculty']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['semester']; ?></p>
                </td>
                <td>
                    <?php
                    $sub = $row['subject'];
                    $sub_array = explode(",", $sub );
                    $result = "";
                    foreach( $sub_array as  $number => $subject ) {
                        $result .= " " . " ". ( $number + 1 ).".". $subject ."</br>" ;
                    }
                    $result  = rtrim( $result , ", ");
                    ?>
                    <p><?php echo $result; ?></p>
                </td>
                <td class="">
                    <button class="edit-btn btn btn-primary mt-2">
                        <a href="./dashboard.php?item=edit-courses&id=<?php echo $row['course_id']; ?>"
                            class="text-light">Edit</a>
                    </button>
                    <button class="edit-btn btn btn-danger mt-2 delete-btn">
                        <a href="./dashboard.php?item=delete-courses&id=<?php echo $row['course_id']; ?>"
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

        $sql2 = "SELECT * FROM courses";

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
                            href="http://localhost/lms/dashboard.php?item=all-teachers&&page= <?php echo $page - 1; ?>">Prev</a>
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
                            href="http://localhost/lms/dashboard.php?item=all-teachers&&page= <?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php
                }
                if ($total_pages > $page) {
                    ?>
                    <li class="page-item"><a class="page-link"
                            href="http://localhost/lms/dashboard.php?item=all-teachers&&page= <?php echo $page + 1; ?>">Next</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>


<!-- Confirmation Popup -->
<div id="confirmation-modal" class="modal">
    <div class="modal-content">
        <button class="conf-btn checkbtn"><i class="fa-solid fa-check"></i></button>
        <h5 id="message" class="py-3 message text-danger">Are you sure you want to delete?</h5>
        <div class="d-grid gap-2 my-3">
            <button class="conf-btn popupYes" id="popupYes">Yes</button>
            <button class="conf-btn popupNo" id="popupNo">No</button>
        </div>
    </div>
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
