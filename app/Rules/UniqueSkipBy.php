<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;

class UniqueSkipBy implements InvokableRule
{
    protected $table;
    protected $user_id;
    protected $id;
    public function __construct(string $table,$user_id,$id)
    {
        $this->table = $table;
        $this->user_id = $user_id;
        $this->id = $id;
    }
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
      
        $has = DB::table($this->table)->select(['id',"$attribute",'user_id'])
        ->where('user_id',$this->user_id)->where("$attribute",trim($value))->whereNot('id',$this->id)->first();


        if ($has) {
            $fail('The :attribute AlReady Exists.');
        }
    }
}
