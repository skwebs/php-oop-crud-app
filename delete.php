<?php
include_once 'classes/class.Crud2.php';

$db = new Crud();
if (isset($_GET["id"])) {
    //extract($_GET);
    try {
        $res = $db->delete('reg', "id=" . $_GET["id"]); // Table name
        $r = $db->getResult() [0];
        if ($res) {
            header("Location: ./");
        }
    }
    catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}

?>