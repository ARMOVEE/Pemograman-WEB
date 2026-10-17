<?php

class User extends Model
{
    protected string $table = 'users';

    public function all(): array
    {
        return $this->db->query(
            "SELECT id, username, full_name, role, created_at FROM {$this->table} ORDER BY id ASC"
        )->fetchAll();
    }

    public function login(string $username, string $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        return false;
    }
}
