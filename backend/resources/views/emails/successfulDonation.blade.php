@extends('emails.layout')
@section('title', 'Thank you for your donation.')

@section('body')
    Hello,
    we have great news for you.<br />
    Your donation was successfully assigned to our bank account and we would like to say <b>BIG THANK YOU</b>!
    <br />
    You can see all interesting in your account:
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . '/moj-ucet')
@section('buttonText', 'My account')
@section('buttonAlternative', 'If you can\'t click the button, copy and paste the following link into your browser manually: ')