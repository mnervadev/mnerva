<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Language" content="en-us">
    <title>PHP MySQL Typeahead Autocomplete</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script>
        $(document).ready(function(){
          $("#search-box").keyup(function(){
            $.ajax({
            type: "POST",
            url: "autosuggest.php",
            data:'keyword='+$(this).val(),
            beforeSend: function(){
              $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
              $("#suggesstion-box").show();
              $("#suggesstion-box").html(data);
              $("#search-box").css("background","#FFF");
            }
            });
          });
        });
        //To select country name
        function selectCountry(val) {
        $("#search-box").val(val);
        $("#suggesstion-box").hide();
        }
      </script>


</head>

<body>
    <div class="content">
      <div class="frmSearch">
        <input type="text" id="search-box" placeholder="Country Name" />
        <div id="suggesstion-box"></div>
      </div>
    </div>
</body>
</html>

<?php
    include_once 'functions/dbCon.php';
    if(!empty($_POST["keyword"])) {
    $query ="SELECT title FROM ebooks WHERE title like '" . $_POST["keyword"] . "%' ORDER BY title LIMIT 0,6";
    $result = $db->query($query);
    if(!empty($result)) {
    ?>
    <ul id="country-list">
    <?php
    foreach($result as $country) {
    ?>
    <li onClick="selectCountry('<?php echo $country["title"]; ?>');"><?php echo $country["title"]; ?></li>
    <?php } ?>
    </ul>
    <?php } } ?>