@extends('layouts.app')
@section('content')

    <div class=" border-bottom white-bg dashboard-header" style="margin-left: 5%;
                                                                margin-right: 5%;
                                                                min-height: 500px;
                                                                background-color: rgba(255, 255, 255, 1);
                                                                border: 1px solid rgba(0, 0, 0, 0.1);
                                                                border-radius: 4px;
                                                                box-shadow: 0px 20px 40px 0px rgba(0, 0, 0, 0.1);
    ">

        <b-card-group deck  class="mb-3" style="width: 90%;margin-left: 5%;margin-top: 5%;">

            <b-card title="Admin users"
                    border-variant="secondary"
                    tag="article"
                    style="max-width: 30rem;"
                    class="mb-2">
                <p class="card-text">
                    Show user, edit or delete and user from database.
                </p>
                <b-button href="{{ route('users.index') }}" dusk="adminUsers" variant="primary">Access</b-button>
            </b-card>

            <b-card title="Example"
                    border-variant="secondary"
                    tag="article"
                    style="max-width: 30rem;margin-left: 10%;"
                    class="mb-2">
                <p class="card-text">
                    Access example of how to use vue and test of basic connections as: SQS, S3, Feature flag, Logs
                </p>
                <b-button href="/example" dusk="example" variant="primary">Access</b-button>
            </b-card>

        </b-card-group>

    </div>
@endsection
