@extends('layouts.app')

@section('content')
<div class="container">
    <h1>作成</h1>
    <div>
        <form action="{{ route('tasks.store') }}" method="post">
        @csrf
            <input name="name" placeholder="タスク名">
            <input name="unit" placeholder="単位">
            <input name="type" placeholder="タイプ">
            <input type="submit" value="送信">
        </form>
    </div>
</div>
@endsection