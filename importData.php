<?php
// Load the database configuration file
include_once 'dbConfig.php';

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $Date   = $line[0];
              
                $date = $Date;
                $parsed_date = date_parse_from_format("d/m/YYYY", $date);
                $con_date = $parsed_date['year'].'-'.$parsed_date['month'].'-'.$parsed_date['day'];
                $Date = $con_date;
                
                $Identifier  = $line[1];
                $Portfolio_manager  = $line[2];
                $Tickers = $line[3];
                $Type_Description = $line[4];
                $Quantity = $line[5];
                $Value = $line[6];
                
                $db->query("INSERT INTO tmg_trader_trades_year_month_v0 SET Date = '".$Date."', Identifier = '".$Identifier."', Portfolio_manager = '".$Portfolio_manager."', Tickers = '".$Tickers."', Type_Description = '".$Type_Description."', Quantity = ".$Quantity.", Value = ".$Value." ");
                // Check whether member already exists in the database with the same email
                // $prevQuery = "SELECT * FROM tmg_trader_trades_year_month_v0 WHERE Identifier = '".$line[1]."'";
                // $prevResult = $db->query($prevQuery);
                
                // if($prevResult->num_rows > 0){
                //     // Update member data in the database
                //     $db->query("UPDATE tmg_trader_trades_year_month_v0 SET Date = '".$Date."', Identifier = '".$Identifier."', Portfolio_manager = '".$Portfolio_manager."', Tickers = '".$Tickers."', Type_Description = '".$Type_Description."', Quantity = ".$Quantity.", Value = ".$Value." WHERE Identifier = '".$Identifier."'");
                // }else{
                //     // Insert member data in the database
                //     // $db->query("INSERT INTO members (name, email, phone, created, modified, status) VALUES ('".$name."', '".$email."', '".$phone."', NOW(), NOW(), '".$status."')");
                //     $db->query("INSERT INTO tmg_trader_trades_year_month_v0 SET Date = '".$Date."', Identifier = '".$Identifier."', Portfolio_manager = '".$Portfolio_manager."', Tickers = '".$Tickers."', Type_Description = '".$Type_Description."', Quantity = ".$Quantity.", Value = ".$Value." ");

                // }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: index.php".$qstring);