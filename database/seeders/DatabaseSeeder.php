<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'admin',
            'role' => UserRole::ADMIN->value,
            'email' => 'a@x.com',
        ]);

        User::factory()->create([
            'name' => 'user',
            'role' => UserRole::USER->value,
            'email' => 'u@x.com',
        ]);

        $categories = [
            [
                'name' => 'Seminar',
            ],
            [
                'name' => 'Workshop',
            ],
            [
                'name' => 'Concert',
            ],
        ];

        Category::insert($categories);

        $categories = Category::all();

        $events = Event::factory()
            ->count(10)
            ->recycle($categories)
            ->recycle($admin)
            ->hasTickets(4)
            ->create();

        Order::factory(10)
            ->recycle($users)
            ->recycle($events)
            ->create()
            ->each(function ($order) {
                $tickets = $order->event->tickets;
                \App\Models\OrderDetail::factory(2)
                    ->recycle($order)
                    ->state(fn () => [
                        'ticket_id' => $tickets->random()->id,
                    ])
                    ->create();
            });
    }
}
