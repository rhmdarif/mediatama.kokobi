<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    //
    public function index()
    {
        $groups = DB::table('groups')->get();
        return view('group', compact('groups'));
    }

    public function posts($group)
    {
        $group_code = trim(str_replace('-', '+', urldecode($group)));
        $group = DB::table('groups')->where("name", $group)->first();
        $latest_topics = DB::table('topics')
                            ->select('*', DB::raw("timediff(now(), created_at) as selisih"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                )
                            ->whereRaw("group_id = (SELECT id FROM groups WHERE name=? LIMIT 1)", [$group_code])
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        // return $latest_topics;
        return view('group-post', compact('latest_topics', 'group_code', 'group'));
    }
}
