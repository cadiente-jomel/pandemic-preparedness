<?php
    include('db.ini.php');
    if(!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json);
        $travelId;
    $travel_json = $data->travel_history; 

    $sql = "UPDATE users SET first_name='{$data->first_name}', last_name='{$data->last_name}', age={$data->user_age}, civil_status='{$data->civil_status}', occupation='{$data->user_occupation}', address='{$data->user_address}' WHERE id={$data->userId->userId}";

    if ($conn->query($sql) === TRUE) {
        echo "Users Table ---> Record updated successfully | ";
        echo "<br>";
      } else {
        echo "Users Table ---> Error updating record: " . $conn->error;
        echo "<br>";
      }

      foreach ($travel_json as $travelIndex) {
        $travelSql = "UPDATE travel_history INNER JOIN covid ON travel_history.user_travel=covid.case_id SET location='{$travelIndex->travel_location}', travel_date='{$travelIndex->travel_date}' WHERE travel_history.travel_id={$travelIndex->travel_id}";
        // $travelSql = "UPDATE travel_history SET location='{$travelIndex->travel_location}', travel_date='{$travelIndex->travel_date}' FROM travel_history t JOIN covid c on t.user_travel=c.case_id WHERE c.case_id=$covidCaseId";

        if($conn->query($travelSql) === TRUE) {
                echo "Travel History Table ---> Record updated successfully ---> $travelIndex->travel_id\n";
                echo "<br>";
                    
        } else {
                echo "Travel History Table ---> Error updating record: " . $conn->error;
                echo "<br>";
        }

        
        $updated = $conn->affected_rows;

        if($updated > 0) {
            echo "Rows affected <$updated>\n";
            echo "<br>";
        }
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
            echo 'unfortunately this not works';
        }
        echo "Covid Table ---> Record updated successfully | {$covidCaseId}";
    } else {
        echo "Covid Table ---> Error updating record: " . $conn->error;
    }

    // fetch travel_history id;

    $sqlTravel = "SELECT travel_id FROM travel_history WHERE user_travel=$covidCaseId";
    $results_travel = mysqli_query($conn, $sqlTravel);
    if (mysqli_num_rows($results_travel) > 0) {
        while($row1 = mysqli_fetch_assoc($results_travel)) {
            $temp =(int)$row1['travel_id'];
            $travelId[] = $temp;
        }
    } else {
        #if row doesn't exist add a new one;
        foreach ($travel_json as $index) {
        $travel = "INSERT INTO travel_history (user_travel, location, travel_date) VALUES($covidCaseId, '{$index->travel_location}', '{$index->travel_date}')";

        if (mysqli_query($conn, $travel) ){
            echo 'Travel History Table ---> successfully added new record';
        } else {
            echo "Travel History Table ---> Error: " . $travel . "<br>" . mysqli_error($conn);
        }
        }
        // $flag = false;
    }
    $travelIdCount = count($travelId);
    $travelJsonCount = count($travel_json);
    $travelIdIndex = 0;



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