<style>
    .teacher-img img {
        width: 60px;
        border-radius: 50%;
        height: 60px;
    }

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

$sql = "SELECT * FROM teachers LIMIT {$offsets}, {$limit}";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {



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
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr class="fs-5">
                <td class="teacher-img"><img src="<?php echo $row['images']; ?>" alt=""></td>
                <td>
                    <p><?php echo $row['name']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['faculty']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['subject']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['semester']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['email']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['phone']; ?></p>
                </td>
                <td>
                    <p><?php echo $row['address']; ?></p>
                </td>
                <td class="">
                    <button class="edit-btn btn btn-primary mt-2">
                        <a href="./dashboard.php?item=edit-teachers&id=<?php echo $row['teachers_id']; ?>"
                            class="text-light">Edit</a>
                    </button>
                    <button class="edit-btn btn btn-danger mt-2 delete-btn">
                        <a href="./dashboard.php?item=delete-teachers&id=<?php echo $row['teachers_id']; ?>"
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

        $sql1 = "SELECT * FROM teachers";

        $result1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($result1) > 0) {
            $total_records = mysqli_num_rows($result1);

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
        <h5 id="message" class="py-3 message text-center text-danger">Are you sure you want to delete?</h5>
        <div class="d-grid gap-2 my-3">
            <button class="conf-btn btn-danger popupYes" id="popupYes">Yes</button>
            <button class="conf-btn popupNo" id="popupNo">No</button>
        </div>
    </div>
</div>
