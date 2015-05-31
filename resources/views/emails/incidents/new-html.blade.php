@extends('layout.emails')

@section('preheader')
New incident has been reported on {{ Setting::get('app_name') }}
@stop

@section('content')
    <p>New incident has been reported on {{ Setting::get('app_name') }}</p>

    <p>Thank you,</p>
    <p>{{ Setting::get('app_name') }} Status</p>

    @if(Setting::get('show_support'))
    <p>{!! trans('cachet.powered_by', ['app' => Setting::get('app_name')]) !!}</p>
    @endif
@stop
