@extends('emails.layout')
@section('title', 'Thank you for supporting')

@section('body')
    Hello,<br/>thank you for donating www.postoj.sk.<br/>
    <br/>
    <hr>
    If you didn't send money yet, please use these information:<br />
    IBAN: <b>{{$iban}}</b><br />
    VARIABLE SYMBOL: <b>{{$variableSymbol}}</b>
    <hr>
    <br />
    We created new account for you and you can set your password for your account here: {{env('CFT_PORTAL_URL')}}?setPassword={{$emailToken}}
    Please click on the following button, fill in all your contact details and get a gift. The link is valid for 1 hour from delivery. <br/>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . '/moj-ucet?generatedResetToken=' . $emailToken . '&loggedIn=true')
@section('buttonText', 'My account')
@section('buttonAlternative', 'If you can\'t click the button, copy and paste the following link into your browser manually: ')

