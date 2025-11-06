<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
{
    $this->call(AdminUserSeeder::class);


        // Create Tables
$tables = [
            ['table_number' => '01', 'capacity' => 2, 'status' => 'available'],
            ['table_number' => '02', 'capacity' => 4, 'status' => 'available'],
            ['table_number' => '03', 'capacity' => 4, 'status' => 'occupied'],
            ['table_number' => '04', 'capacity' => 2, 'status' => 'occupied'],
            ['table_number' => '05', 'capacity' => 6, 'status' => 'available'],
            ['table_number' => '06', 'capacity' => 4, 'status' => 'available'],
            ['table_number' => '07', 'capacity' => 2, 'status' => 'occupied'],
            ['table_number' => '08', 'capacity' => 4, 'status' => 'available'],
            ['table_number' => '09', 'capacity' => 4, 'status' => 'occupied'],
            ['table_number' => '10', 'capacity' => 8, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }

        // Create Menu Items
        $menuItems = [
            // Lunch
            ['name' => 'Grilled Salmon Steak', 'description' => 'Fresh Atlantic salmon with herbs', 'price' => 15.00, 'category' => 'Lunch', 'is_available' => true],
            ['name' => 'Chicken Teriyaki Bowl', 'description' => 'Grilled chicken with teriyaki sauce', 'price' => 12.00, 'category' => 'Lunch', 'is_available' => true],
            
            // Salad
            ['name' => 'Tofu Poke Bowl', 'description' => 'Hawaiian-style tofu poke', 'price' => 7.00, 'category' => 'Salad', 'is_available' => true],
            ['name' => 'Vegetable Shrimp', 'description' => 'Fresh vegetables with shrimp', 'price' => 10.00, 'category' => 'Salad', 'is_available' => true],
            ['name' => 'Caesar Salad', 'description' => 'Classic caesar with croutons', 'price' => 8.00, 'category' => 'Salad', 'is_available' => true],
            
            // Pasta
            ['name' => 'Pasta with Roast Beef', 'description' => 'Tender roast beef with pasta', 'price' => 10.00, 'category' => 'Pasta', 'is_available' => true],
            ['name' => 'Carbonara', 'description' => 'Creamy carbonara pasta', 'price' => 11.00, 'category' => 'Pasta', 'is_available' => true],
            ['name' => 'Aglio Olio', 'description' => 'Garlic olive oil pasta', 'price' => 9.00, 'category' => 'Pasta', 'is_available' => true],
            
            // Beef
            ['name' => 'Beef Steak', 'description' => 'Premium beef steak', 'price' => 30.00, 'category' => 'Beef', 'is_available' => true],
            ['name' => 'Beef Rendang', 'description' => 'Indonesian style beef', 'price' => 25.00, 'category' => 'Beef', 'is_available' => true],
            
            // Rice
            ['name' => 'Shrimp Rice Bowl', 'description' => 'Steamed rice with shrimp', 'price' => 6.00, 'category' => 'Rice', 'is_available' => true],
            ['name' => 'Chicken Fried Rice', 'description' => 'Classic fried rice', 'price' => 8.00, 'category' => 'Rice', 'is_available' => true],
            ['name' => 'Nasi Goreng', 'description' => 'Indonesian fried rice', 'price' => 9.00, 'category' => 'Rice', 'is_available' => true],
            
            // Dessert
            ['name' => 'Apple Stuffed Pancake', 'description' => 'Pancake with apple filling', 'price' => 35.00, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Chocolate Lava Cake', 'description' => 'Warm chocolate cake', 'price' => 12.00, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Tiramisu', 'description' => 'Classic Italian dessert', 'price' => 10.00, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Cheesecake', 'description' => 'New York style cheesecake', 'price' => 11.00, 'category' => 'Dessert', 'is_available' => true],
            
            // Chicken
            ['name' => 'Chicken Quinoa & Herbs', 'description' => 'Healthy quinoa with chicken', 'price' => 12.00, 'category' => 'Chicken', 'is_available' => true],
            ['name' => 'Grilled Chicken', 'description' => 'Marinated grilled chicken', 'price' => 14.00, 'category' => 'Chicken', 'is_available' => true],
            ['name' => 'Chicken Katsu', 'description' => 'Japanese breaded chicken', 'price' => 13.00, 'category' => 'Chicken', 'is_available' => true],
            
            // Soups
            ['name' => 'Tom Yum Soup', 'description' => 'Thai hot and sour soup', 'price' => 8.00, 'category' => 'Soups', 'is_available' => true],
            ['name' => 'Mushroom Soup', 'description' => 'Creamy mushroom soup', 'price' => 7.00, 'category' => 'Soups', 'is_available' => true],
            ['name' => 'French Onion Soup', 'description' => 'Classic French soup', 'price' => 9.00, 'category' => 'Soups', 'is_available' => true],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }

        // Create Sample Orders
        $this->createSampleOrder('F0027', 3, 'in_kitchen', [
            ['menu_item_id' => 1, 'quantity' => 2, 'price' => 15.00],
            ['menu_item_id' => 3, 'quantity' => 3, 'price' => 7.00],
            ['menu_item_id' => 6, 'quantity' => 3, 'price' => 10.00],
        ]);

        $this->createSampleOrder('F0028', 7, 'pending', [
            ['menu_item_id' => 9, 'quantity' => 2, 'price' => 30.00],
            ['menu_item_id' => 21, 'quantity' => 1, 'price' => 8.00],
        ]);

        $this->createSampleOrder('F0019', 9, 'ready', [
            ['menu_item_id' => 14, 'quantity' => 1, 'price' => 35.00],
            ['menu_item_id' => 11, 'quantity' => 1, 'price' => 6.00],
        ]);

        $this->createSampleOrder('F0030', 4, 'pending', [
            ['menu_item_id' => 6, 'quantity' => 2, 'price' => 10.00],
            ['menu_item_id' => 11, 'quantity' => 2, 'price' => 6.00],
            ['menu_item_id' => 14, 'quantity' => 1, 'price' => 35.00],
            ['menu_item_id' => 4, 'quantity' => 1, 'price' => 10.00],
        ]);
    }

    private function createSampleOrder($orderNumber, $tableId, $status, $items)
    {
        $order = Order::create([
            'order_number' => $orderNumber,
            'table_id' => $tableId,
            'user_id' => 1,
            'number_of_people' => 2,
            'status' => $status,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $order->calculateTotals();
    }

}
