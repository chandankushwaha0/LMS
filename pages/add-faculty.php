<?php
include_once ("config.php");
include_once ("./DataValidator.php");

if (isset($_POST['add'])) {
    $error_msg = array();
    // Create a new instance of DataValidator
    $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

    // Validate and sanitize form data
    $faculty = isset($_POST['faculty']) ? $dataValidator->validateData($_POST['faculty']) : '';
    $faculty = strtoupper( $faculty );
    
    $sql = "INSERT INTO faculty(faculty_name) 
                VALUES ( '{$faculty}')";

$result = mysqli_query($conn, $sql);

        if ($result) {
            ?>
            <script>
                window.addEventListener('load', function () {
                    messagePopupHandle('Faculty Added Successfully');
                })
            </script>
            <?php
        } else {  ?>
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
    <h3 class="text-bold">Add New Faculty</h3>
</div>
<form action="" method="POST">


    <div class="d-flex justify-content-between">
        <div class="mb-3 col-9">
            <div class="mb-3 ">
                <label for="subject" class="form-label">Faculty <span>*</span></label>
                <input name="faculty" type="text" class="form-control text-uppercase" id="subjectInput">
            </div>
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

$sql1 = "SELECT * FROM faculty LIMIT {$offsets}, {$limit}";

$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) > 0) {



    ?>
    <div class="table-headin text-left  text-dark">
        <h3 class="text-bold">Faculty List</h3>
    </div>
    <table id="smsTable" class="table table-striped table-hover">
        <tr>
            <th>S.N</th>
            <th>Faculty</th>
            <th>Actions</th>
        </tr>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result1)) {

            ?>
            <tr class="fs-5">
                <td><?php echo $i  ; ?></td>
                <td class="text-uppercase">
                    <?php echo $row['faculty_name']; ?>
                </td>
                <td class="">
                    <button class="edit-btn btn btn-primary mt-2">
                        <a href="./dashboard.php?item=edit-faculty&id=<?php echo $row['faculty_id']; ?>"
                            class="text-light">Edit</a>
                    </button>
                    <button class="edit-btn btn btn-danger mt-2 delete-btn">
                        <a href="./dashboard.php?item=delete-faculty&id=<?php echo $row['faculty_id']; ?>"
                            class="text-light">Delete</a>
                    </button>
                </td>
            </tr>
            <?php
            $i++;
        }
}

?>
</table>



<div class="pagination py-5 text-center">
    <nav aria-label="Page navigation example mx-auto">
        <?php

        $sql2 = "SELECT * FROM faculty";

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
                            href="http://localhost/lms/dashboard.php?item=faculty&&page= <?php echo $page - 1; ?>">Prev</a>
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
                            href="http://localhost/lms/dashboard.php?item=faculty&&page= <?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php
                }
                if ($total_pages > $page) {
                    ?>
                    <li class="page-item"><a class="page-link"
                            href="http://localhost/lms/dashboard.php?item=faculty&&page= <?php echo $page + 1; ?>">Next</a>
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


<!-- Confirmation Popup -->
<div id="confirmation-modal" class="modal">
    <div class="modal-content">
        <button class="conf-btn checkbtn"><i class="fa-solid fa-check"></i></button>
        <h5 id="message" class="py-3 message text-center text-danger">Are you sure you want to delete?</h5>
        <div class="d-grid gap-2 my-3">
            <button class="conf-btn btn-danger popupYes" id="popupYes">Yes</button>
            <button class="conf-btn popupNo" id="popupNo">No</button>
        </div>
    </div>
</div>
