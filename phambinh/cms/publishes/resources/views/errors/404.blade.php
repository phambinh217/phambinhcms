@extends('Cms::layouts.error', [
    'body_class' => 'page-404-full-page',
])

@php \Metatag::set('title', '404'); @endphp

@section('content')
<div class="row">
    <div class="col-md-12 page-404">
        <div class="number font-red"> 404 </div>
        <div class="details">
            <h3>Oops! You're lost.</h3>
            <p> We can not find the page you're looking for.
                <br/>
                <a href="{{ url('/') }}"> Return home </a> or try the search bar below. </p>
            </div>
        </div>
    </div>
@endsection
