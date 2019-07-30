@extends('emails.layout')
@section('title', 'Forgotten password')

@section('body')
    Hello,<br/>we have noticed a password reset request for your e-mail address at www.postoj.sk.<br/>
    <br/>
    Please click the following button to reset your password, <b>the link is valid for 1 hour</b>: <br/>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . '/moj-ucet#ucet?generatedResetToken=' . $token)
@section('buttonText', 'Reset your password')
@section('buttonAlternative', 'If you can\'t click the button, copy and paste the following link into your browser manually: ')