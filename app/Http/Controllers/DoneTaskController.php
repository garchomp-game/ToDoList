<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Task;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DoneTaskRequest;

class DoneTaskController extends Controller
{
    public function index(DoneTaskRequest $request)
    {

        $id = Auth::id();
        $categoryData = Category::where('user_id', $id)->where('delete_flg', false)->get();
        $status = $request->session()->get('status');
        if (!empty($request->search)) {
            $query = Task::query();
            // 検索するパラメータを取得
            $s_name = $request->search_name;
            $s_category = $request->search_category;
            $s_strat_date = $request->strat_date;
            $s_end_date = $request->end_date;
            $s_sort = $request->sort;
            $s_submit = $request->search;

            $query->where('user_id', $id)->where('done_flg', true);

            if (!empty($s_name)) {
                $query->where('task_name', 'like', '%' . $s_name . '%');
            }

            if ($s_category !== '0') {
                $query->whereHas('Category', function ($query) {
                    $query->where('category_no', Input::get('search_category'));
                });
            }

            if(!empty($s_strat_date)){
                $query-> whereDate( 'updated_at','>=',$s_strat_date);
            }
            if(!empty($s_end_date)){
                $query->whereDate('updated_at', '<=', $s_end_date);
            }

            if ($s_sort === 'new') {
                $query->orderBy('updated_at', 'desc');
            } else {
                $query->orderBy( 'updated_at', 'asc');
            }
            $taskData = $query->paginate(5);

            return view( 'doneTask', ['category_data' => $categoryData, 'task_data' => $taskData, 'status' => $status])
                ->with('search_name', $s_name)
                ->with('search_category', $s_category)
                ->with( 'strat_date', $s_strat_date)
                ->with( 'end_date', $s_end_date)
                ->with('sort', $s_sort)
                ->with('search', $s_submit);
        } else {
            $taskData = Task::where('user_id', $id)->where('done_flg', true)->orderBy( 'updated_at', 'desc')->paginate(5);
            return view('doneTask', ['category_data' => $categoryData, 'task_data' => $taskData, 'status' => $status]);
        }
    }

    public function restore(Request $request)
    {

        $task = Task::where('id', $request->id)->first();
        $task->done_flg = false;
        $task->save();
        $request->session()->flash('status', 'タスクを復元しました。');

        return redirect()->action('DoneTaskController@index', $request);
    }
}
