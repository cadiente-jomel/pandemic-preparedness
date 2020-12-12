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
    $flag = true;
    $flag1 = true;
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
            // $GLOBALS['travelId'] = array();
            // echo gettype($travelId);
            $temp =(int)$row1['travel_id'];
             $travelId[] = $temp;
        }
    } else {
        foreach ($travel_json as $index) {
        $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidId, '{$index->travel_location}', '{$index->travel_date}')";

        if (mysqli_query($conn, $travel) ){
            // echo 'Sucessfully added new record to travel history table';
        } else {
            echo "Error: " . $travel . "<br>" . mysqli_error($conn);
        }
        }
        $flag = false;
    }
    if ($flag) {
        $travelIdLength = count($travelId);
        $totalData = count($travel_json) + 1;
        $i = 0;
        if($travelIdLength > 0) {
            $is_true = true;
        } else {
            $is_true = false;
            $totalData = count($travel_json) - 1;
        }
                #1st(ended)  2nd(ended) 3rd
        # assuming <jomel>, <benjie>, <aira>;
        // foreach ($travel_json as $index) {
            # assuming two  values.
            // foreach ($travelId as $curr_travel) {
                if($is_true) {
                    for ($j=0; $j < $travelIdLength; $j++) { 
                        $travel = "UPDATE travel_history SET location='{$travel_json[$j]->travel_location}', travel_date='{$travel_json[$j]->travel_date}' WHERE user_travel=$travelId[$j]";
                    
                        if (mysqli_query($conn, $travel) ){
                            // echo 'Sucessfully added new record to travel trace table';
                            $i += 1;
                            // continue;
                        } else {
    
                            echo 'trouble updating travel-history --> check out the problem';
                        //     $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidId, '{$index->travel_location}', '{$index->travel_date}')";
        
                        // if (mysqli_query($conn, $travel) ){
                        //     $i += 1;
                        //     // continue;
                        //     // echo 'Sucessfully added new record to travel trace table';
                        // } else {
                        //     echo "Error: " . $travel . "<br>" . mysqli_error($conn);
                        // }
                        }
                    }
                    $is_true = false;
                }
                // $new_id = $curr_travel;

                for ($pos=$i; $pos < $totalData; $pos++) { 
                    $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidId, '{$travel_json[$pos]->travel_location}', '{$travel_json[$pos]->travel_date}')";
        
                    if (mysqli_query($conn, $travel) ){
                        // continue;
                        // echo 'Sucessfully added new record to travel trace table';
                    } else {
                        echo "Error: " . $travel . "<br>" . mysqli_error($conn);
                    }
                    $i += 1;
                }
                       #2             #2
                    // if(count($travelId) < count($travel_json)-1) {
                       
                    // } else {
                    //     $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidId, '{$index->travel_location}', '{$index->travel_date}')";
        
                    //     if (mysqli_query($conn, $travel) ){
                    //         $i += 1;
                    //         // continue;
                    //         // echo 'Sucessfully added new record to travel trace table';
                    //     } else {
                    //         echo "Error: " . $travel . "<br>" . mysqli_error($conn);
                    //     }
                    // }
                    // break;
                // $new_id += 1;
            // }
        // }
    }
    $sqlContact = "SELECT contact_id FROM contact_trace WHERE user_case_id=$covidId";
    $results_travel = mysqli_query($conn, $sqlContact);
    if (mysqli_num_rows($results_travel) > 0) {
        while($row2 = mysqli_fetch_assoc($results_travel)) {
            // $GLOBALS['contactId'] = array();        
            $temp1 = (int)$row2['contact_id'];
            $contactId[] = $temp1;
        }
    } else {
        foreach ($contact_json as $contact_index) {
            $contact = "INSERT INTO contact_trace (user_case_id, person_name, contact_date, address) VALUES($covidId, '{$contact_index->interact_name}', '{$contact_index->interact_date}', '{$contact_index->interact_location}')";
    
            if (mysqli_query($conn, $contact) ){
                // echo 'Sucessfully added new record to contact trace table';
            } else {
                echo "Error: " . $contact . "<br>" . mysqli_error($conn);
            }
            
        }
        $flag = false;
    }
    if($flag) {
        // $new_id;
        // $i = 0;
        //         #1st(ended)  2nd(ended) 3rd
        // # assuming <jomel>, <benjie>, <aira>;
        // foreach ($contact_json as $contact_index) {
        //     # assuming two  values.
        //     foreach ($contactId as $curr_contact) {
        //         // $new_id = $curr_contact;
        //                #0             #2
        //             if($i < count($contact_json)-1) {
        //                 $contact = "UPDATE contact_trace SET person_name='{$contact_index->interact_name}', contact_date='{$contact_index->interact_date}', address='{$contact_index->interact_location}'  WHERE contact_id=$curr_contact";
                
        //                 if (mysqli_query($conn, $contact) ){
        //                     // echo 'Sucessfully added new record to contact trace table';
        //                     $i += 1;
        //                     // continue;
        //                 } else {
        //                     $contact = "INSERT INTO contact_trace (user_case_id, person_name, contact_date, address) VALUES($covidId, '{$contact_index->interact_name}', '{$contact_index->interact_date}', '{$contact_index->interact_location}')";
        
        //                 if (mysqli_query($conn, $contact) ){
        //                     $i += 1;
        //                     // continue;
        //                     // echo 'Sucessfully added new record to contact trace table';
        //                 } else {
        //                     echo "Error: " . $contact . "<br>" . mysqli_error($conn);
        //                 }
        //                 }
        //             } else {
        //                 $contact = "INSERT INTO contact_trace (user_case_id, person_name, contact_date, address) VALUES($covidId, '{$contact_index->interact_name}', '{$contact_index->interact_date}', '{$contact_index->interact_location}')";
        
        //                 if (mysqli_query($conn, $contact) ){
        //                     $i += 1;
        //                     // continue;
        //                     // echo 'Sucessfully added new record to contact trace table';
        //                 } else {
        //                     echo "Error: " . $contact . "<br>" . mysqli_error($conn);
        //                 }
        //             }
        //             break;
        //         // $new_id += 1;
        //     }
        // }
        $contactIdLength = count($contactId);
        $totalContactData = count($contact_json) + 1;
        $i = 0;
        if($contactIdLength > 0) {
            $is_true = true;
        } else {
            $is_true = false;
            $totalContactData = count($contact_json) - 1;
        }
                #1st(ended)  2nd(ended) 3rd
        # assuming <jomel>, <benjie>, <aira>;
        // foreach ($contact_json as $contact_index) {
            # assuming two  values.
            // foreach ($travelId as $curr_travel) {
                if($is_true) {
                    for ($j=0; $j < $contactIdLength; $j++) { 
                        $contact = "UPDATE contact_trace SET person_name='{$contact_json[$j]->interact_name}', contact_date='{$contact_json[$j]->interact_date}', address='{$contact_json[$j]->interact_location}'  WHERE contact_id=$contactId[$j]";
                    
                        if (mysqli_query($conn, $contact) ){
                            // echo 'Sucessfully added new record to contact trace table';
                            // continue;
                        } else {
                            
                            echo 'trouble updating contact-history --> check out the problem';
                            //     $contact = "INSERT INTO contact_history (user_contact, location, contact_date) VALUES($covidId, '{$contact_index->contact_location}', '{$contact_index->contact_date}')";
                            
                            // if (mysqli_query($conn, $contact) ){
                                //     $i += 1;
                                //     // continue;
                                //     // echo 'Sucessfully added new record to contact trace table';
                                // } else {
                                    //     echo "Error: " . $contact . "<br>" . mysqli_error($conn);
                                    // }
                        }
                        $i += 1;
                    }
                    $is_true = false;
                }
                // $new_id = $curr_travel;

                for ($pos=$i; $pos < $totalContactData; $pos++) { 
                    $contact = "INSERT INTO contact_trace (user_case_id, person_name, contact_date, address) VALUES($covidId, '{$contact_json[$pos]->interact_name}', '{$contact_json[$pos]->interact_date}', '{$contact_json[$pos]->interact_location}')";
        
                    if (mysqli_query($conn, $travel) ){
                        // $i += 1;
                        // continue;
                        // echo 'Sucessfully added new record to travel trace table';
                    } else {
                        echo "Error: " . $contact . "<br>" . mysqli_error($conn);
                    }
                }
                       #2             #2
                    // if(count($travelId) < count($travel_json)-1) {
                       
                    // } else {
                    //     $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidId, '{$contact_index->travel_location}', '{$contact_index->travel_date}')";
        
                    //     if (mysqli_query($conn, $travel) ){
                    //         $i += 1;
                    //         // continue;
                    //         // echo 'Sucessfully added new record to travel trace table';
                    //     } else {
                    //         echo "Error: " . $travel . "<br>" . mysqli_error($conn);
                    //     }
                    // }
                    // break;
                // $new_id += 1;
            // }
        // }
    }



   
    // echo "Successfully added new record to covid table";
} else {
    echo "Error: " . $covid . "<br>" . mysqli_error($conn);
}

// echo "New record created successfully ". $last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$returnarr[] = array("new_id"=>$data->userId->userId, "selected"=>$covidId, "contact"=>$contactId, "travel"=>$travelId, 'travel_json'=>$travel_json, 'contact_json'=>$contact_json);
echo json_encode($returnarr);
mysqli_close($conn);




// echo $data;