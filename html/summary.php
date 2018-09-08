<?php
    session_start();


    //  Run main scoring function - produce summary report

    $username = $_SESSION["username"];
    $starttime = $_SESSION["starttime"];

    $qId = $_SESSION["qId"];
    $numberOfQuestions = str_replace("question", "", $qId);



function readData($sql) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=resetdb", "webuser", "apache8000");
        $q = $pdo->query($sql);
        $q->setFetchMode(PDO::FETCH_BOTH);
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
    
    $r = $q->fetchAll();
    return $r;
}


function getPointsRowByQuestion($points, $Qnum) {
  foreach ($points as $p) {
      if ($p['Q_num'] == $Qnum) {
          return $p;
      }
  }
}

function getAnswerFromPointsRow($pointsRow, $answer) {
  $answerStr = "answer_" . $answer;
  $answerStr = $pointsRow[$answerStr];
  return $answerStr;
}


function parseInteractivePointsStr($pointsStr, $totals) {

    $sub_totals = array(0,0,0);

    $splitArray = explode('|', $pointsStr);
    $num_results = 0;
   
    foreach ($splitArray as $arr) {
        if (strlen($arr) > 1) {
 
            $num_results += 1;
            $pairs = explode(' ', $arr);
            foreach ($pairs as $pair) {
                $p = explode(':', $pair);
                $p1 = $p[0];
                $p2 = $p[1];

                if ($p1 == "anx") {
                    $sub_totals[0] = $sub_totals[0] + $p2;
                }
                elseif ($p1 == "dep") {
                    $sub_totals[1] = $sub_totals[1] + $p2;
                }
                elseif ($p1 == "psy") {
                    $sub_totals[2] = $sub_totals[2] + $p2;
                }
            }
        }
    }

    // Calculate mean average for each category
    $sub_totals[0] = $sub_totals[0] / $num_results;
    $sub_totals[1] = $sub_totals[1] / $num_results;
    $sub_totals[2] = $sub_totals[2] / $num_results;

    // Allocate number of points based on average scores divide by 10
    // e.g. an average anxiety score of 46.25 converts to (46.25 / 10) = 4 points.
    $totals[0] += intdiv($sub_totals[0],10);
    $totals[1] += intdiv($sub_totals[1],10);
    $totals[2] += intdiv($sub_totals[2],10);

    return $totals;
}

function parsePointsStr($pointsStr, $totals) {

    $splitArray = explode(',', $pointsStr);

    foreach ($splitArray as $arr) {
        $s = explode('+', $arr);
        $s1 = $s[0];
        $s2 = $s[1];

        if ($s1 == "A") {
            $totals[0] = $totals[0] + $s2;
        }
        elseif ($s1 == "D") {
            $totals[1] = $totals[1] + $s2;
        }
        elseif ($s1 == "P") {
            $totals[2] = $totals[2] + $s2;
        }
    }

    return $totals;
}


function calculateScores($numberOfQuestions,$answers, $points, $totals) {

    $aArray = $answers[0];

    // Iterate across answers columns
    $qnum = 0;
    for ($i = 0; $i < $numberOfQuestions+2; $i++) {
    
        if ($i >= 2) {
            $userAnswer = $aArray[$i];
            $qnum = $i-1;
            //echo $qnum . ". userAnswer => " . $userAnswer . "\xA";
            $pointsRow = getPointsRowByQuestion($points, $qnum);
            $pointsStr = getAnswerFromPointsRow($pointsRow, $userAnswer);
            //echo " pointsStr => " . $pointsStr . "\xA";

            if (strlen($userAnswer) > 10) {   // Must be answer to interactive question
                $totals = parseInteractivePointsStr($userAnswer, $totals);
            }
            elseif ($pointsStr == NULL) {     // Must be multi-choice question
                // echo "pointsStr is NULL" . "\xA";
            }
            else {
                $totals = parsePointsStr($pointsStr, $totals);
            }
        }
    }
    
    return $totals;
}


// Start processing

$points = readData("SELECT * FROM points ORDER BY Q_num ASC");
$sql = "SELECT * FROM answers  WHERE user_id='" 
    . $username . "' " . " AND start_time ='" . $starttime . "' ";
$answers = readData($sql);


// Running totals
$anxiety_score = 0;
$depression_score = 0;
$psychotic_score = 0;
$totals = array($anxiety_score, $depression_score, $psychotic_score);

$totals = calculateScores($numberOfQuestions, $answers, $points, $totals);

?>





<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}

body{
    background-color:#90EE90
    }
.content {
    max-width: 1000px;
    margin: auto;
    background: none;
    padding: 50px;
    }
td {
    text-align: center;
}
</style>

</head>

<body>

<h1>RESET Session Summary</h1>

<b>Summary Report</b>
<br>
<br>
<?php
echo "<b>Session completed: " . date("Y-m-d") .  " " . date("h:i:sa") . "</b>";
?>
<br>
<br>

<table style="width:50%"> 
  <tr>
    <th>Condition</th>
    <th>Measurement</th>
  </tr>
  <tr>
    <td>Anxiety</td>
    <td><?php echo $totals[0]; ?></td>
  </tr>
  <tr>
    <td>Depression</td>
    <td><?php echo $totals[1]; ?></td>
  </tr>
  <tr>
    <td>Psychosis</td>
    <td><?php echo $totals[2]; ?></td>
  </tr>
</table>


<form action="./index.html" >
  <br />
  <input type="submit" value="Finish">
</form>

</body>
</html>



<!-- Logout and finish -->
<?php

    // remove all session variables
    session_unset(); 

    // destroy the session 
    session_destroy(); 

    header("location: index.php");
?>



