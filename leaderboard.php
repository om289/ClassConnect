<?php
session_start();
if (!isset($_SESSION["fidx"]) || $_SESSION["fidx"] == "") {
    header('Location:facultylogin.php');
    exit();
}
$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];

include("fhead.php");
include("database.php");

if (!isset($_GET['exam_id']) || empty($_GET['exam_id'])) {
    echo "<div class='container'><p style='color:red;'>Invalid exam selected.</p></div>";
    include("allfoot.php");
    exit();
}

$exam_id = mysqli_real_escape_string($connect, $_GET['exam_id']);

// Fetch exam name
$examNameResult = mysqli_query($connect, "SELECT ExamName FROM examdetails WHERE ExamID = '$exam_id'");
$examNameRow = mysqli_fetch_assoc($examNameResult);
$exam_name = $examNameRow ? $examNameRow['ExamName'] : "Assessment ID: $exam_id";

// Fetch result data with student name from examans
$sql = "SELECT r.*, 
               COALESCE(ea.Sname, 'Unknown') AS StudentName,
               CASE 
                   WHEN r.Eno IS NOT NULL AND r.Eno != '' THEN r.Eno
                   ELSE r.RollNumber
               END AS EnrollmentNo
        FROM result r 
        LEFT JOIN examans ea 
            ON (r.Eno = ea.Senrl OR r.RollNumber = ea.Senrl)
           AND r.Ex_ID = ea.ExamID
        WHERE r.Ex_ID = '$exam_id'";

$result = mysqli_query($connect, $sql);

echo "<div class='container'>";
echo "<h3>Welcome Faculty: <span style='color:#FF0004'>$fname</span></h3>";
echo "<h2 class='page-header'>Leaderboard for $exam_name</h2>";

if (mysqli_num_rows($result) == 0) {
    echo "<p style='color:red;'>No results found for this exam.</p>";
} else {
    // Leaderboard Table
    echo "<table class='table table-bordered'>";
    echo "<tr>
            <th>Rank</th>
            <th>Student Name</th>
            <th>Enrollment No</th>
            <th>Marks</th>
        </tr>";

    // Fetch and sort by Marks (descending)
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    usort($data, function($a, $b) {
        return intval($b['Marks']) <=> intval($a['Marks']);
    });

    $rank = 1;
    $top5Data = [];

    foreach ($data as $row) {
        $name = $row['StudentName'];
        $enroll = $row['EnrollmentNo'];

        if ($rank <= 5) {
            $top5Data[] = [$name, intval($row['Marks'])];
        }

        echo "<tr>
                <td>$rank</td>
                <td>$name</td>
                <td>$enroll</td>
                <td>{$row['Marks']}</td>
            </tr>";
        $rank++;
    }

    echo "</table>";
}
?>

<!-- Chart container -->
<div id="top5_chart" style="width: 100%; height: 400px;"></div>

<!-- Load Google Charts and draw -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawTop5Chart);

function drawTop5Chart() {
    var data = google.visualization.arrayToDataTable([
        ['Student', 'Marks'],
        <?php
        foreach ($top5Data as $item) {
            echo "['{$item[0]}', {$item[1]}],";
        }
        ?>
    ]);

    var options = {
        title: 'Top 5 Scorers - <?php echo $exam_name; ?>',
        chartArea: {width: '70%'},
        hAxis: {
            title: 'Marks',
            minValue: 0
        },
        vAxis: {
            title: 'Student'
        },
        colors: ['#1b9e77']
    };

    var chart = new google.visualization.BarChart(document.getElementById('top5_chart'));
    chart.draw(data, options);
}
</script>

<?php
echo "</div>";
include("allfoot.php");
?>
