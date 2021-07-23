<?php
    // get database connection
    require_once("./config/database.php");
    $student_data = [];
    $streams = [];

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
    

    // add student
    if (isset($_POST['addstudent'])){
        $adm = $_POST['adm'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $stream = $_POST['stream'];

        try{
            $sql = "INSERT INTO students (adm, firstname, lastname, stream) VALUES (?,?,?,?)";
            $stmt = $PDO->prepare($sql);
            $stmt->execute([$adm, $fname, $lname, $stream]);

            header("Location: http://localhost/Application");
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // retrieve students by streams
    if (isset($_POST['getstudents'])){
        $query = $_POST['stream'];
        if ($query !== "all"){
            try{
                $sql = "SELECT * FROM students WHERE stream = :id";
                $stmt = $PDO->prepare($sql);
                $stmt->bindvalue(":id", $query);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    array_push($student_data, $row);
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }

        }else{
            try{
                $sql = "SELECT * FROM students";
                $stmt = $PDO->query($sql);
                while ($row = $stmt->fetch()) {
                    array_push($student_data, $row);
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
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

    <main class="container">
        <div>
            <!-- Retrieve information from the database -->
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" id="form" class="form">
                <div class="form-control">
                    <label for="stream">View Students By Stream</label>
                    <select name="stream">
                    <option value="all">All Students</option>
                        <?php 
                            foreach($streams as $s){
                                echo "<option value=". $s[1] ."> ". $s[1] ." </option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-control">
                    <button type="submit" name="getstudents">Submit</button>
                </div>  
            </form>

            <table>
                <thead>
                    <th>Stream</th>
                    <th>Admission No</th>
                    <th>Student Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php 
                        foreach($student_data as $st){
                            echo "
                            <tr>
                                <td>". $st[3] ."</td>
                                <td>". $st[0] ."</td>
                                <td>". $st[1] .' ' . $st[2] . "</td>
                                <td>
                                    <a href=http://localhost/Application/editstudent.php?adm=". $st[0] . ">Edit</a>
                                    <a href=http://localhost/Application/delete.php?adm=". $st[0] . ">Delete</a>
                                </td>
                            </tr>
                            ";
                        }

                    ?>
                    
                </tbody>
            </table>

        </div>

        <aside>
            <!-- Capture student information form -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="form">
                    <h2>Admit New Student</h2>
                    <div class="form-control">
                        <label for="adm">Admission Number</label>
                        <input type="text" name="adm" required>
                    </div>
                    <div class="form-control">
                        <label for="fname">Firstname</label>
                        <input type="text" name="fname" required>
                    </div>
                    <div class="form-control">
                        <label for="lname">Lastname</label>
                        <input type="text" name="lname" required>
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
                    <button type="submit" name="addstudent">Add Student</button>
                </div> 
            </form>

        </aside>
    </main>
</body>
</html>