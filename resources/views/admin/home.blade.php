@extends('templates.admin_template')

@section('content')
    <div class="container" style="margin-top: 50px;">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="my-4">Posts
                    {{--<small>Secondary Text</small>--}}
                </h1>

                <!-- Blog Post -->
                @if(isset($posts))
                    @foreach($posts as $post)
                        <div class="card mb-4">
                            {{--<img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">--}}
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h2 class="card-title">{{ $post['title'] }}</h2>
                                </div>
                                <div class="d-inline-block float-right">
                                    <span class="badge badge-warning">Threat Level: {{ $post['threat_level'] }}</span>
                                </div>
                                <p class="card-text">{{ str_limit($post['description'], 200) }}</p>
                                <a href="{{ route('view_post', ['id' => $post['id'] ]) }}" class="btn btn-primary float-right">Read More <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-footer text-muted">
                                Posted on {{ date("d M Y", strtotime($post['created_at'])) }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="margin-top: 70px;">No one seems to have written any posts at the moment. Check back later</p>
                @endif

                <!-- Blog Post -->
                {{--<div class="card mb-4">--}}
                    {{--<img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">--}}
                    {{--<div class="card-body">--}}
                        {{--<h2 class="card-title">Post Title</h2>--}}
                        {{--<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>--}}
                        {{--<a href="#" class="btn btn-primary">Read More &rarr;</a>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer text-muted">--}}
                        {{--Posted on January 1, 2017 by--}}
                        {{--<a href="#">Start Bootstrap</a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<!-- Blog Post -->--}}
                {{--<div class="card mb-4">--}}
                    {{--<img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">--}}
                    {{--<div class="card-body">--}}
                        {{--<h2 class="card-title">Post Title</h2>--}}
                        {{--<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>--}}
                        {{--<a href="#" class="btn btn-primary">Read More &rarr;</a>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer text-muted">--}}
                        {{--Posted on January 1, 2017 by--}}
                        {{--<a href="#">Start Bootstrap</a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <!-- Pagination -->
                {{--<ul class="pagination justify-content-center mb-4">--}}
                    {{--<li class="page-item">--}}
                        {{--<a class="page-link" href="#">&larr; Older</a>--}}
                    {{--</li>--}}
                    {{--<li class="page-item disabled">--}}
                        {{--<a class="page-link" href="#">Newer &rarr;</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{ $posts->links('paginator', [
                    'nextPageUrl' => $posts->nextPageUrl(),
                    'previousPageUrl' => $posts->previousPageUrl(),
                ]) }}
            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Search Widget -->
                <div class="card my-4" style="border: none">
                    <div class="card-body">
                        <form action="{{ route('add_post_index') }}" method="GET">
                            {{--<input type="submit" class="btn btn-primary btn-block" value="Add New Post">--}}
                            <button class="btn btn-success btn-block">Add New Post</button>
                        </form>
                    </div>
                </div>

                <!-- Categories Widget -->
                {{--<div class="card my-4">--}}
                    {{--<h5 class="card-header">Categories</h5>--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-lg-6">--}}
                                {{--<ul class="list-unstyled mb-0">--}}
                                    {{--<li>--}}
                                        {{--<a href="#">Web Design</a>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<a href="#">HTML</a>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<a href="#">Freebies</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-6">--}}
                                {{--<ul class="list-unstyled mb-0">--}}
                                    {{--<li>--}}
                                        {{--<a href="#">JavaScript</a>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<a href="#">CSS</a>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<a href="#">Tutorials</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="card my-4">
                    <h5 class="card-header">Site Messages</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-11">
                                <ul class="list-unstyled mb-0">
                                    <li style="color: {{ isset($status) ? "green" : "red"}}">
                                        {{ isset($status) ? $status : "No messages to show"}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<!-- Side Widget -->--}}
                {{--<div class="card my-4">--}}
                    {{--<h5 class="card-header">Side Widget</h5>--}}
                    {{--<div class="card-body">--}}
                        {{--You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!--}}
                    {{--</div>--}}
                {{--</div>--}}

            </div>

        </div>
        <!-- /.row -->

    </div>
@endsection