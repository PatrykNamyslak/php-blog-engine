<?php
namespace PatrykNamyslak;

/**
 * @param string $PostID :: 
 */

class Post extends Blog{
    public string $PostID;
    public string $Author;
    public array $Content;
    public function __construct(?string $PostID = NULL, ?string $Author = NULL){
        // The below logic easily could be replaced by a switch case statement but this is implemented this way to improve readability
        $FetchBy = match(true){
            $PostID => 'ID',
            $Author => 'Author',
        };
        ################
        $posts_table = parent::$posts_table;
        $query = "SELECT * FROM `{$posts_table}` WHERE `:column` = `:value`";
        $statement = parent::$database_connection->prepare($query);
        $statement->execute([':column' => $FetchBy, ':value' => $PostID ?? $Author]);
        $postData = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($postData){
            $this->PostID = $postData['ID'];
            $this->Author = $postData['Author'];
            $this->Content = [
                'Title' => $postData['Title'],
                'Body' => $postData['Body'],
            ];
        }
    }
}
?>