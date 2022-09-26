<?php 

    require_once("db.php");
    require_once("functions.php");

    if (!isset($_FILES['filename'])) {
        add_flashdata("danger","No file was uploaded.");
        header("Location: error.php");   
    }

    $folder = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
    $filename = $folder . $_FILES['filename']['name'];

    if (move_uploaded_file($_FILES['filename']['tmp_name'],$filename)) {
        // This will hold train data read in
        $trains = [];
        // Upload complete, parse the data 
        $fh = fopen($filename,'r');
        // Get header row
        $headers = fgetcsv($fh,1024);
        // Trim whitespace on header fields and convert to lowercase
        foreach($headers as &$header) {
            $header = trim(strtolower($header));
        }
        while($row = fgetcsv($fh,1024)) {
            // Trim whitespace on field values
            foreach($row as &$field) {
                $field = trim($field);
            }
            // To make sure it's unique, but allow for arbitrary field layout, create a key from a json encoded representation of the row data
            $hash = sha1(json_encode($row));
            // Add to data array
            $trains[$hash] = array_combine($headers, $row);
        }
        fclose($fh);

        // We have the data now, process it
        $i = 0;
        foreach($trains as $train) {
            $i++;
            // If the train already exists, skip it
            if (train_exists($pdo,$train)) {
                add_flashdata("info","Train on Row #{$i} in the file already exists.");
                continue;
            } 
            // If the train has missing data, skip it
            if (empty($train['train_line']) || empty($train['route_name']) || empty($train['run_number']) || empty($train['operator_id'])) {
                add_flashdata("danger","Train on Row #{$i} in the file is missing required data; skipping.");
                continue;
            }
            try {
                $succ = add_train($pdo,$train);
                if ($succ) {
                    add_flashdata("success","Train with Run #{$train['run_number']} added successfully.");
                } else {
                    add_flashdata("danger","Train with Run #{$train['run_number']} could not be added.");
                }
            } catch(Exception $ex) {
                add_flashdata("danger","Train with Run #{$train['run_number']} could not be added.");
                error_log($ex->getMessage());
            }
        }
    } else {
        // There was an error
        add_flashdata("danger","File could not be uploaded.");
    }
    header("Location: index.php");