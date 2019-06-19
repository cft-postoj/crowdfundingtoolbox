@extends('emails.layout')
@section('title', 'ZABUDNUTÉ HESLO')

@section('body')
    Dobrý deň,<br/>zaznamenali sme požiadavku na reset hesla pre Vašu e-mailovú adresu na portáli www.postoj.sk.<br/>
    <br/>
    Pre reset hesla prosím kliknite na nasledujúce tlačidlo, <b>odkaz je platný 1 hodinu</b>: <br/>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', 'http://www.postoj.local:8000/moj-ucet#ucet?generatedResetToken=' . $token)
@section('buttonText', 'Reset hesla')
@section('buttonAlternative', 'V prípade, že nemôžete kliknúť na tlačidlo, skopírujte si nasledujúci link do prehliadača manuálne: ')