<?php 
    include('db.ini.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    echo $data->id;
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      
      // sql to delete a record
    $sql = "DELETE FROM users WHERE id={$data->id}";
      
      if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
      } else {
        echo "Error deleting record: " . mysqli_error($conn);
      }
      
      mysqli_close($conn);
?>