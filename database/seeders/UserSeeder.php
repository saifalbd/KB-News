<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    CONST RULES = [
        ['name'=>'Admin','slug'=>'admin'],
        ['name'=>'Author','slug'=>'author'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (static::RULES as $role) {
           Role::create($role);
        }
        $roles = Role::query()->get();
        $avarar = Attachment::create([
            'type'=>'image/jpeg',
            'disk'=>'s3',
            'path'=>'task-master/hero.png',
            'sm_path'=>'task-master/hero.png',
            'md_path'=>'task-master/hero.png',
            'model'=>'User'
        ]);

      $user =  User::create([
            'name' =>'Saiful islam',
            'email' => 'saiful@redbook.cloud',
            'slug'=>Str::slug('saiful islam'),
            'phone'=>'01312288425',
            'avatar_id'=>$avarar->id,
            'email_verified_at' => now(),
            'password' => Hash::make(1234), // password
            'remember_token' => Str::random(10),
        ]);

        $user->roles()->sync($roles->pluck('id')->toArray());



    }
}
