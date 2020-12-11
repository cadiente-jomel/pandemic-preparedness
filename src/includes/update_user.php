<?php
include('db.ini.php');

if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$json = file_get_contents('php://input');
$data = json_decode($json);

$sql = "UPDATE users SET first_name='{$data->first_name}', last_name='{$data->last_name}', age={$data->user_age}, civil_status='{$data->civil_status}', occupation='{$data->user_occupation}', address='{$data->user_address}' WHERE id={$data->userId->userId}";
// !!! bug here variable not working;
$covidId;
$travelId;
$contactId;
if (mysqli_query($conn, $sql)) {
$last_id = mysqli_insert_id($conn);

$covid = "UPDATE covid SET covid_status='{$data->covid_status}', days={$data->quarantine_days}, covid_case='{$data->covid_case}' WHERE user_id={$data->userId->userId}";

if(mysqli_query($conn, $covid)) {
    $last_id_covid = mysqli_insert_id($conn);
    $travel_json = $data->travel_history;
    $contact_json = $data->contact_history;
    $sql = "SELECT case_id FROM covid WHERE user_id={$data->userId->userId}";
    $results = mysqli_query($conn, $sql);
    if (mysqli_num_rows($results) > 0) {

        while($row = mysqli_fetch_assoc($results)) {
            $covidId = (int)$row['case_id'];
        }
    } else {
        echo 'unfortunately this not works';
    }
    
    
    $sqlTravel = "SELECT travel_id FROM travel_history WHERE user_travel=$covidId";
    $results_travel = mysqli_query($conn, $sqlTravel);
    if (mysqli_num_rows($results_travel) > 0) {
        while($row1 = mysqli_fetch_assoc($results_travel)) {
            $travelId = (int)$row1['travel_id'];
        }
    } else {
        echo 'unfortunately this not works';
    }
                foreach ($travel_json as $index) {

                            $travel = "UPDATE travel_history SET location='{$index->travel_location}', travel_date='{$index->travel_date}' WHERE travel_id=$travelId";
                    
                            if (mysqli_query($conn, $travel) ){
                                // echo 'Sucessfully added new record to travel history table';
                            } else {
                                echo "Error: " . $travel . "<br>" . mysqli_error($conn);
                            }
                }
    $sqlContact = "SELECT contact_id FROM contact_trace WHERE user_case_id=$covidId";
    $results_travel = mysqli_query($conn, $sqlContact);
    if (mysqli_num_rows($results_travel) > 0) {
        while($row2 = mysqli_fetch_assoc($results_travel)) {
            $contactId = (int)$row2['contact_id'];
        }
    } else {
        echo 'unfortunately this not works';
    }

                foreach ($contact_json as $contact_index) {
                    $contact = "UPDATE contact_trace SET person_name='{$contact_index->interact_name}', contact_date='{$contact_index->interact_date}', address='{$contact_index->interact_location}'  WHERE contact_id=$contactId";
            
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

$returnarr[] = array("new_id"=>$data->userId->userId, "selected"=>$covidId, "contact"=>$contactId, "travel"=>$travelId);
echo json_encode($returnarr);
mysqli_close($conn);




// echo $data;