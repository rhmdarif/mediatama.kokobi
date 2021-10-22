<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view("admin.home");
    }

    public function chartBatang()
    {
        for ($i=11; $i >= 0; $i--) {
            $strtime= strtotime("-".$i." month", time());
            $query[] = DB::table('topics')->where("created_at", "like", date("%-m-%", $strtime))->count();
            $months[] = date("F", $strtime);
        }
        return ['data' => $query, "label" => $months];
    }

    public function chartPie()
    {
        return DB::table('topic_likes')
                ->selectRaw("type, COUNT(*) as total")
                ->groupBy('type')
                ->get();
    }
}
