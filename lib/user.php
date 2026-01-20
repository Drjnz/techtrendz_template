<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{
    /*
        @todo faire la requête d'insertion d'utilisateur et retourner $query->execute();
        Attention faire une requête préparer et à binder les paramètres
    */
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first_name, last_name, email, password, role)
            VALUES (:first_name, :last_name, :email, :password, :role)";

    $query = $pdo->prepare($sql);

    $query->bindValue(':first_name', $first_name);
    $query->bindValue(':last_name', $last_name);
    $query->bindValue(':email', $email);
    $query->bindValue(':password', $hashedPassword); // mot de passe déjà hashé avant l'appel
    $query->bindValue(':role', $role);

    return $query->execute();


}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    /*
        @todo faire une requête qui récupère l'utilisateur par email et stocker le résultat dans user
        Attention faire une requête préparer et à binder les paramètres
    */
    $sql = "SELECT * FROM users WHERE email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC); 
 

    /*
        @todo Si on a un utilisateur et que le mot de passe correspond (voir fonction  native password_verify)
              alors on retourne $user
              sinon on retourne false
    */
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }


}
