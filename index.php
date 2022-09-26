<?php
    require_once("db.php");
    require_once("functions.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Train List | Train Manager</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/64aa1ca898.js" crossorigin="anonymous"></script>
        
        <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <main class="container my-5">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2 p-4 content">
                    <h1 class="text-center mb-4">Trains</h1>
                    <?php 
                        $trains = get_all_trains($pdo);
                        echo show_flashdata();
                    ?>
                    <div class="float-end mb-4">
                        <a class="btn btn-primary" href="add.php"><i class="fa-sharp fa-plus"></i> Add Train</a>
                        <a class="btn btn-primary" href="import.php"><i class="fa-sharp fa-upload"></i> Import Trains</a>
                    </div>
                    <p>There are <strong><?php echo count($trains) ?></strong> trains in the database.</p>
                    <table class="table" id="datatable" data-page-length="5">
                        <thead>
                            <tr>
                                <th>Line</th>
                                <th>Route</th>
                                <th class="text-center">Run</th>
                                <th>Operator</th>
                                <th class="text-center" width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($trains as $train): ?>
                            <tr>
                                <td><?php echo $train->train_line ?></td>
                                <td><?php echo $train->route_name ?></td>
                                <td class="text-center"><?php echo $train->run_number ?></td>
                                <td><?php echo $train->operator_id ?></td>
                                <td class="text-end">
                                    <a class="btn btn-warning btn-sm" href="edit.php?id=<?php echo $train->id ?>" role="button"><i class="fa-sharp fa-edit"></i> Edit</a>
                                    <a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $train->id ?>" role="button"><i class="fa-sharp fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <script>
            $(document).ready(function () {
                $('#datatable').DataTable({ searching: true, paging: true, lengthMenu: [[5,10,20,-1],[5,10,20,'All']] });
            });
        </script>
    </body>
</html>