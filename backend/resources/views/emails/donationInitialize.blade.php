@extends('emails.layout')
@section('title', __('cft-emails.donationInitialize.title'))

@section('body')
    {!! __('cft-emails.donationInitialize.bodyPart1') !!}
    <br/>
    <br/>
    <hr>
    {!! __('cft-emails.donationInitialize.bodyPart2') !!}
    <br />
    IBAN: <b>{{$iban}}</b><br />
    {!! __('cft-emails.donationInitialize.variableSymbol') !!}: <b>{{$variableSymbol}}</b>
    <hr>
    <br/>
    {!! __('cft-emails.donationInitialize.bodyPart3') !!}
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . __('cftJSmessages.myAccountTexts.myAccountUrl'))
@section('buttonText', __('cft-emails.donationInitialize.buttonText'))
@section('buttonAlternative', __('cft-emails.donationInitialize.buttonAlternative'))
