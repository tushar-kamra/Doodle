<?php

class SiteResultsProvider {

    private $conn ;

    public function __construct($conn){
        $this->conn = $conn ;
    }

    public function getNumResults($term){
        $sql = "select count(*) as total from sites where title like '%$term%' or url like '%$term%' or keywords like '%$term%' or description like '%$term%'  " ;
        $result = $this->conn->query($sql) ;
        // while($row = $result->fetch_assoc()){
        //     echo $row['total'];
        // }
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getResultsHtml($page, $pageSize, $term){

        $fromLimit = ($page - 1) * $pageSize ;
        // page 1 : (1 - 1) * 20 = 0
        // page 2 : (2 - 1) * 20 = 20

        $sql = "select * from sites where title like '%$term%' or url like '%$term%' or keywords like '%$term%' or description like '%$term%' order by clicks desc limit $fromLimit,$pageSize " ;
        $result = $this->conn->query($sql) ;

        $resultsHtml = "<div class = 'siteResults'>" ;
            while($row = $result->fetch_assoc()){
                $id = $row['id'] ;
                $url = $row['url'] ;
                $title = $row['title'] ;
                $description = $row['description'] ;

                $title = $this->trimField($title,55);
                $description = $this->trimField($description,200);

                $resultsHtml .= "<div class='resultContainer'>
                
                                    <h3 class='title'>
                                        <a class='result' href='$url' data-linkId='$id' >
                                            $title
                                        </a>
                                    </h3>
                                    <span class='url'>$url</span>
                                    <span class='description'>$description</span>

                                </div>" ;
                
            }
        $resultsHtml .= "</div>" ;

        return $resultsHtml ;
    }

    private function trimField($string, $characterLimit){
        $dots = strlen($string) > $characterLimit ? "..." : "" ;
        return substr($string,0,$characterLimit) . $dots ;
    }

}

?>