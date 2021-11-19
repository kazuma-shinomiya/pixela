@extends('layouts.app')

@section('content')
<div class="container">
    <h1>一覧</h1>
    <a href="{{ route('tasks.create') }}">新規投稿</a>
    <div>
        @foreach($tasks as $task)
        <div>
            <a href='{{ route('tasks.show', $task->id) }}'><h1>{{ $task->name }}</h1></a>
            <iframe src="https://pixe.la/v1/users/{{ Auth::user()->name }}/graphs/{{ $task->graph_id }}.html" width="600" height="1000"></iframe>
        </div>
        @endforeach
    </div>
</div>
@endsection