<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (isset($_POST["action"]))
{
    extract($_POST);
    include_once 'classes/class.Crud2.php';

    try
    {
        $db = new Crud();

        /*
         * Insert
        */
        if ($action == "insert")
        {
            unset($_POST["action"]);
            $res = $db->insert('reg', $_POST); // Table name, column names and respective values
            if ($res){
	            $_SESSION["sql"] = $db->getSql();
               header("Location: ./");
            }
        }

    }
    catch(PDOException $e)
    {
        echo "There is some problem in connection: " . $e->getMessage();
    }

}