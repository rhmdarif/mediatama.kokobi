<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function index()
    {
        $latest_topics = DB::table('topics')
                            ->select('*', DB::raw("timediff(now(), created_at) as selisih"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                )
                            ->where('user_id', auth()->user()->id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(3);
        return view('user', compact('latest_topics'));
    }
}
