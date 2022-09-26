<?php
    require_once("db.php");
    require_once("functions.php");

    if (isset($_POST['train_line'])) {
        $train_line = trim(filter_input(INPUT_POST,'train_line',FILTER_SANITIZE_SPECIAL_CHARS));
        $route_name = trim(filter_input(INPUT_POST,'route_name',FILTER_SANITIZE_SPECIAL_CHARS));
        $run_number = trim(filter_input(INPUT_POST,'run_number',FILTER_SANITIZE_SPECIAL_CHARS));
        $operator_id = trim(filter_input(INPUT_POST,'operator_id',FILTER_SANITIZE_SPECIAL_CHARS));
        $train = [
            'train_line' => $train_line,
            'route_name' => $route_name,
            'run_number' => $run_number,
            'operator_id' => $operator_id,
        ];
        if (train_exists($pdo,$train)) {
            add_flashdata("info","Train with Run #{$train['run_number']} already exists.");
        } else {
            $succ = add_train($pdo,$train);
            if ($succ) {
                header("Location: index.php");
            } else {
                add_flashdata("danger","Could not add train with Run #{$train['run_number']}.");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Train | Train Manager</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/64aa1ca898.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <main class="container my-5">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2 p-4 content">
                    <h1 class="text-center mb-4">Add Train</h1>
                    <?php echo show_flashdata() ?>
                    <form method="POST" action="">
                        <div class="form-group mb-3">
                            <label for="train_line">Line</label>
                            <select class="form-control" name="train_line" id="train_line">
                                <option value="El">El</option>
                                <option value="Metra">Metra</option>
                                <option value="Amtrak">Amtrak</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="route_name">Route Name</label>
                            <input type="text" class="form-control" name="route_name" id="route_name" maxlength="20" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="route_name">Run Number</label>
                            <input type="text" class="form-control" name="run_number" id="run_number" maxlength="20" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="route_name">Operator ID</label>
                            <input type="text" class="form-control" name="operator_id" id="operator_id" maxlength="30" required>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit"><i class="fa-sharp fa-train"></i> Add Train</button>
                            <a class="btn btn-danger" href="index.php"><i class="fa-sharp fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>