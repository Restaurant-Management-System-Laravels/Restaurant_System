<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
     public function index()
    {
        $faqs = [
            [
                'question' => 'How do I create a new order?',
                'answer' => 'Go to Order Line, select a table, add items from the menu, and click "Place Order".'
            ],
            [
                'question' => 'How do I process payments?',
                'answer' => 'Select an order from the Order Line, choose a payment method (Cash, Card, or Scan), and click "Place Order".'
            ],
            [
                'question' => 'How do I manage tables?',
                'answer' => 'Go to Manage Table section to add, edit, or delete tables. You can set table capacity and status.'
            ],
            [
                'question' => 'How do I add new menu items?',
                'answer' => 'Navigate to Manage Dishes, click "Add New Item", fill in the details, and save.'
            ],
            [
                'question' => 'How do I print receipts?',
                'answer' => 'Select an order and click the Print button. This will open a printer-friendly receipt view.'
            ],
            [
                'question' => 'Can I edit an existing order?',
                'answer' => 'Yes, select the order and click the edit icon to modify items or quantities.'
            ],
            [
                'question' => 'How do I track order status?',
                'answer' => 'Orders are color-coded: Red (Wait List), Teal (In Kitchen), Purple (Ready), Green (Served).'
            ]
        ];

        return view('help.index', compact('faqs'));
    }
}
