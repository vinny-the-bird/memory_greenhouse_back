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
                $row['password']
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
            $row['password']
        );
    }

    public function create(UserEntity $user) {
        $stmt = $this->pdo->prepare("INSERT INTO _user (username, first_name, last_name, password) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([
            $user->username, 
            $user->first_name,
            $user->last_name,
            $user->password
        ]);

        if ($success) {
        $lastId = $this->pdo->lastInsertId();
        return self::find($lastId);
        }
        return null;
    }

    public function update(UserEntity $user) {
        $stmt = $this->pdo->prepare("UPDATE _user SET 
        username = ?, 
        first_name = ?, 
        last_name = ?, 
        password = ?
        WHERE id_user = ?");
        $success = $stmt->execute([
            $user->username, 
            $user->first_name,
            $user->last_name,
            $user->password,
            $user->id_user]);

        if ($success) {
            return self::find($user->id_user); 
        }
    }

    public function delete($id_user) {
        
        $stmt = $this->pdo->prepare("DELETE FROM _user WHERE id_user = ?");
        $success = $stmt->execute([$id_user]);
        return $success; 
    }
    
}

?>