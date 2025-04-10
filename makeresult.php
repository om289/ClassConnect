<?php
session_start();
if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location: facultylogin');
}

include('database.php');
$examid = $_GET['examid'];
$enrl = $_GET['enrl'];

// Get exam answers
$sql = "SELECT * FROM examans WHERE ExamID = $examid AND Senrl = '$enrl'";
$result = mysqli_query($connect, $sql);
$submission = mysqli_fetch_assoc($result);
?>
<?php include('fhead.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Evaluating Exam: <?php echo $examid; ?></h3>
            <h4>Student: <?php echo $enrl; ?></h4>
            
            <form method="POST" action="saveresult.php">
                <table class="table table-bordered">
                    <tr>
                        <th>Question</th>
                        <th>Student Answer</th>
                        <th>Marks (0-4)</th>
                    </tr>
                    
                    <?php for($q=1; $q<=5; $q++): ?>
                    <tr>
                        <td>Q<?php echo $q; ?></td>
                        <td><?php echo htmlspecialchars($submission['Ans'.$q]); ?></td>
                        <td>
                            <input type="number" name="marks[]" class="marks-input" 
                                   min="0" max="4" required 
                                   oninput="calculateTotal()">
                        </td>
                    </tr>
                    <?php endfor; ?>
                    
                    <tr>
                        <td colspan="2" class="text-right"><strong>Total Marks:</strong></td>
                        <td>
                            <input type="text" id="totalMarks" name="total" 
                                   class="form-control" readonly>
                        </td>
                    </tr>
                </table>
                
                <input type="hidden" name="examid" value="<?php echo $examid; ?>">
                <input type="hidden" name="enrl" value="<?php echo $enrl; ?>">
                <button type="submit" class="btn btn-success">Save Result</button>
            </form>
        </div>
    </div>
</div>

<script>
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.marks-input').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    document.getElementById('totalMarks').value = total;
}
// Calculate initial total
calculateTotal();
</script>

<?php include('allfoot.php'); 
mysqli_close($connect);
?>