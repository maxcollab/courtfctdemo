<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scdatabase";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get records from database
$query = $db->query("SELECT `cno`, `diaryno`, `ctype`, `cyear`, `pname`, `rname`, `rdvocates`, `pdvocates`, `judges`, `nh`, `description` FROM `cs`");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "case_status" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array(`cno`, `diaryno`, `ctype`, `cyear`, `pname`, `rname`, `rdvocates`, `pdvocates`, `judges`, `nh`, `description`);
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row["cno"],$row["diaryno"],$row["ctype"],$row["cyear"],$row["pname"],$row["rname"],$row["radvocates"],$row["padvocates"],$row["judges"],$row["nh"],$row["description"], $status);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>
