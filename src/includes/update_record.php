<?php 
include('db.ini.php');
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$json = file_get_contents('php://input');
$data = json_decode($json);
// echo $data;

$sql = "SELECT * FROM users WHERE id={$data->id}";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
// echo "id: " . $row["id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
$id = $row['id'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$age = $row['age'];
$occupation = $row['occupation'];
$civil_status = $row['civil_status'];
$address = $row['address'];
$travel_data = array();
$contact_data = array();

$covidResults = mysqli_query($conn, "SELECT * FROM covid JOIN users ON users.id=covid.user_id WHERE users.id={$row['id']}");


if(mysqli_num_rows($covidResults) > 0) {
while($row1 = mysqli_fetch_assoc($covidResults)){
        $travelResults = mysqli_query($conn, "SELECT * FROM travel_history JOIN covid ON covid.case_id=travel_history.user_travel WHERE travel_history.user_travel={$row1['case_id']}");
        $contactResults = mysqli_query($conn, "SELECT * FROM contact_trace JOIN covid ON covid.case_id=contact_trace.user_case_id WHERE contact_trace.user_case_id={$row1['case_id']}");

        if (mysqli_num_rows($travelResults) > 0) {
            while($row2 = mysqli_fetch_assoc($travelResults)) {
                $travel_data[] = array("travel_location"=> $row2['location'],
                "travel_date" => $row2['travel_date'], 'travel_id'=>$row2['travel_id'],    
            );
            }
        }

        if (mysqli_num_rows($contactResults) > 0) {
            while($row3 = mysqli_fetch_assoc($contactResults)) {
                $contact_data[] = array("contact_person" => $row3['person_name'], 
                    "contact_date" => $row3['contact_date'],
                    "contact_address" => $row3['address'],  "contact_id"=>$row3['contact_id']
                    
            );
            }
        }
            $covid_case = $row1['covid_case'];
            $days = $row1['days'];
            $covid_status = $row1['covid_status']; 
        }
        }


        $return_arr[] = array("id" => $id,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "age" => $age,
        "occupation" => $occupation,
        "civil_status" => $civil_status,
        "days" => $days,
        "covid_case" => $covid_case,
        "covid_status" => $covid_status,
        "contact_data" => $contact_data,
        "travel_data" => $travel_data,
        "address" => $address,
        );
    }

  echo json_encode($return_arr);
} else {
  echo "0 results";
}

mysqli_close($conn);


// $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";

// if (mysqli_query($conn, $sql)) {
//   echo "Record updated successfully";
// } else {
//   echo "Error updating record: " . mysqli_error($conn);
// }

