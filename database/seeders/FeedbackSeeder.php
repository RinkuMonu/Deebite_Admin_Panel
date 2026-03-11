<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\User;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Feedback::create([
                'name' => 'Customer ' . $i,
                'number' => '98765432' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'feedback' => 'This is a sample feedback message number ' . $i . '. The service is great and delivery was fast!',
            ]);
        }

        $this->command->info('10 Feedback records created successfully!');
    }
}