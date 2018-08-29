@component('mail::message')
# activation mail

hello {{$user->first_name}}
please click the button to active your account ya ahmed .

@component('mail::button', ['url' =>env('APP_URL','http://localhost:8000').'/activate/'.$user->email.'/'.$token])
active your account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
