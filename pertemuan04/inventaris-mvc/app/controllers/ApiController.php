<?php
/**
 * JSON API (v1).
 *
 * GET  /api/me
 * GET  /api/items?search=&category=&page=&limit=
 * GET  /api/items/{id}
 * POST /api/items
 * POST /api/transactions
 * GET  /api/dashboard
 * GET  /api/lowStock
 */
class ApiController extends Controller
{
    private array $apiUser;

    public function __construct()
    {
        $this->cors();
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
        $this->apiUser = ApiAuth::requireUser();
    }

    public function index(): void
    {
        $this->json([
            'success' => true,
            'data'    => [
                'name'      => APP_NAME,
                'version'   => '2.0',
                'endpoints' => [
                    'GET /api/me',
                    'GET /api/items?search=&category=&page=&limit=',
                    'GET /api/items/{id}',
                    'POST /api/items',
                    'POST /api/transactions',
                    'GET /api/dashboard',
                    'GET /api/lowStock',
                ],
            ],
        ]);
    }

    public function me(): void
    {
        $this->json(['success' => true, 'data' => $this->apiUser]);
    }

    public function items($id = null): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($id === null) {
            if ($method === 'GET') {
                $this->listItems();
            } elseif ($method === 'POST') {
                $this->createItem();
            } else {
                $this->methodNotAllowed('GET, POST');
            }
            return;
        }
        if ($method !== 'GET') {
            $this->methodNotAllowed('GET');
        }
        $this->showItem((int) $id);
    }

    public function transactions(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->methodNotAllowed('POST');
        }
        $this->requireApiPermission('transactions.create');
        $input = $this->input();

        $itemId = filter_var($input['item_id'] ?? null, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]) ?: 0;
        $type = is_string($input['type'] ?? null) ? strtoupper(trim($input['type'])) : '';
        $quantity = filter_var($input['quantity'] ?? null, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]) ?: 0;
        $notes = is_string($input['notes'] ?? null) ? trim($input['notes']) : '';

        $errors = [];
        if ($itemId <= 0) {
            $errors['item_id'] = 'item_id wajib berupa angka positif.';
        }
        if (!in_array($type, ['IN', 'OUT'], true)) {
            $errors['type'] = 'type harus IN atau OUT.';
        }
        if ($quantity <= 0) {
            $errors['quantity'] = 'quantity wajib lebih dari 0.';
        }
        if ($errors) {
            $this->jsonError('Data tidak valid.', 422, ['errors' => $errors]);
        }

        $ok = $this->model('Transaction')->create([
            'item_id'  => $itemId,
            'user_id'  => (int) $this->apiUser['id'],
            'type'     => $type,
            'quantity' => $quantity,
            'notes'    => $notes !== '' ? $notes : null,
        ]);

        if (!$ok) {
            $this->jsonError(
                'Transaksi gagal. Barang tidak ditemukan atau stok tidak mencukupi.',
                422
            );
        }

        $this->model('ActivityLog')->record(
            (int) $this->apiUser['id'],
            'api.stock.' . strtolower($type),
            'item',
            $itemId,
            $type . ' ' . $quantity . ' unit via API'
        );

        $item = $this->model('Item')->find($itemId);
        $this->json([
            'success' => true,
            'message' => 'Transaksi berhasil dicatat.',
            'data'    => [
                'item_id'  => $itemId,
                'type'     => $type,
                'quantity' => $quantity,
                'stock'    => $item ? (int) $item['quantity'] : null,
            ],
        ], 201);
    }

    public function dashboard(): void
    {
        $this->requireApiPermission('dashboard.view');
        $item = $this->model('Item');
        $transaction = $this->model('Transaction');
        $this->json([
            'success' => true,
            'data'    => [
                'total_items'        => $item->totalItems(),
                'total_stock'        => $item->totalStock(),
                'total_asset_value'  => $item->totalAssetValue(),
                'low_stock_count'    => $item->lowStockCount(5),
                'today_transactions' => $transaction->todayCount(),
                'daily'              => $transaction->dailyTotals(7),
            ],
        ]);
    }

    public function lowStock(): void
    {
        $this->requireApiPermission('reports.view');
        $this->json([
            'success' => true,
            'data'    => $this->model('Item')->lowStockItems(5, 20),
        ]);
    }

    private function listItems(): void
    {
        $this->requireApiPermission('items.view');
        $page = max(1, (int) query_param('page', '1'));
        $limit = (int) query_param('limit', (string) API_DEFAULT_LIMIT);
        $limit = in_array($limit, [5, 10, 20, 50, 100], true) ? $limit : API_DEFAULT_LIMIT;
        $result = $this->model('Item')->paginate(
            $limit,
            $page,
            query_param('search'),
            query_param('category')
        );

        $this->json([
            'success' => true,
            'data'    => $result['data'],
            'meta'    => [
                'current_page' => $result['current_page'],
                'total_pages'  => $result['total_pages'],
                'total_data'   => $result['total_data'],
                'limit'        => $limit,
            ],
        ]);
    }

    private function showItem(int $id): void
    {
        $this->requireApiPermission('items.view');
        $item = $this->model('Item')->find($id);
        if (!$item) {
            $this->jsonError('Barang tidak ditemukan.', 404);
        }
        $this->json([
            'success' => true,
            'data'    => $item,
            'history' => $this->model('Transaction')->forItem($id, 10),
        ]);
    }

    private function createItem(): void
    {
        $this->requireApiPermission('items.create');
        $input = $this->input();
        $code = is_string($input['code'] ?? null) ? trim($input['code']) : '';
        $name = is_string($input['name'] ?? null) ? trim($input['name']) : '';
        $errors = [];
        if ($code === '') {
            $errors['code'] = 'code wajib diisi.';
        }
        if ($name === '') {
            $errors['name'] = 'name wajib diisi.';
        }
        if ($errors) {
            $this->jsonError('Data tidak valid.', 422, ['errors' => $errors]);
        }

        $entryDate = is_string($input['entry_date'] ?? null) ? trim($input['entry_date']) : '';
        $categoryId = $input['category_id'] ?? null;
        $categoryId = ($categoryId === null || $categoryId === '' || !is_numeric($categoryId))
            ? null
            : (int) $categoryId;

        $payload = [
            'code'        => $code,
            'name'        => $name,
            'category_id' => $categoryId,
            'quantity'    => max(0, (int) filter_var($input['quantity'] ?? 0, FILTER_VALIDATE_INT)),
            'unit'        => is_string($input['unit'] ?? null) && trim($input['unit']) !== ''
                ? trim($input['unit'])
                : 'unit',
            'price'       => max(0, (float) filter_var($input['price'] ?? 0, FILTER_VALIDATE_FLOAT)),
            'entry_date'  => preg_match('/^\d{4}-\d{2}-\d{2}$/', $entryDate) ? $entryDate : null,
            'description' => is_string($input['description'] ?? null) ? trim($input['description']) : '',
            'photo'       => null,
        ];

        try {
            $this->model('Item')->create($payload);
        } catch (PDOException $e) {
            Logger::error('API create item failed', ['error' => $e->getMessage()]);
            $this->jsonError('Barang gagal disimpan. Kode mungkin sudah dipakai atau kategori tidak valid.', 409);
        }

        $this->model('ActivityLog')->record(
            (int) $this->apiUser['id'],
            'api.item.create',
            'item',
            null,
            $code . ' - ' . $name
        );

        $this->json([
            'success' => true,
            'message' => 'Barang berhasil dibuat.',
            'data'    => ['code' => $code, 'name' => $name],
        ], 201);
    }

    private function requireApiPermission(string $permission): void
    {
        if (!Middleware::roleCan($this->apiUser['role'] ?? '', $permission)) {
            $this->jsonError('Token ini tidak memiliki izin untuk aksi tersebut.', 403);
        }
    }

    private function cors(): void
    {
        header('Access-Control-Allow-Origin: ' . API_ALLOWED_ORIGIN);
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type');
        header('Vary: Origin');
    }

    private function methodNotAllowed(string $allowed): void
    {
        header('Allow: ' . $allowed);
        $this->jsonError('Metode HTTP tidak didukung untuk endpoint ini.', 405);
    }
}
