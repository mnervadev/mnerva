<!--
  Author: Lucas Simioni
  Title: Mnerva Prototype Design
  Description:  Recreating the youtube layout to accommodate books
  Version: 0.4
  Last Updated: December 24th
    Recent Changes: Upload Progress Bar
                  : Collect all data and prepare for Back End
                  : Show Data Report
 -->

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Mnvera</title>
  <meta name="description" content="">
  <meta name="author" content="MNERVA">
  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link href="https://cdn.quilljs.com/1.1.7/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.min.css">
   <link rel="stylesheet" href="css/navbar.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

  

</head>
<body>
  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="site-wrap">
  <?php include "incl/header.php";?>

    <script>
    function toggleDiv(id) {
    var div = document.getElementById(id);
    div.style.display = div.style.display == "none" ? "initial" : "none";
    }
    
    function toggleDivs(id) {
    toggleDiv('pbox');
    var div = document.getElementById(id);
    div.style.display = div.style.display == "none" ? "initial" : "none";
    }
    </script>

    <div class="main-container">
      <ul class="side-bar">
        <li class="side-bar--item active">
          <a href="#"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-fire" aria-hidden="true"></i>Trending</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-history" aria-hidden="true"></i>Recently Opened</a>
        </li>
        <li class="side-bar--item heading">
          Categories
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-play accent" aria-hidden="true"></i>Music</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-futbol-o accent" aria-hidden="true"></i>Sports</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-gamepad accent" aria-hidden="true"></i>Gaming</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-video-camera accent" aria-hidden="true"></i>Movies</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-television accent" aria-hidden="true"></i>TV Shows</a>
        </li>
        <li class="side-bar--item ">
          <a href="#"><i class="fa fa-newspaper-o accent" aria-hidden="true"></i>News</a>
        </li>
      </ul><!-- end of side-bar -->

      <div class="main-content">

        <div class="main-content_tab-bar">
          <span class="tab-bar_tab tab-home active" data-panel="panel-home" onclick="switchMainPanel(event)">Home</span>
          <span class="tab-bar_tab tab-following" data-panel="panel-following" onclick="switchMainPanel(event)">Following</label>
        </div><!-- end of main-content _ tab-bar -->

        <div class="main-content_tab-panels">

          <div class="panel panel-home active" id="panel-home">
            <div class="grid-list">

              <h4 class="grid-list_row--heading">Recently Opened:</h4>
              <div class="grid-list_row-container">
                <div class="grid-list_row--nav">
                  <span class="grid-list_row--nav_btn nav-btn_prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                  <span class="grid-list_row--nav_btn nav-btn_next"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                </div>
                <ul class="grid-list_row">

    <?php 
    include_once 'functions/dbCon.php';
    include_once 'incl/classes/class.eBooks.php';
    $eBooks = new eBooks($db);
    $ebooksInfo = $eBooks->getTopeBooks();?>
            <?php foreach($ebooksInfo as $keys)
            {
            ?>
                  <li class="grid-list_row--item">
                  <a href="http://mnerva.ca/book/?q=uploads/<?php echo explode('/',$keys['upload_file_name'][1]);?>">
                    <div class="book-card_container">
                      <img class="book-card_image" src="#" >
                      <a class="book-card_link" href="#"><?php echo $keys['title'];?></a>
                      <p class="book-card_author">
                        <?php $userName = $eBooks->getAuthorFromUserID($keys['userID']);
                        echo $userName['username'];?>
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                    </a>
                  </li><!-- end of grid--item -->
            <?php
            }
            ?>

                </ul><!-- end of grid-list_row-->
              </div><!-- end of grid-list_row-container -->


              <h4 class="grid-list_row--heading">Following:</h4>
              <div class="grid-list_row-container">
                <div class="grid-list_row--nav">
                  <span class="grid-list_row--nav_btn nav-btn_prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                  <span class="grid-list_row--nav_btn nav-btn_next"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                </div>
                <ul class="grid-list_row">

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->
                </ul>
              </div><!-- end of grid-list_row-container -->


              <h4 class="grid-list_row--heading">Trending:</h4>
              <div class="grid-list_row-container">
                <div class="grid-list_row--nav">
                  <span class="grid-list_row--nav_btn nav-btn_prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                  <span class="grid-list_row--nav_btn nav-btn_next"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                </div>
                <ul class="grid-list_row">

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->
                </ul>
              </div><!-- end of grid-list_row-container -->


              <h4 class="grid-list_row--heading">Spotlight:</h4>
              <div class="grid-list_row-container">
                <div class="grid-list_row--nav">
                  <span class="grid-list_row--nav_btn nav-btn_prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                  <span class="grid-list_row--nav_btn nav-btn_next"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                </div>
                <ul class="grid-list_row">

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->

                  <li class="grid-list_row--item">
                    <div class="book-card_container">
                      <img class="book-card_image" src="http://placehold.it/128x192" />
                      <a class="book-card_link" href="#">Sample Link with a really long title</a>
                      <p class="book-card_author">
                        Mnerva
                      </p>
                      <span class="book-card_note-count">290971 Notes</span>
                    </div>
                  </li><!-- end of grid--item -->
                </ul>
              </div><!-- end of grid-list_row-container -->

            </div><!-- end og grid-list -->
          </div><!-- end of panel-home -->

          <div class="panel panel-following"  id="panel-following">

          </div>
        </div><!-- end of tab-panels -->


        <div class="popup popup-upload ">
          <header class="popup-header">
            <div class="row center end">
              <span class="modal-btn expand"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
              <span class="modal-btn close"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
          </header>
          <div class="popup-content">
            <div class="row">
              <div class="popup-sidebar">
                <canvas class="thumbnail-canvas"></canvas>
                <img class="upload_sidebar--img-preview" src="http://placehold.it/192x288/ffffff/323232?text=Preview" id="placeholder"/>
                <img class="upload_sidebar--img" src="" id="thumbnail-img"/>
                <h4>Upload Status:</h4>
                <p class="text-sm m-05" id="upload-status-text">
                  Pending
                </p>
                <p class="link text-md">
                  Your upload will be at: <a href="#" id="upload-link-text">Link Generated by PHP</a>
                </p>
              </div><!-- end of popup-sidebar-->
              <div class="popup-main">
                <div class="settings_tab-bar">
                  <span class="tab-bar_tab tab-basic active" data-panel="panel-basic" onclick="switchSettingPanel(event)">Basic Info</span>
                  <span class="tab-bar_tab tab-advanced"  data-panel="panel-advanced" onclick="switchSettingPanel(event)">Advanced</span>
                </div>
                <div class="settings_panel panel-basic active">
                  <div class="settings_panel-column w-60">
                    <div class="settings_panel-option-container">
                      <input type="text"
                             class="settings_panel-option--input"
                             name="upload-title"
                             placeholder="Title"
                             id="upload-title"
                             required>
                    </div><!-- end of option-container -->
                    <div class="settings_panel-option-container">
                      <div id="upload-desc"></div>
                      <!--
                      <textarea class="settings_panel-option--input textarea"
                                name="upload-desc"
                                placeholder="Description" required></textarea>-->
                    </div><!-- end of option-container -->
                    <div class="settings_panel-option-container">
                      <input type="text"
                             class="settings_panel-option--input tags"
                             name="upload-tags"
                             id="upload-tags"
                             placeholder="Tags ( eg. Physics, Biology, Computer Science)">
                    </div><!-- end of option-container -->

                  </div><!-- end of settings_panel-column LEFT-->

                  <div class="settings_panel-column w-40">
                    <div class="settings_panel-option-container">
                      <select class="settings_panel-option--input select"
                              name="upload-privacy"
                              id="upload-privacy">
                              <option value="public">Public</option>
                              <option value="unlisted">Unlisted</option>
                              <option value="private">Private</option>
                      </select>
                    </div><!-- end of option-container -->
                    <div class="settings_panel-option-container row">
                      <img src="http://placehold.it/50x50" class="settings_panel--user-avatar" />
                      <textarea class="settings_panel-option--input textarea user-message"
                                name="upload-message"
                                id="upload-message"
                                placeholder="Add a message to your upload"></textarea>
                    </div><!-- end of option-container -->
                    <div class="settings_panel-option-container">
                      <p class="option-desc row center">Also share on <input type="checkbox"
                             class="settings_panel-option--input checkbox"
                             name="share-facebook"
                             id="share-facebook">
                      <label for="share-facebook">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
                      </label>
                    </p>
                    </div><!-- end of option-container -->
                    <div class="settings_panel-option-container">
                      <span class="btn upload-addto-library_btn">+ Add to Libary</span>
                      <ul class="library-popup-container">
                        <li class="library-popup_option">
                          <input type="text"
                                 class="settings_panel-option--input"
                                 name="upload-library-search"
                                 placeholder="Search..">
                        </li>
                        <li class="library-popup_option">
                          Library 1
                        </li>
                        <li class="library-popup_option">
                          Library 2
                        </li>
                      </ul>
                    </div><!-- end of option-container -->

                    <h5 class="option-title">Custom Thumbnail</h5>
                    <div class="settings_panel-option-container row">
                      <input type="file"
                             class="settings_panel-option--input file"
                             name="upload-thumbnail"
                             accept="image/*"
                             id="upload-thumbnail"
                             accept="image/*">
                      <label for="upload-thumbnail"
                             class="upload-thumbnail_btn btn">
                             Custom Thumbnail
                      </label>
                      <p class="option-desc">
                        Maximum filesize is 2MB
                      </p>
                    </div><!-- end of option-container -->

                  </div><!-- end of settings_panel-column RIGHT-->



                </div>
                <div class="settings_panel panel-advanced">

                  <div class="settings_panel-column w-50">

                    <h5 class="option-title">Community</h5>
                    <div class="settings_panel-option-container">
                      <div class="row center">
                        <input type="checkbox"
                               class="settings_panel-option--input checkbox"
                               name="upload-comments"
                               id="upload-comments">
                        <label for="upload-comments"
                               class="settings_panel-option--label">
                               Allow Comments
                        </label>
                      </div>
                      <div class="row center">
                        <label class="settings_panel-option--label offset">
                          Show
                        </label>
                          <select class="settings_panel-option--input select wa"
                                  name="upload-show"
                                  id="show-comments">
                                  <option value="all">All</option>
                                  <option value="approved">Approved</option>
                          </select>
                      </div>
                      <div class="row center">
                        <label class="settings_panel-option--label offset">
                          Sort By
                        </label>
                          <select class="settings_panel-option--input select wa"
                                  name="upload-sort"
                                  id="sort-comments">
                                  <option value="top">Top comments</option>
                                  <option value="new">Newest first</option>
                          </select>
                      </div>
                      <div class="row center">
                        <input type="checkbox"
                               class="settings_panel-option--input checkbox"
                               name="upload-ratings"
                               id="upload-ratings">
                        <label for="upload-ratings"
                               class="settings_panel-option--label">
                               Users can view ratings for this title
                        </label>
                      </div>
                      <div class="row center">
                        <input type="checkbox"
                               class="settings_panel-option--input checkbox"
                               name="upload-registered-download"
                               id="upload-registered-download">
                        <label for="upload-registered-download"
                               class="settings_panel-option--label">
                               Allow registered users to download
                        </label>
                      </div>
                      <div class="row center">
                        <input type="checkbox"
                               class="settings_panel-option--input checkbox"
                               name="upload-repost"
                               id="upload-repost">
                        <label for="upload-repost"
                               class="settings_panel-option--label">
                               Allow reposts
                        </label>
                      </div>
                    </div><!-- end of option-container -->
                    <!--
                    <h5 class="option-title">Category</h5>
                    <div class="settings_panel-option-container">
                        <select class="settings_panel-option--input select"
                                name="upload-category"
                                id="upload-category" >
                          <option value="arts-entertainment">Arts & Entertainment</option>
                          <option value="business">Business</option>
                          <option value="blogs-people">Blogs & People</option>
                          <option value="education-howto">Education & How-to</option>
                          <option value="fiction">Fiction</option>
                          <option value="health">Health & Well Being</option>
                          <option value="history">History</option>
                          <option value="home-lifestyle">Home & Lifestyle</option>
                          <option value="kids">Kids</option>
                          <option value="news-politics">News & Politics</option>
                          <option value="science-technology">Science & Technology</option>
                          <option value="sports">Sports</option>
                          <option value="spiritual-culture">Spirituality & Culture</option>
                          <option value="other">Other</option>
                        </select>
                      </div><!-- end of option-container -->
                      <!--
                      <h5 class="option-title">Community Contributions</h5>
                      <div class="settings_panel-option-container">
                        <div class="row center">
                          <input type="checkbox"
                                 class="settings_panel-option--input checkbox"
                                 name="upload-contributions"
                                 id="upload-contributions">
                          <label for="upload-contributions"
                                 class="settings_panel-option--label">
                                 Allow users to contribute translated titles, descriptions, subtitles/CC
                          </label>
                        </div>
                      </div><!-- end of option-container -->


                  </div><!-- end of settings_panel column left -->

                  <div class="settings_panel-column w-50">

                    <h5 class="option-title">Monetization</h5>
                    <div class="settings_panel-option-container disabled">
                      <div class="row center">
                        <input type="radio"
                               class="settings_panel-option--input radio wa"
                               name="upload-monetize"
                               id="upload-paid"
                               disabled>
                        <label for="upload-paid"
                               class="settings_panel-option--label">
                               Paid Submission
                        </label>
                      </div>
                      <p class="option-desc offset">
                        Submit your material to sell on our platform
                      </p>
                      <div class="row center">
                        <input type="radio"
                               class="settings_panel-option--input radio wa"
                               name="upload-monetize"
                               id="upload-ads"
                               disabled>
                        <label for="upload-ads"
                               class="settings_panel-option--label">
                               Third Party Media
                        </label>
                      </div>
                      <p class="option-desc offset">
                        Make your content support advertisements
                      </p>
                    </div><!-- end of option-container -->

                    <h5 class="option-title">Written Date</h5>
                    <div class="settings_panel-option-container">
                      <div class="row center">
                        <input type="text"
                               class="settings_panel-option--input"
                               name="upload-written-date"
                               id="written-date"
                               placeholder="MM-DD-YYYY">
                               <button type="button"
                                       class="today_date_btn btn"
                                       name="today_date_btn">
                                       Today
                               </button>
                      </div>
                    </div><!-- end of option-container -->

                    <h5 class="option-title">Category</h5>
                    <div class="settings_panel-option-container">
                        <select class="settings_panel-option--input select"
                                name="upload-category"
                                id="upload-category" >
                          <option value="arts-entertainment">Arts & Entertainment</option>
                          <option value="business">Business</option>
                          <option value="blogs-people">Blogs & People</option>
                          <option value="education-howto">Education & How-to</option>
                          <option value="fiction">Fiction</option>
                          <option value="health">Health & Well Being</option>
                          <option value="history">History</option>
                          <option value="home-lifestyle">Home & Lifestyle</option>
                          <option value="kids">Kids</option>
                          <option value="news-politics">News & Politics</option>
                          <option value="science-technology">Science & Technology</option>
                          <option value="sports">Sports</option>
                          <option value="spiritual-culture">Spirituality & Culture</option>
                          <option value="other">Other</option>
                        </select>
                      </div><!-- end of option-container -->
                      <!--
                    <h5 class="option-title">Downloads</h5>
                    <div class="settings_panel-option-container">
                      <div class="row center">
                        <input type="checkbox"
                               class="settings_panel-option--input checkbox"
                               name="upload-download"
                               id="upload-download">
                        <label for="upload-download"
                               class="settings_panel-option--label">
                               Disable downloading of this content
                        </label>
                      </div>
                    </div><!-- end of option-container -->

                  </div><!-- end of settings panel column right -->

                </div>
              </div>
              </div>
            </div><!-- end of row -->
            <div class="row center w">
              <div class="upload_fileselect">
                <input type="file"
                       class="upload_fileselect--input"
                       name="upload-file"
                       id="upload-file"
                       accept="application/msword, text/plain, application/pdf, image/*, .epub"
                       required>
                <label for="upload-file"
                       class="upload_fileselect--label btn">
                       Select File
                </label>
              </div>
              <div class="upload_progress-bar">
                <div class="upload_progress-bar--front" id="progress_bar">
                  0%
                </div>
              </div>
              <div class="upload_submit">
                <button type="button"
                        class="upload_submit_btn btn btn_primary"
                        name="upload_submit-btn"
                        id="upload-publish">
                        Publish
                </button>
              </div>
            </div><!--end of row -->
          </div>
        </div>


    </div><!-- end of main-container -->
    <div class="footer"></div>



  </div><!-- end of site-wrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
  <script src='js/lightsoff.js'></script>
  <script src="js/slider.min.js"></script>
  <script src="js/quill.core.js"></script>
  <script src="js/quill.min.js"></script>
  <script src="https://rawgithub.com/mozilla/pdf.js/gh-pages/build/pdf.js"></script>
  <script src="js/main.min.js"></script>
   <script>
        var videoSelector = $('#html5');
        // Initialize with some custom config
        videoSelector.lightsOff({
            color: '#222',
            switchSelector: '#switch-button',
            durationLightsOff: 1000,
            durationLightsOn: 1000,
            allowScrolling: false
        });

        videoSelector.on('play playing', function() {
            videoSelector.lightsOff('show');
        });
        videoSelector.on('pause ended', function() {
            videoSelector.lightsOff('hide');
        });

        // Pause video when the overlay hidden (usually when the user clicks the overlay itself)
        $(document).on('lightsOn', function() {
            videoSelector.get(0).pause()
        });
    </script>
</body>
</html>
