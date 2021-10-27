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
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'nullable|exists:groups,id',
            'exp_date' => 'required|date',
            'exp_time' => 'required|date_format:H:i'
        ]);

        if($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()]);
        }

        $topic_id = DB::table('topics')->insertGetId([
            'user_id' => auth()->user()->id ?? null,
            'group_id' => $request->category,
            'title' => $request->title,
            'body' => $request->content,
            'expired_at' => $request->exp_date." ".$request->exp_time.":00",
            'created_at' => date("Y-m-d H:i:s")
        ]);

        $topic = DB::table('topics')->find($topic_id);

        return redirect()->route("topic.detail", date("Y", strtotime($topic->created_at)).$topic->id."-".str_replace('+', '-', urlencode($topic->title)));
    }
}
