<?php

class ImageResultsProvider {

    private $conn ;

    public function __construct($conn){
        $this->conn = $conn ;
    }

    public function getNumResults($term){
        $sql = "select count(*) as total from images where (title like '%$term%' or alt like '%$term%') and broken = 0 " ;
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

        $sql = "select * from images where (title like '%$term%' or alt like '%$term%') and broken = 0 order by clicks desc limit $fromLimit,$pageSize " ;
        $result = $this->conn->query($sql) ;

        $resultsHtml = "<div class = 'imageResults'>" ;
        $count = 0 ;
            while($row = $result->fetch_assoc()){
                $count++ ;
                $id = $row['id'] ;
                $imageUrl = $row['imageUrl'] ;
                $siteUrl = $row['siteUrl'] ;
                $title = $row['title'] ;
                $alt = $row['alt'] ;

                if($title){
                    $displayText = $title ;
                }
                else if($alt){
                    $displayText = $alt ;
                }
                else {
                    $displayText = $imageUrl ;
                }

                $resultsHtml .= "<div class='gridItem image$count'>
                
                                    <a href = '$imageUrl' data-fancybox data-caption='$displayText' data-siteurl='$siteUrl'>
                                        
                                        <script>
                                            $(document).ready(function(){
                                                loadImage(\"$imageUrl\",\"image$count\");
                                            });
                                        </script>

                                        <span class='details'>$displayText</span>
                                    </a>

                                </div>" ;
                
            }
        $resultsHtml .= "</div>" ;

        return $resultsHtml ;
    }



}

?>