<?php
/**
 * API token model (tokens are stored as SHA-256 hashes).
 */
class ApiToken extends Model
{
    protected string $table = 'api_tokens';

    public function findUserByToken(string $plainToken): ?array
    {
        $sql = "SELECT t.id AS token_id, u.id, u.username, u.full_name, u.role
                FROM api_tokens t
                INNER JOIN users u ON u.id = t.user_id
                WHERE t.token_hash = ?
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([Security::hashToken($plainToken)]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function touch(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE api_tokens SET last_used_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function issue(int $userId, string $name = 'default'): string
    {
        $plain = 'inv_' . bin2hex(random_bytes(24));
        $stmt = $this->db->prepare(
            "INSERT INTO api_tokens (user_id, token_hash, name) VALUES (?, ?, ?)"
        );
        $stmt->execute([$userId, Security::hashToken($plain), $name]);
        return $plain;
    }
}
