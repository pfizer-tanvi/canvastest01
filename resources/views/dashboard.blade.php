@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    Content here.
                    <auth-example></auth-example>
                </div>
                @can('feature-flag', 'test-feature-flag')
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-default">
                                <div class="card-header">Feature Flag</div>
                                <p class="card-body"> ON</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

            </div>
        </div>
    </div>
</div>
@endsection
