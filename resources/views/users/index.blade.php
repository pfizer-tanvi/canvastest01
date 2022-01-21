@extends('layouts.app')
@section('content')

    <div class=" border-bottom white-bg dashboard-header div-custom">
        <div class="page-header" style=" border: 1px solid  rgba(215, 215, 215, 1); ">
            <h1 style=" margin-left: 5%; color: rgba(0, 180, 246, 1)">List of Users</h1>
        </div>
        <br>

        <show-users csrf="{{csrf_token()}}"></show-users>

    </div>
@endsection
