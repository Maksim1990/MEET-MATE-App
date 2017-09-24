@section ('styles')

@endsection
@extends('layouts.admin')
@section('General')


    <h1>Messages</h1>
    <a href="{{ URL::to('chat/') }}">Back to messages list</a>
    <div id="messageWindow">
        <span class="badge" >@{{usersInChat.length }}</span>
        <chat-message ></chat-message>
        <chat-log :messages="messages" ></chat-log>

    </div>
    <chat-composer v-on:messagesent="addMessage"></chat-composer>

@endsection
@section ('scripts')

@endsection