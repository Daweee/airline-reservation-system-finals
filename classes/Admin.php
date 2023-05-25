<?php

class Admin
{

    public $id;
    public $username;
    public $password;

    public static function authenticate($conn, $username, $password)
    {
        $sql = "SELECT *
                FROM admin_users
                WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Admin');

        $stmt->execute();

        if ($admin = $stmt->fetch()) {
            return password_verify($password, $admin->password);
        }
    }
}
