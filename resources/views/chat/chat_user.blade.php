@section ('styles')

@endsection
@extends('layouts.admin')
@section('General')


    <h1>Messages</h1>
    <a href="{{ URL::to('chat/') }}" class="btn btn-warning">Back to messages list</a>
    <a href="{{ URL::to('users/'.$chat_user->id) }}" style="margin-left:20px;" class="btn btn-success">Go to {{$chat_user->name}}'s profile</a>
    <div id="messageWindow">
       Currently online users on website :  <span class="badge" >@{{usersInChat.length }}</span>
        <chat-message ></chat-message>
        <chat-log :messages="messages" ></chat-log>

    </div>
    <chat-composer v-on:messagesent="addMessage"></chat-composer>

@endsection
@section ('scripts')

@endsection