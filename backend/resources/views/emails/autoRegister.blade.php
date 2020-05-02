@extends('emails.layout')
@section('title', __('cft-emails.thankYouForSupporting.title'))

@section('body')
    {!! __('cft-emails.thankYouForSupporting.bodyPart1') !!}
    <br/>
    <br/>
    <hr>
    {!! __('cft-emails.thankYouForSupporting.bodyPart1') !!}
    <br />
    IBAN: <b>{{$iban}}</b><br />
    {!! __('cft-emails.thankYouForSupporting.variableSymbol') !!}: <b>{{$variableSymbol}}</b>
    <hr>
    <br />
    {!! __('cft-emails.thankYouForSupporting.bodyPart3') !!}
    <br/>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', env('CFT_PORTAL_URL') . __('cftJSmessages.myAccountTexts.myAccountUrl') . '#' . __('cftJSmessages.myAccountTexts.accountSlug') . '?generatedToken=' . $token . '&loggedIn=true')
@section('buttonText', __('cft-emails.thankYouForSupporting.buttonText'))
@section('buttonAlternative', __('cft-emails.thankYouForSupporting.buttonAlternative'))

