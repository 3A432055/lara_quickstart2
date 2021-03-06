<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use App\Task;
use Auth;
class TaskController extends Controller
{
    /**
     * 任務資源庫的實例。
     *
     * @var TaskRepository
     */
    protected $tasks;
    /**
     * 建立新的控制器實例。
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
   public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
          $this->tasks = $tasks;
    }
     //檢查使用者的認證，
    /**
     * 顯示使用者所有任務的清單。
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
       // $tasks = Task::where('user_id', $request->user()->id)->get();
       // $tasks=auth()->user()->tasks()->get();
        // $tasks=auth()->user()->tasks()->get();
        // $tasks=Auth::user()->tasks;
        // $tasks=Auth::user()->tasks()->get();

        $tasks=Auth::user()->tasks()->paginate(4);
        //dd($tasks);
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * 建立新的任務。
     *
     * @param  Request  $request
     * @return Response
     */
    /*
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        // Create The Task...
    }
    */
    public function store(Request $request)
    {
        //驗證接收到的表單輸入並建立新的任務
        //讓 name 欄位為必填，且它必須少於 255 字元
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        //建立任務
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);
        return redirect('/tasks');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }
    /**
     * 移除給定的任務。
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);
        $task->delete();
        return redirect('/tasks');
    }
}
