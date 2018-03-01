<?php
// initialize.php  contains all important files like: config.php – databse.php - databaseObject.php - pagination.php  - user.php – photograph.php -  …

          require_once("../includes/initialize.php"); ?>

<?php

 // the current page number ($current_page) , here I used global array $_GET to get the $_GET[‘page’] if exist else put 1

  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

  // 2. records per page ($per_page)

  $per_page=5;

  // Phoptpgraph Class extends DatabseObject  Class
  // I am using Photograph class to access the count_all() static method inside DatabseObject class,
  //  it returns the  number of rows inside my table phoptograph in my database

  $total_count = Photograph::count_all();
?>

<?php

// here I am using pagination




//  here I create an instance of pagination Class, the constructor takes 3 parameters

$pagination = new Pagination($page,$per_page,$total_count);



//Instead of finding all records , just find the records for this page.(for each page 5 objects)

$sql= " SELECT * FROM photographs ";

$sql .= "LIMIT {$per_page}";

$sql .= " OFFSET {$pagination->offset()}";

// find_by_sql is a static method inside DatabaseObject Class, and Photograph extends DatabaseObject.
$photos = Photograph::find_by_sql($sql); // $photos is an array of photographs(objects)
?>

<!-- here I am rendering data (view) -->
<?php include_layout_template('header.php'); ?>
<h2>Photographs</h2>
<a style="margin:0 auto; width:20%;" class="link" href="admin/login.php "> &laquo; Back </a> <br/>

<br/>
<!-- loop through $photos (array of objects) and for each photo create a div (image and a link and caption) -->

 <?php foreach($photos as $photo): ?>

<div class="images" style="float: left; margin-left:40px ;">

 <a href="photo.php?id=<?php echo $photo->id;?>">  <img src="<?php echo $photo->image_path();?>"  />   </a>

 <p> <?php echo $photo->caption; ?> </p>

 </div>
<?php endforeach ; ?>


<div id="pagination" style="clear: both;" >

<?php

if($pagination->total_pages() > 1){

	if($pagination->has_previous_page()){

		echo "<a style='color: white;' href =\"index1.php?page=";

		echo $pagination->previous_page();

		echo "\">&laquo; Prev</a>";

	}

	echo " &nbsp";


// looping from 1 - 2 - 3...(total pages) and add class="selected" for the page that we are selected, to differ it from the rest
for($i=1 ; $i<= $pagination->total_pages(); $i++){

	if($i==$page){

		echo " <span class =\"selected\">{$i}</span>";

		echo "&nbsp";

	}else{


	echo " <a style='color: white;' href =\"index1.php?page={$i}\">{$i} </a> ";

	echo "&nbsp";}
}
	echo " &nbsp";

	if($pagination->has_next_page()){

		echo "<a style='color: white;' href =\"index1.php?page=";

		echo $pagination->next_page();

		echo "\">Next &raquo; </a>";

	}

}
?>
</div>
<?php include_layout_template('footer.php'); ?>
