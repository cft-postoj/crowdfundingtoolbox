<?php

namespace Modules\Translations\Http\Controllers;

use Modules\Translations\Entities\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class TranslationsController extends Controller
{
    public function getDefault()
    {
        App::setLocale('en');
        return response()->json(Lang::get('cft-messages'), Response::HTTP_OK);
    }

    public static function getTranslationsById($id)
    {
        $translations = Translation::select('language_id', 'trans_id', 'trans_string')->get();
        $transResults = [];
        foreach ($translations as $translation) {
            if ($translation['language_id'] == $id) {
                array_push($transResults, $translation);
            }
        }
        return response()->json($transResults, Response::HTTP_OK);
    }


}
