<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TopicDetailController extends Controller
{
    //
    public function index($url)
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
                            DB::raw("(SELECT count(*) FROM topic_likes WHERE topic_id=topics.id AND type=0) as jumlah_dislike")
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

        return view('topic-detail', compact('topic', 'topic_comments', 'url'));
    }

    public function _store(Request $request)
    {
        return back()->with($this->store_comment($request));
    }

    public function store_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|exists:topics,id',
            'comment' => 'required|string',
            'device_id' => 'required|string'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        DB::table('topic_comments')
            ->insert([
                'topic_id' => $request->topic,
                'user_id' => auth()->user()->id ?? null,
                'comment' => $request->comment,
                'device_id' => $request->device_id,
                'created_at' => date("Y-m-d H:i:s")
            ]);

        return ['status' => true, 'msg' => "Comment telah dibuat"];
    }

    public function _store_like(Request $request)
    {
        return back()->with($this->store_like($request));
    }

    public function store_like(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|exists:topics,id',
            'device_id' => 'required|string',
            'type' => 'required|in:0,1'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $check_like = DB::table('topic_likes')
                        ->where('topic_id', $request->topic)
                        ->where('device_id', $request->device_id)
                        ->count();
        if($check_like == 0) {
            DB::table('topic_likes')->insert([
                'topic_id' => $request->topic,
                'device_id' => $request->device_id,
                'type' => $request->type
            ]);
        }

        return ['status' => true, 'msg' => "has Liked"];
    }

    public function _store_share(Request $request)
    {
        return back()->with($this->store_like($request));
    }

    public function store_share(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|exists:topics,id',
            'device_id' => 'required|string',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $check_share = DB::table('topics')
                        ->where('id', $request->topic)
                        ->first();

        if($check_share != null) {
            DB::table('topics')->where("id", $request->topic)->update([
                'share_count' => $check_share->share_count+1
            ]);
        }

        return ['status' => true, 'msg' => "has shared"];
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'comment_id' => 'required|exists:topic_comments,id'
        ]);

        if($validator->fails()) {
            return ["status" => false, "msg" => $validator->errors()->first()];
        }

        DB::table('topic_comments')->where('device_id', $request->device_id)->where('id', $request->comment_id)->delete();
        return ["status" => true, "msg" => "Komentar telah dihapus"];
    }
}
