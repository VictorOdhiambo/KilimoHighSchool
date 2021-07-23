<?php
    // require a database connection
    require_once "./config/database.php";

         if(isset($_GET['adm'])){
            $id = $_GET['adm'];
            // delete this recipe
            try{
                $sql = "DELETE FROM students WHERE adm = :id";
                $stmt = $PDO->prepare($sql);
                $stmt->bindvalue(":id", $id);
                $stmt->execute();

                // redirect back
                header("Location: http://localhost/Application/index.php");
            }catch(PDOException $e){
                echo $e->getMessage();
            }
         }else{
            header("Location: http://localhost/Application/index.php");
         }
?>