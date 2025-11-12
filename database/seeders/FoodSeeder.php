<?php

namespace Database\Seeders;
use App\Models\Food;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $foods = [
            // Burgers
            ['name' => 'Classic Burger', 'category' => 'Burger', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=400&h=300&fit=crop'],
            ['name' => 'Cheese Burger', 'category' => 'Burger', 'price' => 140, 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=300&fit=crop'],
            ['name' => 'Bacon Burger', 'category' => 'Burger', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?w=400&h=300&fit=crop'],

            // Chicken
            ['name' => 'Fried Chicken', 'category' => 'Chicken', 'price' => 180, 'image' => 'https://images.unsplash.com/photo-1603894584373-5ac82b2ae398?w=400&h=300&fit=crop'],
            ['name' => 'Grilled Chicken', 'category' => 'Chicken', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=400&h=300&fit=crop'],
            ['name' => 'Chicken Wings', 'category' => 'Chicken', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=400&h=300&fit=crop'],

            // Drinks
            ['name' => 'Coca Cola', 'category' => 'Drinks', 'price' => 50, 'image' => 'https://images.unsplash.com/photo-1583454110559-21a334e7b3a4?w=400&h=300&fit=crop'],
            ['name' => 'Pepsi', 'category' => 'Drinks', 'price' => 50, 'image' => 'https://images.unsplash.com/photo-1613479959304-dff06a6e7c68?w=400&h=300&fit=crop'],
            ['name' => 'Orange Juice', 'category' => 'Drinks', 'price' => 70, 'image' => 'https://images.unsplash.com/photo-1572404571403-1f7f2f8c19de?w=400&h=300&fit=crop'],

            // Vegetables
            ['name' => 'Garden Salad', 'category' => 'Vegetable', 'price' => 90, 'image' => 'https://images.unsplash.com/photo-1566843971414-ecb3d7b826f0?w=400&h=300&fit=crop'],
            ['name' => 'Grilled Veggies', 'category' => 'Vegetable', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1598514983817-9f90ec2c1f46?w=400&h=300&fit=crop'],
            ['name' => 'Veggie Wrap', 'category' => 'Vegetable', 'price' => 100, 'image' => 'https://images.unsplash.com/photo-1606755962776-0a1d8f488b0b?w=400&h=300&fit=crop'],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
   