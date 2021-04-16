<?php
  require_once('simple_html_dom.php');

  class Goodreads {
    private $html;

    function __construct() {
      $this->html = new simple_html_dom();
    }

    // get an array of books by an author
    public function getBooks($authorPageURL, $limit) {
      return $this->getBookList($authorPageURL, $limit);
    }

    // get a single book by an author
    public function getBook($bookPageURL) {
      return $this->getBookInfo($bookPageURL);
    }

    private function getBookList($authorPageURL, $limit) {
      // some author page urls have noise on the end (after '?' in the url); if it exists on this url, remove it
      $returned = explode("?", $authorPageURL, 2);
      $authorPageURL = $returned[0];
      
      // get the authors books list page
      $webpage = $this->cURL($authorPageURL);
      $this->html->load($webpage);
      
      $bookListURL = "";
      $bookPageURLs = []; // each book on author page contains a link to its own page (which has the book description, rating, reviews)
      $bookCovers = [];
      $bookTitles = [];
      $books = [];

      if(empty($this->html)) {
        error_log("Couldnt grab the html page in getBookList()");
      } else {
        // get the authors books list url from the author page url
        if(($uniqueAuthorIDstartingPos = strpos($authorPageURL, 'show/')) !== false) {
          $uniqueAuthorID = substr($authorPageURL, $uniqueAuthorIDstartingPos + 5);
          $bookListURL = "https://www.goodreads.com/author/list/".$uniqueAuthorID."?page=1&per_page=".$limit;
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

          // the book image url will be for a small image, change the url to request a larger one
          if(($imageSizeStartingPos = strpos($bookImageLink, '._')) !== false) {
            $bookImageWidth = substr($bookImageLink, $imageSizeStartingPos);
            $bookImageLink = str_replace($bookImageWidth, "._SX500_.jpg", $bookImageLink);
          }

          $bookPageURLs[] = [ 'bookPageURL' => $bookPageLink ];
          $bookTitles[] = [ 'title' => $bookTitle ];
          $bookCovers[] = [ 'coverURL' => $bookImageLink ];
        }

        // save the url, book title and covers in same array to return
        for($i = 0; $i < sizeof($bookTitles); $i++) {
          $books[] = [ 'id' => $i, 'bookPageURL' => $bookPageURLs[$i]['bookPageURL'], 'title' => $bookTitles[$i]['title'], 'coverURL' => $bookCovers[$i]['coverURL']];
        }

        $this->html->clear();
        unset($this->html);
  
        return $books;
      }
    }

    private function getBookInfo($bookPageURL) {
      $webpage = $this->cURL($bookPageURL);
      $this->html->load($webpage);
      
      $bookTitle = "";
      $bookDescription = "";
      $bookRating = "";
      $bookRatings = "";
      $bookReview = "";
      $coverURL = "";
      $booksInfo = [];
      $count = 1;

      // we have the book list page url now so load it
      $webpage = $this->cURL($bookPageURL);
      $this->html->load($webpage);

      if(empty($this->html)) {
        error_log("Couldnt grab the html page in getBookInfo()");
      } else {
        $bookTitle = $this->html->find('#bookTitle', 0)->innertext;
        $bookDescription = $this->html->find('#description', 0)->find("span[display=none]", 0);
        
        foreach ($this->html->find('#description span') as $bookDescriptionDiv) { // page will have 2 descriptions, we want the second one
          if($count == 2) {
            $bookDescription = $bookDescriptionDiv->innertext;
          }

          $count++;
        }

        $bookImageLink = $this->html->find('div.editionCover img', 0)->src;
        $bookRatings = $this->html->find('meta[itemprop=ratingCount]', 0)->content;
        $bookReviews = $this->html->find('meta[itemprop=reviewCount]', 0)->content;
        $bookRating = $this->html->find('span[itemprop=ratingValue]', 0)->innertext;

        // the book image url will be for a small image, change the url to request a larger one
        /*if(($imageSizeStartingPos = strpos($bookImageLink, '._')) !== false) {
          $bookImageWidth = substr($bookImageLink, $imageSizeStartingPos);
          $bookImageLink = str_replace($bookImageWidth, "._SX500_.jpg", $bookImageLink);
        }*/

        // put all the book info into one array
        $book = [ 'title' => $bookTitle, 'description' => $bookDescription, 
        'coverURL' => $bookImageLink, 'ratings' => $bookRatings, 
        'reviews' => $bookReviews,'rating' => $bookRating ];

        $this->html->clear();
        unset($this->html);
  
        return $book;
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
