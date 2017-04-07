<?php
class eeBooks {

	const INDEPENDENT_EBOOK_PAGE_ID = 0; // When this post doesn't belong to a page, then the post's page ID will be 0;
	
    private $db;

    public function __construct($db) {
         $this->db = $db;
    }

	public static function saveBook($userID, $data, $cover){

		global $db;
        
        $data = array_map('trim', $data);
        
        if( $data['title'] == '' || $data['supdate'] || $cover == null)
        {
            //buckys_add_message(MSG_USERNAME_EMPTY_ERROR, MSG_TYPE_ERROR);
            return false;
        }
        
        //Check Email Duplication //checknameduplication
        /*if( BuckysUser::checkEmailDuplication($data['email']) )
        {
            buckys_add_message(MSG_EMAIL_EXIST, MSG_TYPE_ERROR);
            return false;
        }*/
        
        //Create New Account
        /*$newId = $db->insertFromArray(TABLE_EBOOKS, array(
        	'userID' => $userID,
            'title' => $data['title'],
            'content' => $data['content'],
            'cover' => $cover,
            'date' => date('Y-m-d H:i:s'),
            //'thumbnail' => '',
        ));*/
        
        $title2 = $data['title'];
        $content2 = $data['supdate'];

        $userID = mysqli_real_escape_string($this->db,$userID);
        $query = mysqli_query($this->db,"INSERT INTO ebooks (userID, title, content, cover) VALUES ('$userID', '$title2', '$content2', '$cover')") or die(mysqli_error($this->db));
        die($query);
        /*if(!$newId)
        {
            //buckys_add_message($db->getLastError(), MSG_TYPE_ERROR);
            return false;
        }
        return $newId;*/
	}

	    /**
    * Get Top Posts or Images
    * 
    * 
    * @param String $period
    * @param String $type
    */
    public static function getTopeBooks($pageID=eBooks::INDEPENDENT_EBOOK_PAGE_ID)
    {
        global $db;
                      
                $query = "
                    SELECT DISTINCT(ebookID), title, content, cover, date FROM " . TABLE_EBOOKS . "                    
                                        
                    ORDER BY RAND()
                    LIMIT 24
                ";

        $rows = $db->getResultsArray($query);
        
        return $rows; 
    }
}
?>