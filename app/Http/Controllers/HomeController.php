<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        if (auth()->check()) {

            $latest_topics = DB::table('topics')
                                ->select('*',
                                        DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                                        DB::raw("timediff(now(), expired_at) as selisih"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                    )
                                ->where(function ($query) {

                                    $query->whereNull('group_id')
                                        ->orWhereRaw("group_id IN (SELECT group_id FROM user_groups WHERE user_id=?)", [auth()->user()->id]);

                                })
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
            // ONLY PIMPINAN
            /*
            $latest_topics = DB::table('topics')
                                ->select('*',
                                        DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                                        DB::raw("timediff(now(), expired_at) as selisih"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                    )
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
            */
        } else {

            $latest_topics = DB::table('topics')
            ->select('*',
                    DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                    DB::raw("timediff(now(), expired_at) as selisih"),
                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                )
            ->whereNull('group_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        // return $latest_topics;
        return view('home', compact('latest_topics'));
    }
    public function tranding()
    {
        // return date("Y-m-d 23:59:59", strtotime("-30 days", strtotime(date("Y-m-d"))));


        if (auth()->check()) {

            $tranding_topics = DB::table('topics')
                                ->select('*',
                                        DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                                        DB::raw("timediff(now(), expired_at) as selisih"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                    )
                                ->where(function ($query) {

                                    $query->whereNull('group_id')
                                        ->orWhereRaw("group_id IN (SELECT group_id FROM user_groups WHERE user_id=?)", [auth()->user()->id]);

                                })
                                ->whereBetween('created_at', [date("Y-m-d 00:00:00", strtotime("-30 days", time())), date("Y-m-d 23:59:59")])
                                ->orderByRaw("(SELECT count(id) FROM topic_comments WHERE topic_id=topics.id) DESC")
                                ->paginate(10);
            // ONLY PIMPINAN
            /*
            $latest_topics = DB::table('topics')
                                ->select('*',
                                        DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                                        DB::raw("timediff(now(), expired_at) as selisih"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                        DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                    )
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
            */
        } else {

            $tranding_topics = DB::table('topics')
            ->select('*',
                    DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                    DB::raw("timediff(now(), expired_at) as selisih"),
                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                )
            ->whereNull('group_id')
            ->whereBetween('created_at', [date("Y-m-d 00:00:00", strtotime("-30 days", time())), date("Y-m-d 23:59:59")])
            ->orderByRaw("(SELECT count(id) FROM topic_comments WHERE topic_id=topics.id) DESC")
            ->paginate(10);
        }


        // $tranding_topics = DB::table('topics')
        //                     ->select('*',
        //                             DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
        //                             DB::raw("timediff(now(), expired_at) as selisih"),
        //                             DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
        //                             DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike"),
        //                             DB::raw("(SELECT count(id) FROM topic_comments WHERE topic_id=topics.id) as jumlah_comment")
        //                         )
        //                     ->whereBetween('created_at', [date("Y-m-d 00:00:00", strtotime("-30 days", time())), date("Y-m-d 23:59:59")])
        //                     ->orderByRaw("(SELECT count(id) FROM topic_comments WHERE topic_id=topics.id) DESC")
        //                     ->paginate(10);
                            // ->get();
        // return $tranding_topics;
        return view('tranding', compact('tranding_topics'));
    }
}
