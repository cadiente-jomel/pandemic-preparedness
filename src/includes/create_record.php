<?php
include('db.ini.php');

if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$json = file_get_contents('php://input');
$data = json_decode($json);

$sql = "INSERT INTO users (first_name, last_name, age, civil_status, occupation, address) VALUES('{$data->first_name}', '{$data->last_name}', {$data->user_age}, '{$data->civil_status}', '{$data->user_occupation}', '{$data->user_address}')";

if (mysqli_query($conn, $sql)) {
$last_id = mysqli_insert_id($conn);

$covid = "INSERT INTO covid (user_id, covid_status, days, covid_case) VALUES($last_id, '{$data->covid_status}', {$data->quarantine_days}, '{$data->covid_case}')";

if(mysqli_query($conn, $covid)) {
    $last_id_covid = mysqli_insert_id($conn);
    $travel_json = $data->travel_history;
    $contact_json = $data->contact_history;
    foreach ($travel_json as $index) {
        $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($last_id_covid, '{$index->travel_location}', '{$index->travel_date}')";

        if (mysqli_query($conn, $travel) ){
            // echo 'Sucessfully added new record to travel history table';
        } else {
            echo "Error: " . $travel . "<br>" . mysqli_error($conn);
        }
        
    }


    foreach ($contact_json as $contact_index) {
        $contact = "INSERT INTO contact_trace (user_case_id, person_name, contact_date, address) VALUES($last_id_covid, '{$contact_index->interact_name}', '{$contact_index->interact_date}', '{$contact_index->interact_location}')";

        if (mysqli_query($conn, $contact) ){
            // echo 'Sucessfully added new record to contact trace table';
        } else {
            echo "Error: " . $contact . "<br>" . mysqli_error($conn);
        }
        
    }
    // echo "Successfully added new record to covid table";
} else {
    echo "Error: " . $covid . "<br>" . mysqli_error($conn);
}

// echo "New record created successfully ". $last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


$returnarr[] = array("new_id" => $last_id, "travel" => $data->travel_history, "contact" => $data->contact_history);
echo json_encode($returnarr);
mysqli_close($conn);




// echo $data;