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
    <br/>
    To ensure, that we can give you all benefits, please visit your profile and check your personal data.
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . '/moj-ucet')
@section('buttonText', 'My account')
@section('buttonAlternative', 'If you can\'t click the button, copy and paste the following link into your browser manually: ')
