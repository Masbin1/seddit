@extends('layouts/master')

@section('title', 'Seddit')


@section('content')

    <div class="container">
        <h1 class="h2">{{ $user->username }}</h1><br />
            <div class="posts-list">
                <h2 class="h4">posts</h2>
                @foreach ($posts as $post)
                    <div class="individual_post">
                        <li>
                            <a class="post_links" href="{{ $post->url }}" target="_blank">
                                <strong>{{ $post->content }}</strong>
                            </a> 
                            - (<span class="vote_count" id="{{ $post->id }}">{{ $post->votes }}</span>)
                            @if (Auth::check())
                                - <a id="{{ $post->id }}" class="@if(Auth::user()->getVoteForPost(Auth::user()->id, $post->id) == 1) voted_up @endif arrows upvote_arrows all_posts_arrow">↑</a> 
                                <a id="{{ $post->id }}" class="@if(Auth::user()->getVoteForPost(Auth::user()->id, $post->id) == -1) voted_down @endif arrows all_posts_arrow">↓</a>
                            @else 
                                - <a href="/register" class="arrows upvote_arrows all_posts_arrow">↑</a> 
                                <a href="/register" class="arrows all_posts_arrow">↓</a>
                            @endif
                            - <a href="/comment/{{ $post->id }}">link</a>
                        </li> 
                    </div>
                @endforeach
            </div>

            <br />

            <div class="comments-list">
                <h2 class="h4">comments</h2>
                @foreach ($comments as $comment)
                    <div class="individual_post">
                        <li class="comment-box">
                            <strong>{!! nl2br($comment->makeClickableLinks($comment->comment)) !!}</strong>

                            {{-- Placeholder span so voting js still works correctly by targeting the correct index for elements --}}
                            <span></span>
                            
                            - (<span class="vote_count comment_vote_count" id="{{ $comment->id }}">{{ $comment->votes }}</span>)
                            @guest 
                                - <a href="/register" class="upvote_arrows comment_arrows">↑</a> 
                                <a href="/register" class="comment_arrows">↓</a>
                            @else 
                                - <a id="{{ $comment->id }}" class="arrows @if (Auth::user()->getVoteForComment(Auth::user()->id , $comment->id) == 1) voted_up @endif upvote_arrows comment_arrows">↑</a> 
                                <a id="{{ $comment->id }}" class="arrows @if (Auth::user()->getVoteForComment(Auth::user()->id , $comment->id) == -1) voted_down @endif comment_arrows">↓</a>
                            @endguest

                            - <a href="/comment/{{ $comment->post_id }}">link</a>
                        </li> 
                    </div>
                @endforeach
            </div>
    </div>

@endsection
