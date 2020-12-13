<?php
    include('db.ini.php');
    if(!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json);
        $travelId;
    $travel_json = $data->travel_history; 
    $contact_json = $data->contact_history;
    $last_id = null;
    $sql = "UPDATE users SET first_name='{$data->first_name}', last_name='{$data->last_name}', age={$data->user_age}, civil_status='{$data->civil_status}', occupation='{$data->user_occupation}', address='{$data->user_address}' WHERE id={$data->userId->userId}";

    if ($conn->query($sql) === TRUE) {
        // echo "Users Table ---> Record updated successfully | ";
        // echo "<br>";
      } else {
        // echo "Users Table ---> Error updating record: " . $conn->error;
        // echo "<br>";
      }
      $covid = "UPDATE covid SET covid_status='{$data->covid_status}', days={$data->quarantine_days}, covid_case='{$data->covid_case}' WHERE user_id={$data->userId->userId}";
      $covidCaseId;
      if($conn ->query($covid) === TRUE) {
          $caseIdGet = "SELECT case_id FROM covid WHERE user_id={$data->userId->userId}";
          $caseId = mysqli_query($conn, $caseIdGet);
          if (mysqli_num_rows($caseId) > 0) {
  
              while($row = mysqli_fetch_assoc($caseId)) {
                  $covidCaseId = (int)$row['case_id'];
              }
          } else {
            //   echo 'unfortunately this not works';
          }
        //   echo "Covid Table ---> Record updated successfully | {$covidCaseId}";
      } else {
        //   echo "Covid Table ---> Error updating record: " . $conn->error;
      }

      # ! handling travel_history 
      foreach ($travel_json as $travelIndex) {
        $travelSql = "UPDATE travel_history INNER JOIN covid ON travel_history.user_travel=covid.case_id SET location='{$travelIndex->travel_location}', travel_date='{$travelIndex->travel_date}' WHERE travel_history.travel_id={$travelIndex->travel_id}";
        // $travelSql = "UPDATE travel_history SET location='{$travelIndex->travel_location}', travel_date='{$travelIndex->travel_date}' FROM travel_history t JOIN covid c on t.user_travel=c.case_id WHERE c.case_id=$covidCaseId";

        if($conn->query($travelSql) === TRUE) {
                // echo "Travel History Table ---> Record updated successfully ---> $travelIndex->travel_id\n";
                // echo "<br>";
                    
        } else {
                $travelInsert = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidCaseId, '{$travelIndex->travel_location}', '{$travelIndex->travel_date}')";

                if (mysqli_query($conn, $travelInsert) ){
                    // echo 'Travel History Table ---> successfully added new record';
                } else {
                    // echo "Travel History Table ---> Error: " . $travelInsert . "<br>" . mysqli_error($conn);
                }
                // echo "Travel History Table ---> Error updating record: " . $conn->error;
                // echo "<br>";
        }

        
        $updated = $conn->affected_rows;

        if($updated > 0) {
            // echo "Rows affected <$updated>\n";
            // echo "<br>";
        }
    }  
    

    #handling contact _ history 

    foreach ($contact_json as $contactIndex) {
        $contactSql = "UPDATE contact_trace INNER JOIN covid ON contact_trace.user_case_id=covid.case_id SET person_name='{$contactIndex->interact_name}', contact_date='{$contactIndex->interact_date}', address='{$contactIndex->interact_location}' WHERE contact_trace.contact_id={$contactIndex->interact_id}";
        // $contactSql = "UPDATE travel_history SET location='{$contactIndex->travel_location}', travel_date='{$contactIndex->travel_date}' FROM travel_history t JOIN covid c on t.user_travel=c.case_id WHERE c.case_id=$covidCaseId";

        if($conn->query($contactSql) === TRUE) {
                // echo "Contact Trace Table ---> Record updated successfully ---> $contactIndex->interact_id\n";
                // echo "<br>";
                    
        } else {
                $contactInsert = "INSERT INTO contact_trace (user_case_id, person_name, contact_date, address) VALUES($covidCaseId, '{$contactIndex->interact_name}', '{$contactIndex->interact_date}',
                '{$contactIndex->interact_location}')";

                if (mysqli_query($conn, $contactInsert) ){
                    $last_id = mysqli_insert_id($conn);
                    // echo 'Contact Trace Table ---> successfully added new record';
                } else {
                    // echo "Contact Trace Table ---> Error: " . $contactInsert . "<br>" . mysqli_error($conn);
                }
                
        }

        
        // $updated = $conn->affected_rows;

        // if($updated > 0) {
        //     echo "Rows affected <$updated>\n";
        //     echo "<br>";
        // }
    }  


    // fetch travel_history id;

    // $sqlTravel = "SELECT travel_id FROM travel_history WHERE user_travel=$covidCaseId";
    // $results_travel = mysqli_query($conn, $sqlTravel);
    // if (mysqli_num_rows($results_travel) > 0) {
    //     while($row1 = mysqli_fetch_assoc($results_travel)) {
    //         $temp =(int)$row1['travel_id'];
    //         $travelId[] = $temp;
    //     }
    // } else {
    //     #if row doesn't exist add a new one;
    //     foreach ($travel_json as $index) {
    //     $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidCaseId, '{$index->travel_location}', '{$index->travel_date}')";

    //     if (mysqli_query($conn, $travel) ){
    //         echo 'Travel History Table ---> successfully added new record';
    //     } else {
    //         echo "Travel History Table ---> Error: " . $travel . "<br>" . mysqli_error($conn);
    //     }
    //     }
    //     // $flag = false;
    // }
    // $travelIdCount = count($travelId);
    // $travelJsonCount = count($travel_json);
    // $travelIdIndex = 0;



    // while ($travelIdCount < $travelJsonCount) {
    //     echo "travel Json count ==> ${travelJsonCount}";
    //     echo "travel id count ==> ${travelIdCount}";
    //     echo $travelIdIndex;
    //     # update travel_history
    //     $travelSql = "UPDATE travel_history SET location='{$travel_json[$travelIdIndex]->travel_location}', travel_date='{$travel_json[$travelIdIndex]->travel_date}' WHERE travel_id={$travelId[$travelIdIndex]}";

    //     if($conn->query($travelSql) === TRUE) {
    //         echo "Travel History Table ---> Record updated successfully ---> {$travelIdIndex}";
            
    //     } else {
    //         echo "Travel History Table ---> Error updating record: " . $conn->error;
    //     }
    //     $travelIdCount += 1;
    //     $travelIdIndex += 1;
        
    // }

    // while($travelJsonCount  > $travelIdIndex) {
    //     $newTravelSql = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidCaseId, '{$travel_json[$travelIdIndex]->travel_location}', '{$travel_json[$travelIdIndex]->travel_date}')";

    //     if (mysqli_query($conn, $newTravelSql) ){
    //         echo 'Travel History Table ---> successfully added additional record';
    //     } else {
    //         echo "Travel History Table (new) Error: " . $newTravelSql . "<br>" . mysqli_error($conn);
    //     }
        
    //     $travelIdIndex += 1;
    // }
    // echo "Travel Count ===> {$travelIdCount} |||| ";
    // echo "Travel Json Count ===>> {$travelJsonCount} |||| ";
    // echo $travelIdIndex;
    // if($last_id != null) {
    //     $returnarr[] = array("new_id" => $last_id, "travel" => $data->travel_history, "contact" => $data->contact_history);
    //     echo json_encode($returnarr);
    // } else {
        $returnarr[] = array("travel" => $data->travel_history, "contact" => $data->contact_history);
        echo json_encode($returnarr);
    // }