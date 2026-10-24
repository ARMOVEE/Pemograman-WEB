<?php

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index(): void
    {
        $this->authorize('categories.view');
        $this->view('categories/index', [
            'title' => 'Data Kategori',
            'categories' => $this->model('Category')->all(),
        ]);
    }

    public function create(): void
    {
        $this->authorize('categories.manage');
        $this->view('categories/create', ['title' => 'Tambah Kategori']);
    }

    public function store(): void
    {
        $this->authorize('categories.manage');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('categories');
        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/create');
        }
        $this->model('Category')->create([
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil ditambahkan.');
        $this->redirect('categories');
    }

    public function edit($id = 0): void
    {
        $this->authorize('categories.manage');
        $category = $this->model('Category')->find((int) $id);
        if (!$category) {
            $this->flash('danger', 'Kategori tidak ditemukan.');
            $this->redirect('categories');
        }
        $this->view('categories/edit', [
            'title' => 'Ubah Kategori',
            'category' => $category,
        ]);
    }

    public function update($id = 0): void
    {
        $this->authorize('categories.manage');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('categories');
        $id = (int) $id;
        $input = array_map('trim', $_POST);
        if (empty($input['name'])) {
            $this->flash('danger', 'Nama kategori wajib diisi.');
            $this->redirect('categories/edit/' . $id);
        }
        $this->model('Category')->update($id, [
            'name' => $input['name'],
            'description' => $input['description'] ?? '',
        ]);
        $this->flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('categories');
    }

    public function delete($id = 0): void
    {
        $this->authorize('categories.manage');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('categories');
        $category = $this->model('Category')->find((int) $id);
        if ($category && $this->model('Category')->softDelete((int) $id)) {
            $this->flash('success', 'Kategori dipindahkan ke sampah (soft delete).');
        } else {
            $this->flash('danger', 'Kategori gagal dihapus.');
        }
        $this->redirect('categories');
    }
}

