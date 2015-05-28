@extends('layout.emails')

@section('preheader')
Plase confirm your subscription to {{ Setting::get('app_name') }}
@stop

@section('content')
    <p>Please confirm your subscription by visiting {{ $link }}</p>

    <p>Thank you,</p>
    <p>{{ Setting::get('app_name') }} Status</p>

    @if(Setting::get('show_support'))
    <p>{!! trans('cachet.powered_by', ['app' => Setting::get('app_name')]) !!}</p>
    @endif
@stop
