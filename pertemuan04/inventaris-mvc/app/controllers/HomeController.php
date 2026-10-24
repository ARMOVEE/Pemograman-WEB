<?php

class HomeController extends Controller {
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index(): void {
        $this->authorize('dashboard.view');
        $item = $this->model('Item');
        $transaction = $this->model('Transaction');

        $daily = $transaction->dailyTotals(7);

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'totalItems' => $item->totalItems(),
            'totalStock' => $item->totalStock(),
            'totalAssetValue' => $item->totalAssetValue(),
            'lowStockCount' => $item->lowStockCount(),
            'lowStockItems' => $item->lowStockItems(),
            'lowStockThreshold' => Item::LOW_STOCK_THRESHOLD,
            'todayCount' => $transaction->todayCount(),
            'recentTransactions' => $transaction->recent(5),
            'chartLabels' => array_column($daily, 'label'),
            'chartIn'     => array_column($daily, 'in'),
            'chartOut'    => array_column($daily, 'out'),
            'topItems'    => $item->topStock(5),
        ]);
    }


}
