<?php
    require_once("db.php");
    require_once("functions.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Import Trains | Train Manager</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/64aa1ca898.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <main class="container my-5">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2 p-4 content">
                    <h1 class="text-center mb-4">Import Trains</h1>
                    <p>Select a file below to import.</p>
                    <form method="POST" enctype="multipart/form-data" id="uploadform" action="process_upload.php">
                        <div class="form-group">
                            <label for="filename">File *</label>
                            <input type="file" class="form-control" name="filename" id="filename" required>
                            <p class="text-muted"><small>CSV or TXT files only, please</small></p>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit"><i class="fa-sharp fa-upload"></i> Upload File</button>
                            <a class="btn btn-danger" href="index.php"><i class="fa-sharp fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>