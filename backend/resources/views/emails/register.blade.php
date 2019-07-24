@extends('emails.layout')
@section('title', 'Thank you for register')

@section('body')
    Hello,<br/>we would like to thank you for registering at www.postoj.sk.<br/>
    <br/>
    Please click on the following button, fill in all your contact details and get a gift. The link is valid for 1 hour from delivery. <br/>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', $portal_url . '/moj-ucet?generatedResetToken=' . $token . '&loggedIn=true')
@section('buttonText', 'My account')
@section('buttonAlternative', 'If you can\'t click the button, copy and paste the following link into your browser manually: ')