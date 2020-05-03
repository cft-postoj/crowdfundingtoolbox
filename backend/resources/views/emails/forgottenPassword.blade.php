@extends('emails.layout')
@section('title', __('cft-emails.forgottenPassword.title'))

@section('body')
    {!! __('cft-emails.forgottenPassword.body') !!}
@endsection
@section('displayButton', 'table')
@section('buttonUrl',  __('cftJSmessages.myAccountTexts.myAccountUrl') . '#' . __('cftJSmessages.myAccountTexts.accountSlug') . '?generatedToken=' . $token . '&forgottenPassword=true&user=' . $portal_user_id)
@section('buttonText', __('cft-emails.forgottenPassword.buttonText'))
@section('buttonAlternative')
    {!!  __('cft-emails.forgottenPassword.buttonAlternative') !!}
@endsection

@section('footer')
    {!! __('cft-emails.forgottenPassword.notActionValidation') !!}
    {!! __('cft-emails.forgottenPassword.footer') !!}
@endsection