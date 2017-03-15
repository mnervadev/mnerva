<?php
	$query = isset($_GET['site-search']) ? $_GET['site-search'] : '';
	include_once ('functions/0con.php');
	include_once ('incl/classes/class.search.php'); 
    include ('incl/header.php');
    
    ?>

<style type="text/css">
    .grid-list_row-container{
        height:auto;
    }
    .grid-list_row--item{
        display:inline-block;
        width:175px;
        margin:10px;
        text-align:left;
    }
    .book-card_link{
        width: 100%;
        text-decoration:none;
    }
</style>



      <div class="main-content">
         <div class="main-content_tab-panels">

          <div class="panel panel-home active">
		
		
	     <?php $items = select('*','ebooks','CONCAT(title," ", content) LIKE "%'.$query.'%"',null,null,false,'i');?>
		 <?php if($items[0]){ ?>
		 <div class="search-h">
		    <p>You searched for: <span class="search-q"><?php echo $query;?></span></p>
		 </div>
		 <div class="grid-list">
		 <div class="grid-list_row-container">
		     <center>
              <?php foreach($items as $keys){
			     $us = select('uid,username','users','uid="'.$keys['userID'].'"',null,null,true);
				 if($us['count']){
					 $user = $us['username'];
				 }else{
					 $user='Mnerva';
				 }
				 ?>
                  
                      <div class="grid-list_row--item">
				    <a href="http://mnerva.ca/book/?q=uploads/<?php echo explode('/',$keys['upload_file_name'])[1];?>">
                    <div class="book-card_container canvas2" data-cover="<?php echo explode('/',$keys['upload_file_name'])[1];?>">
                      <p class="book-card_link"><?php echo $keys['title'];?></p>
                      <ul class="book-card-mini-list">
                          <li title="Username of uploader" style="width:100%;display:block">
                               Ryan Kamal
                          </li>
                          <li title="notes" style="width:35%">
                              <i class="fa fa-globe" aria-hidden="true"></i>
                              2215
                          </li>
                          <li title="Upload date" style="width:60%;margin-left:-15px">
                              •
                               3 months ago
                          </li>
                      </ul>
                      
                    </div>
					</a>
				  </div>
                  
               <?php } ?>
               </center>
                
             </div><!-- end of grid-list_row-container -->
		 </div>
		 
		 
		 
		 <?php }else {?>
		 <p class="n-s">No Results Found</p>
		 <?php } ?>
		 
	   </div>
	   </div>
	   </div>
        


        

    <?php include('incl/footer.php'); ?>

