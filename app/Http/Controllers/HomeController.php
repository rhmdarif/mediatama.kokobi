<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        $latest_topics = DB::table('topics')
                            ->select('*', DB::raw("timediff(now(), created_at) as selisih"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                )
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        // return $latest_topics;
        return view('home', compact('latest_topics'));
    }
    public function tranding()
    {
        // return date("Y-m-d 23:59:59", strtotime("-30 days", strtotime(date("Y-m-d"))));
        $tranding_topics = DB::table('topics')
                            ->select('*', DB::raw("timediff(now(), created_at) as selisih"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike"),
                                    DB::raw("(SELECT count(id) FROM topic_comments WHERE topic_id=topics.id) as jumlah_comment")
                                )
                            ->whereBetween('created_at', [date("Y-m-d", strtotime("-30 days", strtotime(date("Y-m-d")))), date("Y-m-d")])
                            ->orderByRaw("(SELECT count(id) FROM topic_comments WHERE topic_id=topics.id) DESC")
                            ->paginate(10);
                            // ->get();
        // return $tranding_topics;
        return view('tranding', compact('tranding_topics'));
    }
}
