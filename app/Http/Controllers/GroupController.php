<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    //
    public function index()
    {
        if(auth()->check()) {
            $groups = DB::table('user_groups')->select('groups.*')->join('groups', 'groups.id', 'user_groups.group_id')->where('user_groups.status', 'active')->where('user_groups.user_id', auth()->user()->id)->get();
        } else {
            $groups = DB::table('groups')->get();
        }
        return view('group', compact('groups'));
    }

    public function posts($group_id)
    {
        $group = DB::table('groups')->where("id", $group_id)->first();
        $latest_topics = DB::table('topics')
                            ->select('*',
                                    DB::raw("IF(now() < expired_at, 'active', 'expired') as status"),
                                    DB::raw("timediff(now(), expired_at) as selisih"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=1) as jumlah_like"),
                                    DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
                                )
                            ->whereRaw("group_id = (SELECT id FROM groups WHERE id=? LIMIT 1)", [$group_id])
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        // return $group;
        return view('group-post', compact('latest_topics', 'group'));
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invite_code' => 'required|string'
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }

        $group = DB::table('groups')->where('invite_code', $request->invite_code)->first();
        if ($group == null) {
            return back()->with("error", "Kode Grup tidak valid");
        }

        $check = DB::table('user_groups')->where('user_id', auth()->user()->id)->where('group_id', $group->id)->first();
        if($check == null) {
            $group_id = DB::table('user_groups')->insertGetId([
                'user_id' => auth()->user()->id,
                'group_id' => $group->id,
            ]);
        } else {
            $group_id = $check->id;
        }

        return back()->with("success", "Permintaan bergabung telah dikirimkan.");
    }
}
