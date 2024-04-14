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

        <div class="edit-form">
        <form action="" method="POST" enctype="multipart/form-data">
    <?php
    ?>
    <div class="mb-3 ">
        <label for="name" class="form-label">Name <span>*</span></label>
        <input name="name" type="text" class="form-control" id="name" required>
    </div>
    <div class="d-flex justify-content-between">
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
            <label for="chapter" class="form-label">Choose Subject <span>*</span> </label>
            <select name="subject" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Select Subject</option>
                <option value="science">science</option>
                <option value="math">math</option>
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
        <div class="mb-3 col-4">
            <label for="email" class="form-label">Email <span>*</span></label>
            <input name="email" type="text" class="form-control" id="email" required>
        </div>
    </div>


    <div class="d-flex py-4 justify-content-between">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number <span>*</span></label>
            <input name="phone" type="number" class="form-control" id="phone" required>
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
        <button class="btn btn-dark" name="save" type="submit">ADD</button>
    </div>
</form>

        </div>

