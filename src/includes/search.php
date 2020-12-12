<?php
include('db.ini.php');
if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
$json = file_get_contents('php://input');
$data = json_decode($json);
// $val = $_POST['search-value'];
$valPiece = explode(" ", $data->val);
if($valPiece[0] != 'patience' and $valPiece[0] != 'under' and $valPiece[0] != 'legal' ) {
    if(count($valPiece) < 2) {
        $sql = "SELECT * FROM users WHERE first_name LIKE '%{$valPiece[0]}%' or last_name LIKE '%{$valPiece[0]}%'";
    } else {
        $sql = "SELECT * FROM users WHERE first_name LIKE '%{$valPiece[0]}%' or last_name LIKE '%{$valPiece[1]}%'";
    }
}else {
    if($valPiece[0] == 'under') {
        $sql = "SELECT * FROM users WHERE age < 18";
    } else if ($valPiece[0] == 'legal') {
        $sql = "SELECT * FROM users WHERE age > 18";
    } else if ($valPiece[0] == 'patience') {
        $sql = "SELECT * FROM users JOIN covid ON covid.user_id=users.id WHERE covid_status='Positive' or covid_status='Under Investigation'";
    }
}


$results = mysqli_query($conn, $sql);
$id;
$first_name;
$last_name;
$age;
$occupation;
$civil_status;
$travel_data;
$contact_data;
$res;
$i = 0;

if (mysqli_num_rows($results) > 0) {
    while($row = mysqli_fetch_assoc($results)) {

        
        // $id[] = $row['id'];
        // $first_name[] = $row['first_name'];
        // $last_name = $row['last_name'];
        // $age = $row['age'];
        // $occupation = $row['occupation'];
        // $civil_status = $row['civil_status'];
        $travel_data = array();
        $contact_data = array();

       
        // $days;
        // $covid_status;
        // $covid_case;
        // $travel_location;
        // $travel_date;
        // $contact_person; 
        // $contact_date;
        // $contact_address;
        // <li>First Name: <span clsas="info-first">Susan</span></li>
        // <li>Last Name: <span clsas="info-last">Williams</span></li>
        // <li>Age: <span clsas="info-age">25</span></li>
        // <li>Occupation: <span clsas="info-occupation">Stock Investor</span> </li>
        // <li>Civil Status: <span clsas="info-civil">Single</span></li>
        // <li>Status: <span clsas="info-status">Positive</span></li>
        // <li>Day of Quarantine: <spa clsas="info-day">14days</spa></li>
        // <li>Covid Case: <span clsas="info-case">Asymptomatic</span></li>
        // ?
        // echo '<li>First Name: <span class="info-first">'. $row['first_name'] .'</span></li>
        // <li>Last Name: <span class="info-last">'. $row['last_name'] .'</span></li>
        // <li>Age: <span class="info-age">'. $row['age'] .'</span></li>
        // <li>Occupation: <span class="info-occupation">'. $row['occupation'] .'</span></li>
        // <li>Civil Status: <span class="info-civil">'. $row['civil_status'] .'</span></li>';

    $covidResults = mysqli_query($conn, "SELECT * FROM covid JOIN users ON users.id=covid.user_id WHERE users.id={$row['id']}");
    
    
    if(mysqli_num_rows($covidResults) > 0) {
        while($row1 = mysqli_fetch_assoc($covidResults)){
        $travelResults = mysqli_query($conn, "SELECT * FROM travel_history JOIN covid ON covid.case_id=travel_history.user_travel WHERE travel_history.user_travel={$row1['case_id']}");
        $contactResults = mysqli_query($conn, "SELECT * FROM contact_trace JOIN covid ON covid.case_id=contact_trace.user_case_id WHERE contact_trace.user_case_id={$row1['case_id']}");

        if (mysqli_num_rows($travelResults) > 0) {
            while($row2 = mysqli_fetch_assoc($travelResults)) {
                $travel_data[] = array("travel_location"=> $row2['location'],
                "travel_date" => $row2['travel_date'],    
            );
                // $travel_location = $row2['location'];
                // $travel_date = $row2['travel_date'];
            }
        }

        if (mysqli_num_rows($contactResults) > 0) {
            while($row3 = mysqli_fetch_assoc($contactResults)) {
                $contact_data[] = array("contact_person" => $row3['person_name'], 
                    "contact_date" => $row3['contact_date'],
                    "contact_address" => $row3['address'],
                    
            );
                // $contact_person = $row3['person_name'];
                // $contact_date = $row3['contact_date'];
                // $contact_address = $row3['address'];
            }
        }

            // echo '<li>Covid Status: <span class="info-status">'. $row1['covid_status'] .'</span></li>
            // <li>Day of Quarantine: <span class="info-day">'. $row['days'] .'</span></li>
            // <li>Covid Case: <span class="info-case">'. $row['covid_case'] .'</span></li>';
           
            $res[] =  array(
                "new_id"=>$row['id'],
                "first_name" => $row['first_name'],
                "last_name" => $row['last_name'],
                "age" => $row['age'],
                "address" => $row['address'],
                "occupation" => $row['occupation'],
                "civil_status" => $row['civil_status'],
                "covid_case" => $row1['covid_case'],
                "days" => $row1['days'],
                "covid_status" => $row1['covid_status'],
                "contact_data" => $contact_data,
                "travel_data" => $travel_data,
            );
        }
    }



    }
    echo json_encode($res);
} else {
    echo '<h1>no rows</h1>';
}
mysqli_close($conn);