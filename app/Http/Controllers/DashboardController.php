<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $totalMenus = Menu::count();
        $totalOrders = Order::count();

        $roles = [
            'admin' => User::where('role', 'admin')->count(),
            'pelanggan' => User::where('role', 'pelanggan')->count(),
        ];

        $category = $request->get('category', 'all');
        $latestMenus = Menu::latest()->get();

        $recentOrders = Order::with('user')->latest()->limit(6)->get();
        $recentPayments = Payment::latest()->limit(6)->get();

        return view('dashboard', compact('totalUsers', 'roles', 'totalMenus', 'totalOrders', 'latestMenus', 'recentOrders', 'recentPayments', 'category'));
    }
}
