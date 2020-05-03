@extends('emails.layout')
@section('title', __('cft-emails.successfulDonation.title'))

@section('body')
    {!! __('cft-emails.successfulDonation.body') !!}
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . __('cftJSmessages.myAccountText.myAccountUrl'))
@section('buttonText', __('cft-emails.successfulDonation.buttonText'))
@section('buttonAlternative', __('cft-emails.successfulDonation.buttonAlternative'))