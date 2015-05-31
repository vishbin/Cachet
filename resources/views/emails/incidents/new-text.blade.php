New incident has been reported on {{ Setting::get('app_name') }}

Thank you,
{{ Setting::get('app_name') }}
@if(Setting::get('show_support'))
{!! trans('cachet.powered_by', ['app' => Setting::get('app_name')]) !!}
@endif
