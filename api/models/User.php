<?php
require_once __DIR__.'/../entities/User.php';

class User {
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll() {
        
        //TODO: don't display password
        $stmt = $this->pdo->query("SELECT * FROM _user");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            $users[] = new UserEntity(
                $row['id_user'],
                $row['username'],
                $row['first_name'],
                $row['last_name'],
                $row['password'],
                isset($row['id_tag']) ? (int) $row['id_tag'] : null
            );
        }
        return $users;
    }

    public function find($id_user) {
        //TODO: don't display password
        
        $stmt = $this->pdo->prepare("SELECT * FROM _user WHERE id_user = ?");
        $stmt->execute([$id_user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return null;
        }
        return new UserEntity(
            $row['id_user'],
            $row['username'],
            $row['first_name'],
            $row['last_name'],
            $row['password'],
            isset($row['id_tag']) ? (int) $row['id_tag'] : null
        );
    }



public function create(UserEntity $user) {
    try {
        $this->pdo->beginTransaction();

        // 1. Insert user without tag
        $stmt = $this->pdo->prepare(
            "INSERT INTO _user (username, first_name, last_name, password) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $user->username,
            $user->first_name,
            $user->last_name,
            $user->password
        ]);
        $userId = $this->pdo->lastInsertId();

        // 2. Insert tag as id_category = 1 (@person)
        $stmt = $this->pdo->prepare(
            "INSERT INTO tag (name, id_category) VALUES (?, 1)"
        );
        $stmt->execute([$user->username]);
        $tagId = $this->pdo->lastInsertId();

        // 3. Update user with the tag id
        $stmt = $this->pdo->prepare(
            "UPDATE _user SET id_tag = ? WHERE id_user = ?"
        );
        $stmt->execute([$tagId, $userId]);

        $this->pdo->commit();

        return $this->find($userId);
    } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}


public function update(UserEntity $user) {
    try {
        $this->pdo->beginTransaction();

        // 1. Update user basic info (first_name, last_name, password)
        $stmt = $this->pdo->prepare(
            "UPDATE _user SET username = ?, first_name = ?, last_name = ?, password = ? WHERE id_user = ?"
        );
        $stmt->execute([
            $user->username,
            $user->first_name,
            $user->last_name,
            $user->password,
            $user->id_user
        ]);

        // 2. Update tag name if user has id_tag
        if ($user->id_tag) {
            $stmt = $this->pdo->prepare(
                "UPDATE tag SET name = ? WHERE id_tag = ?"
            );
            $stmt->execute([$user->username, $user->id_tag]);
        }

        $this->pdo->commit();
        return $this->find($user->id_user);
    } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}


    public function delete($id_user) {
        
        $stmt = $this->pdo->prepare("DELETE FROM _user WHERE id_user = ?");
        $success = $stmt->execute([$id_user]);
        return $success; 
    }
    
}

?>