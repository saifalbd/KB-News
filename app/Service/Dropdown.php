<?php

namespace App\Service;

use App\Models\Category;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Tag;
use App\Models\Team;
use Illuminate\Support\Facades\Http;

class Dropdown
{

   

 

    public function designations(){
        return Designation::query()->get();
    }

    public function departments(){
        return Department::query()->get();
    }


    public function categories(){
        return Category::query()->get();
    }

    public function tags(){
        return Tag::query()->get();
    }

    public function roles(){
        return Role::query()->get();
    }


  

}
