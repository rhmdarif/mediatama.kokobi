<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    //
    public function index()
    {
        $categories = DB::table('groups')->get();
        return view('topic-form', compact("categories"));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|exists:groups,id',
        ]);

        if($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()]);
        }

        $topic_id = DB::table('topics')->insertGetId([
            'user_id' => auth()->user()->id,
            'group_id' => $request->category,
            'title' => $request->title,
            'body' => $request->content,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        $topic = DB::table('topics')->find($topic_id);

        return redirect()->route("topic.detail", date("Y", strtotime($topic->created_at)).$topic->id."-".str_replace('+', '-', urlencode($topic->title)));
    }
}
