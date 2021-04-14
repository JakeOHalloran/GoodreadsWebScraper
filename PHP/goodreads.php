<?php
  require_once('simple_html_dom.php');

  class Goodreads {
    private $html;

    function __construct() {
      $this->html = new simple_html_dom();
    }

    public function getBooks($authorPageURL) {
      return $this->getBookList($authorPageURL); // the authors goodreads page url
    }

    // Get the amazon page link for a book on goodreads
    private function getBookList($authorPageURL) {
      // some author page urls have noise on the end (after '?' in the url); if it exists on this url, remove it
      $returned = explode("?", $authorPageURL, 2);
      $authorPageURL = $returned[0];
      
      $webpage = $this->cURL($authorPageURL);
      $this->html->load($webpage);
      
      $bookListURL = "";

      $bookPageURLs = []; // each book on author page contains a link to its own page (which has the book description, rating, reviews)
      $bookCovers = [];
      $bookTitles = [];
      $books = [];

      //error_log("clean author page: ".$authorPageURL);

      if(empty($this->html)) {
        error_log("Couldnt grab the html page in getBookList()");
      } else {
        // get the authors books list url from the author page url
        if(($uniqueAuthorIDstartingPos = strpos($authorPageURL, 'show/')) !== false)
        {
          $uniqueAuthorID = substr($authorPageURL, $uniqueAuthorIDstartingPos + 5);
          $bookListURL = "https://www.goodreads.com/author/list/".$uniqueAuthorID."?page=1";

          //error_log("hksdfj ".$bookListURL);
        }

        $this->html->clear();
      }

      // we have the book list page url now so load it
      $webpage = $this->cURL($bookListURL);
      $this->html->load($webpage);

      if(empty($this->html)) {
        error_log("Couldnt grab the html page in getBookList()");
      } else {
        foreach ($this->html->find('tr[itemtype=http://schema.org/Book]') as $bookDiv) { // get book page links and book title
          $bookTitle = $bookDiv->find('a[title]', 0)->title;
          $bookPageLink = "https://www.goodreads.com".$bookDiv->find('a[title]', 0)->href;
          $bookImageLink = $bookDiv->find('img.bookCover', 0)->src;

          //error_log("Title = ".$bookTitle);
          //error_log("Link = ".$bookPageLink);

          //https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1582813510i/51829218._SX50_.jpg

          if(($imageSizeStartingPos = strpos($bookImageLink, '._')) !== false)
          {
            error_log("image = ".$bookImageLink);

            $bookImageWidth = substr($bookImageLink, $imageSizeStartingPos);

            error_log("image width string = ".$bookImageWidth);

            $bookImageLink = str_replace($bookImageWidth, "._SX500_.jpg", $bookImageLink);
          }

          $bookPageURLs[] = [ 'bookPageURL' => $bookPageLink ];
          $bookTitles[] = [ 'title' => $bookTitle ];
          $bookCovers[] = [ 'coverURL' => $bookImageLink ];
        }

        /*$count = 1;

        foreach ($this->html->find('img.a-thumbnail-left') as $image) { // get the most popular books covers
          if ($count > 2) { break; }

          // The image for it isnt great, so we get the img src
          // We get the img name from the img src, send it to the front end, for it to use to get better img from amazon IMG api
          if(($imgNameStarts = strpos($image->src, 'I/')) !== false)
          {
            $new_str = substr($image->src, $imgNameStarts + 2);

            $returned = explode(".", $new_str, 2);
            $imgName = $returned[0];

            $bookCovers[] = [ 'cover' => $imgName ];
          }

          $count++;
        }*/

        // save the url, book title and covers in same array to return
        for($i = 0; $i < sizeof($bookTitles); $i++) {
          $books[] = [ 'id' => $i, 'bookPageURL' => $bookPageURLs[$i]['bookPageURL'], 'title' => $bookTitles[$i]['title'], 'coverURL' => $bookCovers[$i]['coverURL']];
        }

        $this->html->clear();
        unset($this->html);
  
        return $books;
      }
    }

    private function cURL(string $url) {
      $curl = curl_init();

      if (!$curl) { die("Couldn't initialize a cURL handle"); }

      // Set the file URL to fetch through cURL
      curl_setopt($curl, CURLOPT_URL, $url);

      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_FAILONERROR, true);

      // Return the actual result of the curl result instead of success code
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
      curl_setopt($curl, CURLOPT_TIMEOUT, 10);

      curl_setopt($curl, CURLOPT_ENCODING, '');

      // Do not check the SSL certificates
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $ret = curl_exec($curl);

      if (curl_errno($curl)) {
        curl_close($curl);
        return 'cURL error: ' . curl_error($curl);
      } else {
        curl_close($curl);

        if (empty($ret)){
          error_log("Nothing returned from url");
          return null;
        } else { return $ret; }
      }

      unset($curl);
    }
  }
?>
