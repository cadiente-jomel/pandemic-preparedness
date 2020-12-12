<?php
if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users";
$results = mysqli_query($conn, $sql);

if (mysqli_num_rows($results) > 0) {
    while($row = mysqli_fetch_assoc($results)) {
        /*
         <tr class="table-row">
                            <td class="table-data">Jomel Cadiente</td>
                            <td class="table-data">20</td>
                            <td class="table-data">Purok 5</td>
                            <td class="table-data"><i class="negative fas fa-times-circle"></i></td>
                            <td class="table-data"><a href="#"><i class="far fa-edit"></i></a> | <a href="#"><i class="fas fa-trash"></i></a></td>
                        </tr>
        */

        echo '<tr class="table-row table-click table-row-data"><input type="hidden" name="userId" value="'.$row['id'].'"><td class="table-data table-id">'. $row['id'] .'</td><td class="table-data">'. $row['first_name'] . ' '. $row['last_name'] .'</td>
        <td class="table-data">'. $row['age'] .'</td>
        <td class="table-data">'. $row['address'] .'</td>';
    $status =  mysqli_query($conn, "SELECT * FROM covid JOIN users ON users.id=covid.user_id WHERE users.id={$row['id']}");
    
    if(mysqli_num_rows($status) > 0) {
        while($row1 = mysqli_fetch_assoc($status)) {
            if($row1['covid_status'] != 'Negative') {
                echo '<td class="table-data"><i class="positive fas fa-check-circle"></i></td>';
            } else {
                echo '<td class="table-data"><i class="negative fas fa-times-circle"></i></td>';
            }
        }
    }

    echo '<td class="table-data"><a href="../includes/update_record.php" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn-edit" href="#"><i class="far fa-edit"></i></a>  <button class="btn-trash" data-bs-toggle="modal" data-bs-target="#confirm-modal"><i class="fas fa-trash"></i></button></td>';
    echo '</tr>';
        // <tr class="table-row"><td class="table-data">'. $row[] .'</td>
    }
} else {
    echo '<h1>no rows</h1>';
}
mysqli_close($conn);