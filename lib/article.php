<?php

function getArticleById(PDO $pdo, int $id):array|bool
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getArticles(PDO $pdo, ?int $limit = null, ?int $page = null):array|bool
{

    /*
        @todo faire la requête de récupération des articles
        La requête sera différente selon les paramètres passés, commencer déjà juste avec la base en ignrorant les autre params
    */
    //$query->execute();
    //$result = $query->fetchAll(PDO::FETCH_ASSOC);
    //return $result;
    $sql = "SELECT id, title, image FROM articles ORDER BY created_at DESC LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getTotalArticles(PDO $pdo):int|bool
{
    /*
        @todo récupérer le nombre total d'article (avec COUNT)
    */
    //$result = $query->fetch(PDO::FETCH_ASSOC);
    //return $result['total'];
    try {
        $sql = "SELECT COUNT(*) AS total FROM articles";
        $stmt = $pdo->query($sql);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $result['total'];
    } catch (PDOException $e) {
        return false;
    }


}

function saveArticle(PDO $pdo, string $title, string $content, ?string $image, int $category_id, ?int $id = null):bool 
{
    //if ($id === null) {
        /*
            @todo si id est null, alors on fait une requête d'insection
        */
        //$query = ...
    //} else {
        /*
            @todo sinon, on fait un update
        */
        //$query = ...
        //$query->bindValue(':id', $id, $pdo::PARAM_INT);
    //}
    // @todo on bind toutes les valeurs communes
    //return $query->execute();  

//{
    if ($id === null) {
        $sql = "INSERT INTO articles (title, content, image, category_id, created_at)
                VALUES (:title, :content, :image, :category_id, NOW())";
        $query = $pdo->prepare($sql);
    } else {
        // Mise à jour
        $sql = "UPDATE articles 
                SET title = :title, content = :content, image = :image, category_id = :category_id
                WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
    }

    // Bind des valeurs communes
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':content', $content, PDO::PARAM_STR);
    $query->bindValue(':image', $image, PDO::PARAM_STR);
    $query->bindValue(':category_id', $category_id, PDO::PARAM_INT);

    return $query->execute();
}


function deleteArticle(PDO $pdo, int $id):bool
{
    
    /*
        @todo Faire la requête de suppression
    */
    $sql = "DELETE FROM articles WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    //
    $query->execute();
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
    

}

