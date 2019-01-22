@component('mail::message')
#Hello, {{$user->name}} 

thanke u for create an account. please veify the account using the following link: 

@component('mail::button', ['url' => route('verify',$user->verification_token)])
verify accont
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
