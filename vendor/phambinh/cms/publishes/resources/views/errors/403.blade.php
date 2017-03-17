@extends('Cms::layouts.error', [
    'body_class' => 'page-404-full-page',
])

@php \Metatag::set('title', '403'); @endphp

@section('content')
<div class="row">
    <div class="col-md-12 page-404">
        <div class="number font-red"> 403 </div>
        <div class="details">
            <h3>Forbidon</h3>
            <p> You don't have permission
                <br/>
                <a href="{{ url('/') }}"> Return home </a> or try the search bar below. </p>
            </div>
        </div>
    </div>
@endsection
