
<?php
session_start();
include ("../include/connect.php");
     if(!isset($_SESSION["did"])){
       header("location:../index.php");
     }
	 else{
	
	   $check_did = $_SESSION["did"];
		if($check_did !=2){
			 header("location:../index.php");
		}
	}
	
$msg ="";
$ids="";
$sbj="";
$csubs="";
$csub="";
if((isset($_POST["fname"])) && (isset($_POST["subject"])) &&(isset($_POST["sem"])) &&(isset($_POST["sec"])) ){

	$name = $_POST["fname"];
	$subs = $_POST["subject"];
	$sec = $_POST["sec"];
	$sem = $_POST["sem"];
	//CHECKING FOR THE NULL VALUES 
	if( ($name == "") || ($subs=="") || ($sec=="") || ($sem=="") ){
		$msg = "<div align='center'><font color='red'>Select all options properly</font></div>";
	}else{
	 $sql = mysql_query("SELECT * FROM facsub WHERE names='$name'  and sem = '$sem' and sec = '$sec'");

	 $count = mysql_num_rows($sql);
	 if($count){

		$update = mysql_query("UPDATE facsub SET subjects = '$subs' WHERE names='$name'  and sem = '$sem' and sec = '$sec' ");
		$sql1 = mysql_query("SELECT * FROM facsub WHERE names='$name'  and sem = '$sem' and sec = '$sec'");
	 		while($row=mysql_fetch_array($sql1)){
				$csubs = $row["subjects"];
			}
			if($csubs == $subs){
					$msg = "<div align='center'><font color='green'>Change Successfully Applied</font></div>";
			}
			else{
				$msg = "<div align='center'><font color='red'>Change Can't Be Applied, Contact Admin</font></div>";
			}
		
	}
	else{
		$msg = "<div align='center'><font color='red'>Selection parameter do not match</font></div>";
	}
	}
		
} 


?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<title>
			SSN College OF Engineering & Technology :: Attendance System
		</title>
	</head>
	<body>
		<div class="container" align="center">
			<div class="head pull-left">
				<h2 class="pull-left">SSN<small>&nbsp;&nbsp;College of Engineering & Technology</small></h2>
			</div>
			<hr class="horline" width="100%" /> 
			<div><?php include("../include/hodmenu.txt");?></div>
			<br/>
			<div class="promote">
			<form method="post" action="edit_alloc.php" name="regupdate">
			<table class="table table-bordered table-hover" width="500px">
			<caption align="center"><h3>Edit Subject Allocation </h3></caption>
			<tbody>
				<th class="danger" colspan="4">Select Subject To Change				
				</th>
			
				<tr>
					<td class="active" colspan="2">	
						<select name="fname" class="form-control" />
							<option value=""> Faculty Name</option>
							<?php 
							//retriving name of faculty to display in select option
								$sql=mysql_query("select distinct(fname) as fname from user");
								while($row = mysql_fetch_array($sql)){
									$faculty = $row["fname"];
									// displaying as option 
									echo "<option value='$faculty'>$faculty</option>";
								}
							?>
						
						</select>
					</td>
										<td class="active" colspan="2"><select name="subject" class="form-control">
							<option value="">Change Allocated Subject To</option>
					<?php
						
							//retriving the name of the subject from the database to display in the  select option
						$ans = mysql_query("SELECT distinct(`name`) FROM `faculty`  ORDER BY `name`");
						while($row = mysql_fetch_array($ans)){
							$fname = $row["name"];
							echo "<option value='$fname'>$fname</option>";	
						}
					?>
					</select>	
						</td>
					
					
				</tr>
				<tr>
				<!-- for selecting semester -->
					<td class="active" colspan="2">							
			<select name="sem" class="form-control">
			<option value="">Semester</option>
			<option value="I-I">I-I</option>
			<option value="I-II">I-II</option>
			<option value="II-I">II-I</option>
			<option value="II-II">II-II</option>
			<option value="III-I">III-I</option>
			<option value="III-II">III-II</option>
			<option value="IV-I">IV-I</option>
			<option value="IV-II">IV-II</option>
					
		 </select></td>
		 <!-- for selecting seciton -->
		 					<td class="active" colspan="2">							
			<select name="sec" class="form-control">
			<option value="">Section</option>
			<option value="A">A</option>
			<option value="B">B</option>

					
		 </select></td>
				</tr>
				<tr>
					<td colspan="4" align="center" class="success">
						<input type="submit" class="btn btn-success" name="submit"	value="Update Allocation">	
								
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center" class="success">
						<?php echo $msg; ?>
					</td>
				</tr>
			</tbody>			
			</table>
			</form>
		 </div>
		</div>
	</body>
</html>