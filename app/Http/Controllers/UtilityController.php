<?php

namespace App\Http\Controllers;

use App\Service\Dropdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    

    public function dropdowns(Request $request,$slug){
        $rep = new Dropdown($request->user_id);

        return $rep->{$slug}();
    }

    public function markAsReadNotify($id){
        DB::table('notifications')->where('id',$id)->update(['read_at'=>now()]);
    }
}
