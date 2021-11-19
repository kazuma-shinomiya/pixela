@extends('layouts.app')

@section('content')
<div class="container">
    <h1>詳細</h1>
    <h2>{{ $task->name }}</h2>
    <iframe src="https://pixe.la/v1/users/{{ Auth::user()->name }}/graphs/{{ $task->graph_id }}.html" width="600" height="1000"></iframe>
    <h1>値の投稿</h1>
    <form action="{{ route("amount.add", $task->id) }}" method="post">
        @csrf
        <input name="quantity" type="number">
        <input type="submit" value="送信">
    </form>
</div>
@endsection