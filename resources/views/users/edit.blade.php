@extends('layouts.app')
@section('content')

    <div class=" border-bottom white-bg dashboard-header div-custom">
        <div class="page-header" style=" border: 1px solid  rgba(215, 215, 215, 1); ">
            <h1 style=" margin-left: 5%; color: rgba(0, 180, 246, 1)">Users / Edit </h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <user-form user="{{$user}}" route="{{route('users.update', $user->id)}}" method="PATCH" csrf="{{csrf_token()}}"/>
            </div>
        </div>
    </div>
@endsection
