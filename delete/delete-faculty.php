<?php 

if( isset( $_GET['id'] ) ) {
    $id = $_GET['id'];

    include_once("./config.php");
// echo $id;
    $sql = "DELETE FROM faculty WHERE faculty_id = $id";
    $result = mysqli_query( $conn, $sql );

    if( $result ) {
        header("Location: ./dashboard.php?item=faculty");
    }
}
