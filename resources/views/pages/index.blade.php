@extends('layouts.main')

@section('title') 
  @lang('translation.App') 
@endsection

@section('body')

<main id="app">
  <index-component :trans="{{json_encode(Lang::get('translation'))}}" ></index-component>
</main>

@endsection

@section('js')
<script src="{{ mix('/js/app.js') }}"></script>
@endsection