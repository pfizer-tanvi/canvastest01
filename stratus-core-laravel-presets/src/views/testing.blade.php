@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!-- great place to test components -->
    <!-- <loading :loading="true"></loading> -->
    <testing>
        <loading v-if="this.$store.state.loading"></loading>
    </testing>
</div>
@endsection
