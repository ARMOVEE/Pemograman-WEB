<?php

class Controller
{
    public function view(string $view, array $data = []): void
    {
        extract($data);
        require ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function model(string $model) { return new $model(); }

    public function redirect(string $path): void
    {
        header('Location: ' . BASEURL . '/' . ltrim($path, '/'));
        exit;
    }

    public function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function requireLogin(): void { Middleware::requireLogin(); }

    protected function authorize(string $permission): void
    {
        Middleware::requirePermission($permission);
    }

    protected function requireAdmin(): void
    {
        Middleware::requireRole('admin');
    }

    protected function logActivity(
        string $action,
        ?string $entity = null,
        ?int $entityId = null,
        ?string $description = null
    ): void {
        $userId = isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;
        $this->model('ActivityLog')->record($userId, $action, $entity, $entityId, $description);
    }

    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function jsonError(string $message, int $status = 400, array $extra = []): void
    {
        $this->json(array_merge([
            'success' => false,
            'message' => $message,
        ], $extra), $status);
    }

    protected function input(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (stripos($contentType, 'application/json') !== false) {
            $raw = file_get_contents('php://input');
            $data = json_decode((string) $raw, true);
            return is_array($data) ? $data : [];
        }
        return $_POST;
    }
}