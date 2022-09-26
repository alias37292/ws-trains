<?php

    // Initialize the Session
    session_start();

    /**
     * Get All Trains in database for showing in list.
     *
     * @param PDO $pdo PDO connection object
     * @return Array List of rows from database corresponding to trains
     */
    function get_all_trains(&$pdo) {
        $q = ("
            SELECT *
            FROM trains
            ORDER BY run_number
        ");
        $stmt = $pdo->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get page containing train data for list view - Although not handled via PHP, this is the function that would be called if the JQuery DataTable plugin were not used.
     *
     * @param PDO $pdo  PDO connection object
     * @param string $sort Sort key to sort results on
     * @param string $dir Direction to sort results, either ASC or DESC
     * @param integer $offset Result to start at, default to the first result if not specified
     * @param integer $limit Limit page size, default to 5 per page if not specified
     * @return Mixed List of rows from database corresponding to specified parameters, or FALSE if none
     */
    function get_page(&$pdo,$sort = 'run',$dir = 'asc',$offset = 0,$limit = 5) {
        $q = ("
            SELECT *
            FROM trains
            ORDER BY :ord :dir
            LIMIT :offset,:limit
        ");
        $stmt = $pdo->prepare($q);
        $stmt->bindValue(':ord',$sort,PDO::PARAM_STR);
        $stmt->bindValue(':dir',$dir,PDO::PARAM_STR);
        $stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
        $stmt->bindValue(':limit',$limit,PDO::PARAM_INT);
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        }
        return FALSE;
    }

    /**
     * Get a specific train from the database
     *
     * @param PDO $pdo PDO connection object
     * @param integer $id  Primary key of train to retrieve
     * @return Mixed $result Row from database, or FALSE if not found
     */
    function get_train(&$pdo,$id) {
        $q = ("
            SELECT *
            FROM trains
            WHERE id = :id
            LIMIT 1
        ");
        $stmt = $pdo->prepare($q);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        }
        return FALSE;
    }

    /**
     * Determine if train with specified properties exists in database
     *
     * @param PDO $pdo PDO connection object
     * @param Array $train Array of train properties to check for
     * @return boolean $found Whether or not the train was found
     */
    function train_exists(&$pdo,$train) {
        $q = ("
            SELECT COUNT(*)
            FROM trains
            WHERE train_line = :line AND route_name = :route AND run_number = :run AND operator_id = :operator
            LIMIT 1
        ");
        $stmt = $pdo->prepare($q);
        $stmt->bindValue(':line',$train['train_line'],PDO::PARAM_STR);
        $stmt->bindValue(':route',$train['route_name'],PDO::PARAM_STR);
        $stmt->bindValue(':run',$train['run_number'],PDO::PARAM_STR);
        $stmt->bindValue(':operator',$train['operator_id'],PDO::PARAM_STR);
        $stmt->execute();
        return ($stmt->fetchColumn() > 0);
    }

    /**
     * Add a train to the database
     *
     * @param PDO $pdo PDO connection object
     * @param Array $train Array of train properties to insert a record for
     * @return Mixed Last Insert ID of train, or FALSE on error
     */
    function add_train(&$pdo,$train) {
        $q = ("
            INSERT INTO trains (train_line,route_name,run_number,operator_id) VALUES (:line, :route, :run, :operator)
        ");
        $stmt = $pdo->prepare($q);
        $stmt->bindValue(':line',$train['train_line'],PDO::PARAM_STR);
        $stmt->bindValue(':route',$train['route_name'],PDO::PARAM_STR);
        $stmt->bindValue(':run',$train['run_number'],PDO::PARAM_STR);
        $stmt->bindValue(':operator',$train['operator_id'],PDO::PARAM_STR);
        try {
            $stmt->execute();
            return $pdo->lastInsertId();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            error_log($ex->getTraceAsString());
            return FALSE;
        }
    }

    /**
     * Edit a Train
     *
     * @param PDO $pdo PDO connection object
     * @param int $id Primary key of train to edit
     * @param Array $train Properties of train to update with
     * @return Mixed Number of affected rows, or FALSE on error
     */
    function edit_train(&$pdo,$id,$train) {
        $q = ("
            UPDATE trains
            SET train_line = :line, route_name = :route, run_number = :run, operator_id = :operator
            WHERE id = :id
            LIMIT 1
        ");
        $stmt = $pdo->prepare($q);
        $stmt->bindValue(':line',$train['train_line'],PDO::PARAM_STR);
        $stmt->bindValue(':route',$train['route_name'],PDO::PARAM_STR);
        $stmt->bindValue(':run',$train['run_number'],PDO::PARAM_STR);
        $stmt->bindValue(':operator',$train['operator_id'],PDO::PARAM_STR);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        try {
            $stmt->execute();
            return ($stmt->rowCount() > 0);
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            error_log($ex->getTraceAsString());
            return FALSE;
        }
    }

    /**
     * Delete Train from database
     *
     * @param PDO $pdo PDO connection object
     * @param integer $id Primary key of train to delete
     * @return boolean Whether or not the delete was successful
     */
    function delete_train(&$pdo,$id) {
        $q = ("
            DELETE FROM trains
            WHERE id = :id
            LIMIT 1
        ");
        $stmt = $pdo->prepare($q);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        try {
            $stmt->execute();
            return ($stmt->rowCount() > 0);
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            error_log($ex->getTraceAsString());
            return FALSE;
        }
    }

    /**
     * Add Session Flash Message
     *
     * @param string $class Bootstrap class name of alert - typically 'success', 'info', 'warning', or 'danger'
     * @param string $msg The message to display
     * @return void
     */
    function add_flashdata($class,$msg) {
        $_SESSION['flashdata'][$class][] = $msg;
    }

    /**
     * Show Session Flash Messages on Page
     *
     * @return void
     */
    function show_flashdata() {
        if (!isset($_SESSION['flashdata'])) return;
        $html = "";
        $flashdata = $_SESSION['flashdata'];
        foreach($flashdata as $class => $items) {
            // No messages for this alert class, move on to the next one
            if (count($flashdata) == 0) continue;
            $html .= "<div class=\"alert alert-{$class}\">";
            $html .= "<ul>";
            foreach($items as $item) {
                $html .= "<li>{$item}</li>";
            }
            $html .= "</ul>";
            $html .= "</div>";
        }
        unset($_SESSION['flashdata']);
        return $html;
    }