<?php

    require_once("db.php");
    require_once("functions.php");

    $train = get_train($pdo,$_GET['id']);
    if (empty($train)) {
        add_flashdata('danger','Invalid train.');
        header("Location: index.php");
    }

    if (isset($_POST['id'])) {
        $succ = delete_train($pdo,$_POST['id']);
        if ($succ) {
            header("Location: index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delete Train | Train Manager</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/64aa1ca898.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <main class="container my-5">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2 p-4 content">
                    <h1 class="text-center mb-4">Delete Train</h1>
                    <p><strong>Train Line:</strong> <?php echo $train->train_line ?><br>
                       <strong>Route Name:</strong> <?php echo $train->route_name ?><br>
                       <strong>Run Number:</strong> <?php echo $train->run_number ?><br>
                       <strong>Operator ID:</strong> <?php echo $train->operator_id ?></p>
                    <p>Are you sure you want to delete this train?</p>
                    <form method="POST" action="">
                        <div class="text-center">
                            <input type="hidden" name="id" value="<?php echo $train->id ?>">
                            <button class="btn btn-dark" type="submit"><i class="fa-sharp fa-trash"></i> Yes, Delete</button>
                            <a class="btn btn-danger" href="index.php"><i class="fa-sharp fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>