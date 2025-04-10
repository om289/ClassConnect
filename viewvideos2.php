<?php
session_start();

if ( $_SESSION[ "sidx" ] == "" || $_SESSION[ "sidx" ] == NULL ) {
	header( 'Location:studentlogin' );
}

$userid = $_SESSION[ "sidx" ];
$userfname = $_SESSION[ "fname" ];
$userlname = $_SESSION[ "lname" ];
?>

<?php include('studenthead.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
				<h3> Welcome <a href="welcomestudent.php" <?php echo "<span style='color:red'>".				$userfname." ".$userlname."</span>";?> </a></h3>
				
			<?php 
				
				include('database.php');
				$video_id= $_GET['viewid'];
				

				// Update the query to use the correct column name and add error handling
				$sql = "SELECT * FROM video WHERE ID=$video_id";
				$rs = mysqli_query($connect, $sql);

				if (!$rs) {
					echo "<p>Error: Unable to fetch video details. Please try again later.</p>";
					exit;
				}
				?>			
				<?php
					// Embed the video using an iframe with proper YouTube embed formatting
					while ($row = mysqli_fetch_array($rs)) {
						?>
						<tr>
							<td>
								<h2>Title: <?php echo isset($row['VideoTitle']) ? $row['VideoTitle'] : "N/A"; ?></h2>
							</td>
							<br>
							<td>
								<?php
								if (isset($row['VideoURL']) && filter_var($row['VideoURL'], FILTER_VALIDATE_URL)) {
									// Check if the URL is a YouTube link
									if (strpos($row['VideoURL'], 'youtube.com') !== false || strpos($row['VideoURL'], 'youtu.be') !== false) {
										// Extract the video ID and format the embed URL
										parse_str(parse_url($row['VideoURL'], PHP_URL_QUERY), $queryParams);
										$videoId = $queryParams['v'] ?? basename(parse_url($row['VideoURL'], PHP_URL_PATH));
										$embedUrl = "https://www.youtube.com/embed/" . $videoId;
										echo "<iframe width='560' height='315' src='$embedUrl' frameborder='0' allowfullscreen></iframe>";
									} else {
										echo "<iframe width='560' height='315' src='{$row['VideoURL']}' frameborder='0' allowfullscreen></iframe>";
									}
								} else {
									echo "<p>Invalid video URL</p>";
								}
								?>
							</td>
							<br>
							<td>
								<p>Video Description: <?php echo isset($row['Description']) ? $row['Description'] : "N/A"; ?></p>
							</td>
							<br>
							<td>
								<a href="viewvideos.php"> <input type="button" Value="Back" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"></a>
							</td>
						</tr>
						<?php
					}
				?>
			
		</div>
	</div>
	<?php include('allfoot.php');  ?>
</div>