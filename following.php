<?php 
include("incl/header.php"); 
if(isset($_SESSION['uid'])){
		
		$se = $data[0]['ebookID'];
		$uid = $_SESSION['uid'];
}
?>
<style type="text/css">
    .grid-list_row-container{
        height:auto;
    }
    .grid-list_row--item{
        display:inline-block;
        width:175px;
        margin:10px;
        border:none;
    }
    .book-card_link{
        text-align:left;
        color:#4885ED;
        width: 100%;
        text-decoration:none;
    }
    .book-card-mini-list{
        text-align:left;
        border:none;
    }
</style>

      <div class="main-content">

        <div class="main-content_tab-bar">
            </div>
        <div class="main-content_tab-panels">

          <div class="panel panel-home active">
              
             <div class="grid-list">
		 <div class="grid-list_row-container">
		     <center>
             <?php
             
             $sql = "select * from ebooks right join reposts on ebooks.ebookID = reposts.ebookID where uid = '$uid'";
             $result = mysqli_query($db,$sql);
             if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
				    ?>
				    <div class="grid-list_row--item">
				    <a href="http://mnerva.ca/book/?q=uploads/<?php echo$row['upload_file_name']; ?>">
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$row['upload_file_name'])[1];?>">
                      <p class="book-card_link"><?php echo $row['title'];?></p>
                      <div class="book-card-mini-list">
                          <p title="Username of uploader" style="width:100%;display:block">
                              <i class="fa fa-retweet" aria-hidden="true" ></i>
                               <?php echo $row['user']; ?>
                          </p>
                          <p title="Notes" style="display:inline-block" >
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              <?php
                              if($row['notes'] >0){
                                  echo $row['notes'];
                              }else{
                                  echo'0';
                              }
                               ?>
                          </p>
                          <p title="Upload date" style="display:inline-block">
                              •
                               3 months ago
                          </p>
                      </div>
                      
                    </div>
					</a>
				  </div>
				    
				<?php }} ?>
			
             <?php
             
             $sql = "select * from ebooks where userID = '$uid'";
             $result = mysqli_query($db,$sql);
             if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
				    ?>
				    <div class="grid-list_row--item">
				    <a href="http://mnerva.ca/book/?q=uploads/<?php echo$row['upload_file_name']; ?>">
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$row['upload_file_name'])[1];?>">
                      <p class="book-card_link"><?php echo $row['title'];?></p>
                      <div class="book-card-mini-list">
                          <p title="Username of uploader" style="width:100%;display:block">
                               <?php echo $row['user']; ?>
                          </p>
                          <p title="Notes" style="display:inline-block" >
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              <?php
                              if($row['notes'] >0){
                                  echo $row['notes'];
                              }else{
                                  echo'0';
                              }
                               ?>
                          </p>
                          <p title="Upload date" style="display:inline-block">
                              •
                               3 months ago
                          </p>
                      </div>
                      
                    </div>
					</a>
				  </div>
				    
				<?php }} ?>
				</center>
                
             </div><!-- end of grid-list_row-container -->
		 </div>
          </div>
        </div><!-- end of tab-panels -->

</div><!-- end of main-content _ tab-bar -->
       
        </div>


    </div><!-- end of main-container -->

  
<?php include("incl/footer.php"); ?>

