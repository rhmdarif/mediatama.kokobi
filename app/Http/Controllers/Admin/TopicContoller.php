<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicContoller extends Controller
{
    //
    public function index()
    {
        $topics = DB::table('topics')
                    ->select(
                            "topics.*",
                            "groups.name as group_name",
                            DB::raw("(SELECT COUNT(*) FROM topic_comments WHERE topic_id=topics.id) as total_comments"),
                            DB::raw("(SELECT COUNT(*) FROM topic_likes WHERE topic_id=topics.id) as total_likes")
                        )
                    ->join('groups', 'groups.id', '=', 'topics.group_id')
                    ->orderBy('id', 'desc')->paginate(10);
        return view('admin.topic.index', compact('topics'));
    }
    public function byGroup($id)
    {
        $group = DB::table('groups')->where('id', $id)->first();
        $topics = DB::table('topics')
                    ->select(
                            "topics.*",
                            "groups.name as group_name",
                            DB::raw("(SELECT COUNT(*) FROM topic_comments WHERE topic_id=topics.id) as total_comments"),
                            DB::raw("(SELECT COUNT(*) FROM topic_likes WHERE topic_id=topics.id) as total_likes")
                        )
                    ->join('groups', 'groups.id', '=', 'topics.group_id')
                    ->where('group_id', $id)
                    ->orderBy('id', 'desc')->paginate(10);
        return view('admin.topic.index', compact('topics', 'group'));
    }
    public function byUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $topics = DB::table('topics')
                    ->select(
                            "topics.*",
                            "users.name as user_name",
                            DB::raw("(SELECT COUNT(*) FROM topic_comments WHERE topic_id=topics.id) as total_comments"),
                            DB::raw("(SELECT COUNT(*) FROM topic_likes WHERE topic_id=topics.id) as total_likes")
                        )
                    ->join('users', 'users.id', '=', 'topics.user_id')
                    ->where('user_id', $id)
                    ->orderBy('id', 'desc')->paginate(10);
        return view('admin.topic.index', compact('topics', 'user'));
    }

    public function show($url)
    {

        // URL FORMAT : Yid-Title
        $explode_url = explode('-', $url);
        $year = substr($explode_url[0], 0, 4);
        $id = substr($explode_url[0], 4);

        $explode_url[0] = '';
        $title = implode(' ', $explode_url);

        $topic = DB::table('topics')
                    ->select('topics.*',
                            'users.name as user_name',
                            'groups.name as group_name',
                            DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                            DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike"),
                            DB::raw("(SELECT count(*) FROM topic_comments WHERE topic_id=topics.id) as jumlah_comment")
                        )
                    ->join('users', 'users.id', '=', 'topics.user_id')
                    ->join('groups', 'groups.id', '=', 'topics.group_id')
                    ->where('topics.id', $id)
                    ->first();

        if($topic == null) {
            return redirect()->route('home');
        }

        // $topic_comments = DB::raw("SELECT")

        $topic_comments = DB::table('topic_comments')
                            ->select('*')
                            ->where('topic_id', $topic->id)
                            ->orderBy('id', 'desc')
                            ->get()->map(function($item) {
                                // return $item;
                                if($item->user_id != null) {
                                    $item->user_name = DB::table('users')->select('name')->find($item->user_id)->name;
                                }

                                return $item;
                            });
        return view('admin.topic.detail', compact('topic', 'topic_comments', 'url'));
    }

    public function chartBatang($url)
    {
        // URL FORMAT : Yid-Title
        $explode_url = explode('-', $url);
        $year = substr($explode_url[0], 0, 4);
        $id = substr($explode_url[0], 4);

        for ($i=11; $i >= 0; $i--) {
            $strtime= strtotime("-".$i." month", time());
            $query[] = DB::table('topics')->where('id', $id)->where("created_at", "like", date("%-m-%", $strtime))->count();
            $months[] = date("F", $strtime);
        }
        return ['data' => $query, "label" => $months];
    }

    public function chartPie($url)
    {
        // URL FORMAT : Yid-Title
        $explode_url = explode('-', $url);
        $year = substr($explode_url[0], 0, 4);
        $id = substr($explode_url[0], 4);

        return DB::table('topic_likes')
                ->selectRaw("type, COUNT(*) as total")
                ->where('topic_id', $id)
                ->groupBy('type')
                ->get();
    }
}
