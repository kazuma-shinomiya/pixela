<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        
        return view('tasks.index')->with(['tasks' => $tasks]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Task $task)
    {
        $user = Auth::user();
        $graph_id = 'a' . strtolower(Str::random(5)) . '-' . strtolower(Str::random(5));
        $params = [
                'id' => $graph_id,
                'name' => $request->name,
                'unit' => $request->unit,
                'type' => $request->type,
                'color' => "shibafu",
            ];
        $params = json_encode($params);
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'POST',
            'https://pixe.la/v1/users/' . $user->name . '/graphs', 
            [
                'headers' => [
                    'X-USER-TOKEN' => $user->email,
                ],
                'body' => $params,
            ]
        );
        
        $input = $request->all();
        $task->fill($input);
        $task->user_id = $request->user()->id;
        $task->graph_id = $graph_id;
        $task->save();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show')->with(['task' => $task]); 
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
    
    public function addAmount(Task $task, Request $request)
    {
        $user = Auth::user();
        $today = date("Ymd");
        $params = [
                'date' => $today,
                'quantity' => $request->quantity,
            ];
        $params = json_encode($params);
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'POST',
            'https://pixe.la/v1/users/' . $user->name . '/graphs/' . $task->graph_id, 
            [
                'headers' => [
                    'X-USER-TOKEN' => $user->email,
                ],
                'body' => $params,
            ]
        );

        return redirect()->route('tasks.show', $task->id);
    }
}
