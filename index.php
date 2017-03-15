<?php include("incl/header.php"); ?>
      <div class="main-content">

        <div class="main-content_tab-panels">

          <div class="panel panel-home active">
            <div class="grid-list">
            <?php 
			if(isset($_SESSION['uid'])){
			$ruid = $_SESSION['uid'];	
			$books = "SELECT r.id,r.uid,r.ebookID,r.time,e.title,e.ebookID,user,notes, e.upload_file_name FROM recent AS r LEFT JOIN ebooks  AS e ON r.ebookID=e.ebookID WHERE r.uid='$ruid' GROUP BY r.ebookID ORDER BY MAX(r.id) DESC";
			$booksdata = mysqli_query($db,$books);
            ?>
              <h4 class="grid-list_row--heading">History:</h4>
              <div class="grid-list_row-container">
              
                <div class="slick">
                    <?php while($book=mysqli_fetch_assoc($booksdata)){ 
				   ?>
                  <div class="grid-list_row--item">
		 <a href="http://mnerva.online/book/?q=uploads/<?php echo explode('/',$book['upload_file_name'])[1];?>" >
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$book['upload_file_name'])[1];?>">
                      <p class="book-card_link"><?php echo $book['title'];?></p>
                       <div class="book-card-mini-list">
                          <p title="Username of uploader" style="width:100%;display:block">
                               <?php echo $book['user']; ?>
                          </p>
                          <p title="Notes" style="display:inline-block" >
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              <?php
                              if($book['notes'] >0){
                                  echo $book['notes'];
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
               <?php } ?>

                </div><!-- end of grid-list_row-->
             </div><!-- end of grid-list_row-container -->
              
			  <!-- end of grid-list_row-container -->
               <?php } ?>

              <h4 class="grid-list_row--heading">Trending:</h4>
              <div class="grid-list_row-container">
                 <div class="slick">
                    <?php
                    $trend = "SELECT * FROM ebooks";
			        $trenddata = mysqli_query($db,$trend);
                    while($trend=mysqli_fetch_assoc($trenddata)){ 
				   ?>
                  <div class="grid-list_row--item">
				    <a href="http://mnerva.online/book/?q=uploads/<?php echo explode('/',$trend['upload_file_name'])[1];?>" >
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$trend['upload_file_name'])[1];?>">
                      <p class="book-card_link"><?php echo $trend['title'];?></p>
                       <div class="book-card-mini-list">
                          <p title="Username of uploader" style="width:100%;display:block">
                               <?php echo $trend['user']; ?>
                          </p>
                          <p title="Notes" style="display:inline-block" >
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              <?php
                              if($trend['notes'] >0){
                                  echo $trend['notes'];
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
               <?php } ?>

                </div><!-- end of grid-list_row-->
              </div><!-- end of grid-list_row-container -->


              <h4 class="grid-list_row--heading">Spotlight:</h4>
              <div class="grid-list_row-container">
                <div class="slick">
                    <?php
                    $trend = "SELECT * FROM ebooks ";
			        $trenddata = mysqli_query($db,$trend);
                    while($trend=mysqli_fetch_assoc($trenddata)){ 
				   ?>
                  <div class="grid-list_row--item">
				    <a href="http://mnerva.online/book/?q=uploads/<?php echo explode('/',$trend['upload_file_name'])[1];?>" >
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$trend['upload_file_name'])[1];?>">
                      <p class="book-card_link"><?php echo $trend['title'];?></p>
                       <div class="book-card-mini-list">
                          <p title="Username of uploader" style="width:100%;display:block">
                               <?php echo $trend['user']; ?>
                          </p>
                          <p title="Notes" style="display:inline-block" >
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              <?php
                              if($trend['notes'] >0){
                                  echo $trend['notes'];
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
               <?php } ?>

                </div><!-- end of grid-list_row-->
              </div><!-- end of grid-list_row-container -->

            </div><!-- end og grid-list -->
          </div><!-- end of panel-home -->

          <div class="panel panel-following"  id="panel-following">

          </div>
        </div><!-- end of tab-panels -->


       
        </div>


    </div><!-- end of main-container -->
<script>
    $('.slick').slick({
  centerMode: true,
  centerPadding: '5px',
  slidesToShow: 6,
  prevArrow:"<span class='prev-ar grid-list_row--nav_btn'><i class='fa fa-chevron-left' aria-hidden='true'></i></span>",
  nextArrow:"<span class='next-ar grid-list_row--nav_btn'><i class='fa fa-chevron-right' aria-hidden='true'></i></span>",
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '50px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '50px',
        slidesToShow: 1
      }
    }
  ]
});
</script>
<script>startApp();</script>
  
<?php include("incl/footer.php"); ?>

