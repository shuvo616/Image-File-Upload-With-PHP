<?php 
/* $ () & # ! % @*/
	include 'inc/header.php'; 
	include 'lib/config.php';
	include 'lib/Database.php';

	$db = new Database();
?>




				<div class="myform">
				<?php 
					if ($_SERVER['REQUEST_METHOD'] == "POST") {
						$permited  = array('jpeg','jpg','png','gif');
						$file_name = $_FILES['image']['name'];
						$file_size = $_FILES['image']['size'];
						$file_temp = $_FILES['image']['tmp_name'];

						$img_division = explode('.', $file_name);
						$img_extention = strtolower(end($img_division));
						$img_uniquename = substr(md5(time()), 0, 10).'.'.$img_extention;

						$uploadedfolder_img = "uploads/".$img_uniquename;
						move_uploaded_file($file_temp, $uploadedfolder_img);

						if (empty($file_name)) {
							echo "<span class='fail'>Please Select an Image to upload.</span>";
						} elseif ($file_size > 1048576) {
							echo "<span class='fail'>Image size must be less than 1 MB.</span>";
						} elseif (in_array($img_extention, $permited) === false) {
							echo "<span class='fail'>You can upload only:-".implode(', ' ,$permited)."</span>";
						} else{

						$insert_query = "INSERT INTO  table_image(image) VALUES('$uploadedfolder_img')";
						$insert_img_databse = $db->insert_img($insert_query);
						if ($insert_img_databse) {
							echo "<span class='success'>Image Inserted Seccessfully.</span>";
						} else {
							echo "<span class='fail'>Image Not Inserted.</span>";
						}
					}
						
				}

				 ?>
					<form action="" method="post" enctype="multipart/form-data">
						<table>
							<tr>
								<td>Select Image:</td>
								<td><input type="file" name="image"></input></td>
							</tr>

							<tr>
								<td></td>
								<td><input type="submit" value="Upload"></input></td>
							</tr>
						</table>
					</form>


					
					<table>
						<tr>
							<th width="30%">Serial</th>
							<th width="30%">Image</th>
							<th width="30%">Action</th>
						</tr>
					<?php 
						if (isset($_GET['del'])) {
							$id = $_GET['del'];

						$getimg_query = "SELECT * FROM table_image WHERE id= $id";
						$image_data = $db->view_img($getimg_query);
						if ($image_data) {
							while ($get_result = $image_data->fetch_assoc()) {
							 $del_folderImg = $get_result['image'];
							 unlink($del_folderImg);
						}
						}
						
						
						$imgdelete_query = "DELETE FROM table_image WHERE id= $id";
						$imgdelete = $db->delete_img($imgdelete_query);

						if ($imgdelete ) {
							echo "<span class='success'>Image Deleted Seccessfully.</span>";
						} else {
							echo "<span class='fail'>Image Not Deleted.</span>";
						}
						
					}
					 ?>


					<?php 
					//Process to view image.
						$imgview_query = "SELECT * FROM table_image";
						$retrive_img = $db->view_img($imgview_query);

						if ($retrive_img) {
							$i = 0;
							while ($result = $retrive_img->fetch_assoc()) {
							 $i++;	
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><img src="<?php echo $result['image']; ?>" height="60px" width="80px"></td>
							<td><a href="?del=<?php echo $result['id']; ?>">Delete</a></td>
						</tr>

					<?php }} ?>

					</table>

					
				</div>




<?php include 'inc/footer.php'; ?>