<?php

    require_once("./config/database.php");

    $streams = [];
    $firtname = "";
    $lastname = "";
    $adm = 0;

    // retrieve all streams from the database
    try{
        $sql = "SELECT * FROM streams";
        $stmt = $PDO->query($sql);
        while ($row = $stmt->fetch()) {
            array_push($streams, $row);
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    

    if (isset($_GET['adm'])){
        $query = $_GET['adm'];
        try{
            $sql = "SELECT * FROM students WHERE adm = :id";
            $stmt = $PDO->prepare($sql);
            $stmt->bindvalue(":id", $query);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $firtname = $row['firstname'];
                $lastname = $row['firstname'];
                $adm = $row['adm'];
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

    }else{
        header('Location: http:localhost/Application');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilimo High School</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
<header>
        <nav>
            <h1>Dashboard</h1>
            <div>
                <a href="addstream.php" class="btn-primary">Add Stream</a>
            </div>
        </nav>
    </header>

    <main>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="form">
                    <h2>Admit New Student</h2>
                    <div class="form-control">
                        <label for="adm">Admission Number</label>
                        <input type="text" name="adm" value="<?php echo $adm; ?>" required>
                    </div>
                    <div class="form-control">
                        <label for="fname">Firstname</label>
                        <input type="text" name="fname" value="<?php echo $firtname; ?>" required>
                    </div>
                    <div class="form-control">
                        <label for="lname">Lastname</label>
                        <input type="text" name="lname" value="<?php echo $lastname; ?>" required>
                    </div>
                    <div class="form-control">
                        <label for="stream">View Students By Stream</label>
                        <select name="stream">
                            <?php 
                                foreach($streams as $s){
                                    echo "<option value=". $s[1] ."> ". $s[1] ." </option>";
                                }
                            ?>
                        </select>
                    </div>

                <div class="form-control">
                    <button type="submit" name="editstudent">Edit Student</button>
                </div> 
            </form>

    </main>
</body>
</html>