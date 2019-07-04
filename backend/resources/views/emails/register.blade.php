@extends('emails.layout')
@section('title', 'Ďakujeme za registráciu.')

@section('body')
    Dobrý deň,<br/>radi by sme Vám poďakovali za registráciu na portáli www.postoj.sk.<br/>
    <br/>
    Prosím, kliknite na nasledujúce tlačidlo, vyplňte všetky Vaše kontaktné údaje a získajte darček. Odkaz je platný 1 hodinu od doručenia. <br/>
@endsection

@section('displayButton', 'table')
@section('buttonUrl', $portal_url . '/moj-ucet?generatedResetToken=' . $token . '&loggedIn=true')
@section('buttonText', 'Môj účet')
@section('buttonAlternative', 'V prípade, že nemôžete kliknúť na tlačidlo, skopírujte si nasledujúci link do prehliadača manuálne: ')