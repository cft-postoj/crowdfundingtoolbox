@extends('emails.layout')
@section('title', __('cft-emails.register.title'))

@section('body')
    {!! __('cft-emails.register.body') !!}
@endsection

@section('displayButton', 'table')
@section('buttonUrl', __('cftJSmessages.myAccountTexts.myAccountUrl') . '?generatedToken=' . $token . '&user=' . $portal_user_id . '&loggedIn=true')
@section('buttonText', __('cft-emails.register.buttonText'))
@section('buttonAlternative')
    {!!  __('cft-emails.register.buttonAlternative') !!}
@endsection

@section('footer')
    {!! __('cft-emails.register.notActionValidation') !!}
    {!! __('cft-emails.register.footer') !!}
@endsection

