<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([
            'name' => 'Chitraket Savani',
            'username' => 'chitraket-savani',
            'email' => 'chitraketsavani@gmail.com',
            'password' => bcrypt('chit@9125'),
            'phone' => '7984498992',
            'image' => 'ecc43e40cd08bfe4f09c0ff5511af7c1.jpg',
            'about' => 'My name is Chitraket savani.  I live in India and I love to write tutorials and tips that can help to other artisan. I am a big fan of PHP, Javascript, JQuery, Laravel,VueJS and Bootstrap from the early stage.',
            'status' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
