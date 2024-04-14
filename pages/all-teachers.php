<style>
    .teacher-img img{
        width: 60px;
        border-radius: 50%;
        height: 60px;
    }
    td{
        font-size: 16px;
    }
    td p{
        padding-top: 15px;
    }
    td button a{
        text-decoration: none;
    }
</style>


<div class="search-box py-3">
    <input type="text" onkeyup="searchByName()" class="p-2 searchName" placeholder="search by Name...">
</div>

<?php
include('config.php');

$limit = 10;

if( isset( $_GET['page'] ) ) {
    $page = $_GET['page'];
} else {
    $page = 1;
}


$offsets = ( $page - 1 ) * $limit;

$sql = "SELECT * FROM teachers LIMIT {$offsets}, {$limit}";
// echo $sql;

$result = mysqli_query( $conn, $sql );

if( mysqli_num_rows( $result ) > 0 ) {



?>

<table id="smsTable" class="table table-striped table-hover">
    <tr>
        <th>Photos</th>
        <th>Name</th>
        <th>Faculty</th>
        <th>subject</th>
        <th>Semester</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Action</th>


    </tr>
    <?php
    while ( $row = mysqli_fetch_assoc($result ) ) {
    ?>
        <tr class="fs-5">
            <td class="teacher-img"><img src="<?php echo $row['images']; ?>" alt=""></td>
            <td><p><?php echo $row['name'] ; ?></p></td>
            <td><p><?php echo $row['faculty']; ?></p></td>
            <td><p><?php echo $row['subject']; ?></p></td>
            <td><p><?php echo $row['semester']; ?></p></td>
            <td><p><?php echo $row['email']; ?></p></td>
            <td><p><?php echo $row['phone']; ?></p></td>
            <td><p><?php echo $row['address']; ?></p></td>
            <td class="">
                <button class="btn btn-primary mt-2"><a href="" class="text-light">Edit</a></button>
                <button class="btn btn-danger ms-2"><a href="" class="text-light">Delete</a></button>
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

        $sql1 = "SELECT * FROM teachers";

        $result1 = mysqli_query( $conn, $sql1 );   

        if( mysqli_num_rows( $result1  ) > 0 ) {
            $total_records = mysqli_num_rows( $result1 );

            $total_pages = ceil( $total_records / $limit );
            ?>
            <ul class="pagination justify-content-center">
            
                <?php
                if( $page > 1 ) {
                    ?>
                    <li class="page-item"><a class="page-link" href="http://localhost/lms/dashboard.php?item=all-teachers&&page= <?php echo $page - 1 ; ?>">Prev</a></li>
                    <?php
                }
                for( $i = 1; $i <= $total_pages; $i++ ) {
                    if( $i == $page ) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <li class="page-item <?php echo $active; ?>"><a class="page-link" href="http://localhost/lms/dashboard.php?item=all-teachers&&page= <?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php
                }
                if( $total_pages > $page ) {
                    ?>
                    <li class="page-item"><a class="page-link" href="http://localhost/lms/dashboard.php?item=all-teachers&&page= <?php echo $page + 1 ; ?>">Next</a></li>
                    <?php
                }
                ?>
            </ul>
                <?php
        }
        ?>
        



        <!-- Edit teachers form -->

        <?php

// include_once ("./includes/header.php");
// include_once ("config.php");
// include_once ("./DataValidator.php");

// if (isset($_POST['save'])) {
//     // Create a new instance of DataValidator
//     $dataValidator = new yetilms\DataValidator($conn); // assuming $conn is your database connection

//     // Validate and sanitize form data
//     $name = $dataValidator->validateData($_POST['name']);
//     $faculty = $dataValidator->validateData($_POST['faculty']);
//     $subject = $dataValidator->validateData($_POST['subject']);
//     $semester = $dataValidator->validateData($_POST['semester']);
//     $gender = $dataValidator->validateData($_POST['gender']);
//     $address = $dataValidator->validateData($_POST['address']);
//     // $images = $dataValidator->$_POST['images'];
//     $email = $dataValidator->validateEmail($_POST['email']);
//     $phone = $dataValidator->validateData($_POST['phone']);

//     // Upload image
// $targetDir = "uploads/";
// $targetFile = $targetDir . basename($_FILES["images"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// // Check if image file is a actual image or fake image
// $check = getimagesize($_FILES["images"]["tmp_name"]);
// if ($check === false) {
//     echo "File is not an image.";
//     $uploadOk = 0;
// }

// // Check file size
// if ($_FILES["images"]["size"] > 2000000) { // 2MB
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }

// // Allow certain file formats
// $allowedExtensions = array("jpg", "jpeg", "png", "gif");
// if (!in_array($imageFileType, $allowedExtensions)) {
//     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//     echo "Sorry, your file was not uploaded.";
// } else {
//     // if everything is ok, try to upload file
//     if (move_uploaded_file($_FILES["images"]["tmp_name"], $targetFile)) {
//         // Insert data into database
//         $sql2 = "INSERT INTO teachers (name, faculty, subject, semester, email, phone, gender, address, images)
//                 VALUES ('{$name}', '{$faculty}', '{$subject}', '{$semester}', '{$email}', '{$phone}', '{$gender}', '{$address}', '{$targetFile}' )";

// // echo $sql2;
//         if (mysqli_query($conn, $sql2)) {
//             ?>
//             <script>
//                 window.addEventListener("load", function() {
//                     messagePopupHandle("Register Successfully!!!");
//                 })
//             </script>
//             <?php
//         } else {
//             ?>
//             <script>
//                 window.addEventListener("load", function() {
//                     messagePopupHandle("Register Failed!!");
//                 })
//             </script>
//             <?php
//         }
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }
// }
// }
?>

<?php 
            $sql2 = "SELECT * FROM teachers";
            $result2 = mysqli_query( $conn, $sql2 );

        if( mysqli_num_rows( $result ) > 0 ) {
        
        ?>
        <div class="edit-form">
        <?php
        while ( $rows2 = mysqli_fetch_assoc($result2 ) ) {
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3 ">
        <label for="name" class="form-label">Name</label>
        <input name="name" value="<?php echo $rows2['name']; ?>" type="text" class="form-control" id="name">
    </div>
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
            <label for="chapter" class="form-label">Choose Subject </label>
            <select name="subject" class="form-select" aria-label="Default select example">
                <option selected disabled>Select Subject</option>
                <option value="science">science</option>
                <option value="math">math</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="chapter" class="form-label">Choose Semester </label>
            <select name="semester" class="form-select" aria-label="Default select example">
                <option selected disabled>Select Semester</option>
                <option value="One">One</option>
                <option value="Two">Two</option>
                <option value="Three">Three</option>
                <option value="Four">Four</option>
            </select>
        </div>
        <div class="mb-3 col-4">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="text" class="form-control" id="email">
        </div>
    </div>


    <div class="d-flex py-4 justify-content-between">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input name="phone" type="number" class="form-control" id="phone">
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
            <input type="file" name="images" id="img" class="form-control form-control-lg"/>
            <label class="form-label" for="img">Upload Image</label>
        </div>
    </div>
    
    </div>
    <div class="d-grid gap-2 my-3">
        <button class="btn btn-dark" name="save" type="submit">ADD</button>
    </div>
</form>


<?php } ?>
        </div>
        <?php } ?>

