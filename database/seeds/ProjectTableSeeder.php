<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prjs = ['개인', '업무', '학습', '쇼핑'];
        foreach ($prjs as $prj) {
            DB::table('projects')->insert([
                'name' => $prj,
                'user_id' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
