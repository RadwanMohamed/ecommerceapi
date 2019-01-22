@component('mail::message')
#Hello, {{$user->name}} 

you have changed your Email, so please veify the account using the following link: 

@component('mail::button', ['url' => route('verify',$user->verification_token)])
verify accont
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
