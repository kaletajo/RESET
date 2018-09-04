<?php
    session_start();


    // =============  File Upload Code  ===========================================

    $target_dir = "/var/www/html/uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Delete any old existing files
    shell_exec("rm " . $target_dir . "*");

    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


    // Allow certain file formats
    if($imageFileType != "wmv" && $imageFileType != "mp4" && $imageFileType != "avi" && $imageFileType != "MP4") {
        echo "Sorry, only wmv, mp4 & avi files are allowed.";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

         
            // 1. Call ffmpeg/probe and extract 5 x jpegs from video file

            //-- Get duration of uploaded video
            //ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 20180902_150715.mp4
            //16.661000
            $output = shell_exec("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . $target_file);
            $duration = ceil($output);

            //-- Create a jpeg for rate of 1 every (frames-per-second) fps
            // ffmpeg -i 20180902_150715.mp4  -vf fps=5/16  img%03d.jpg
            shell_exec("ffmpeg -i " . $target_file . " -vf fps=5/" . $duration . " " . $target_dir . "img%03d.jpg");


            // The call to ffmpeg creates 5 jpg files, img001.jpg, img002.jpg, img003.jpg, img004.jpg, img005.jpg
            $jpg_files = array("img001.jpg", "img002.jpg", "img003.jpg", "img004.jpg", "img005.jpg");


            // 2. Pass each jpg to the neural-net classifier and get classification response
            $responses = "";
            foreach ($jpg_files as $jpg) {
                $output = shell_exec("python3 ../image-classifier/test_network.py --model ../image-classifier/new1.model --image " . $target_dir . $jpg);
                // Tidy output 
                // [INFO] loading network...
                $output = str_replace("[INFO]","", $output);
                $output = str_replace("loading network...","", $output);
                $output = trim($output);
                $responses = $responses . "|" . $output;
            }
            


            // 3. Store classifier responses in database
            // Read database config file and set-up db connection
            $db = parse_ini_file("../../database_conf.ini");
            $dbservername = $db['host'];
            $dbname = $db['name'];
            $dbusername = $db['user'];
            $dbpassword = $db['passwd'];
            $dbtype = $db['type'];

            $username = $_SESSION["username"];
            $starttime = $_SESSION["starttime"];
            try {
                $conn = new PDO("$dbtype:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully"; 
                $column = $_POST["qId"];
                $sql = "UPDATE answers SET " . $column . " = '" . $responses . "' " 
                                       . " WHERE user_id='" . $username . "' "
                                       . " AND start_time ='" . $starttime . "' ";
                echo "SQL = " . $sql;
                // use exec() because no results are returned
                $conn->exec($sql);

                // Close database connection
                $conn = null;

            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }

            // Clean up files
            shell_exec("rm " . $target_dir . "*");
            

            // 4. Go to next page
            if (isset($_SESSION['next_page'])){
                // Go to next page
                header("location: " . $_SESSION['next_page']);
            }

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

?>



