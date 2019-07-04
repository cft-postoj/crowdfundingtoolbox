@extends('emails.layout')
@section('title', 'Welcome, you have a new account on CrowdfundingToolbox app.')

@section('body')
    Hello, you have a new account on CrowdfungingToolbox app. You can sign to the app via your email or unique username
    <b>{{$username}}</b>.<br/>
    In this email there is one time url (button) with generated reset token. Please, change your password in your profile after you click on url.
    <br/><br/>

    <i>If you have any troubles, please contact administrator.</i>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env("CFT_URL") . '/login?generatedResetToken=' . $token . '&loggedIn=true')
@section('buttonText', 'My account')
@section('buttonAlternative', 'If you can\'t click the button, copy the following link to your browser manually: ')