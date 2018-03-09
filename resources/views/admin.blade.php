@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin</div>

                <div class="panel-body">
                        <a href="/admin/conversation">Conversation Room</a>
                        <br>
                        <a href="/admin/manage">Manage User</a>
                        <br>
                        <a href="/admin/word">Manage Blocklist Word</a>
                        <br>
                    
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection