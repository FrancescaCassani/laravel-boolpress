@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your posts</h1>

    @if($posts->isEmpty())
        <p>No trip has been created yet.</p>
    @else
        {{-- POST TABLE --}}
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th colspan="3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                {{-- Sessione post cancellazione --}}
                    @if (session('post-deleted'))
                        <div class="alert alert-success">
                            Post {{$post->title}} has been deleted successfully
                        </div>
                    @endif
                    <tr>
                        <td>{{$post->id }}</td>
                        <td>{{$post->title }}</td>
                        <td>{{$post->created_at->format('d/m/Y') }}</td>

                        <td>
                            <a href="" class="btn btn-success">Show</a>
                        </td>
                        <td>
                            <a href="{{route('admin.posts.edit', $post->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
