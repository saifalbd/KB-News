<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
   protected $table = 'personal_informations';

   protected $fillable = ['nationality','religion','marital_status'];
}
