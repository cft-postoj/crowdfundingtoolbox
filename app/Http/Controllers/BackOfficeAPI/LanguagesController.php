<?php

namespace App\Http\Controllers\BackOfficeAPI;

use App\BackOfficeAPI\Language;
use App\BackOfficeAPI\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class LanguagesController extends Controller
{
    public function get()
    {
        return response()->json(Language::all());
    }

    protected function create(Request $request)
    {
        $valid = validator($request->only(
            'slug',
            'name'), [
            'slug' => 'required|string|unique:languages,slug,NULL,id,deleted_at,NULL',
            'name' => 'required|string'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $data = \request()->only('slug', 'name');

        try {
            Language::create([
                'slug' => $data['slug'],
                'name' => $data['name']
            ]);


            // create translations ids
            $langId = Language::where('slug', $data['slug'])->firstorfail()->id;
            $transKeys = array_keys(Lang::get('cft-messages'));
            foreach ($transKeys as $key) {
                Translation::create([
                    'language_id'   =>  $langId,
                    'trans_id'  =>  $key
                ]);
            }

            return \response()->json([
                'message'   =>  'Successfully create language.'
            ], Response::HTTP_OK);


        } catch (\Exception $e) {
            return \response()->json([
                'error' =>  $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    protected function update(Request $request)
    {
        $valid = validator($request->only('id'), [
            'id' => 'required|integer'
        ]);

        if ($valid->fails()) {
            $jsonError = \response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $data = \request()->only('id', 'slug', 'name');

        try {
            Language::whereId($data['id'])->update($request->all());
            return \response()->json([
                'message' => 'Successfully updated language.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function delete(Request $request)
    {
        $valid = validator($request->only(
            'id'
        ), [
            'id' => 'required|integer'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $data = \request()->only('id');

        try {
            Language::destroy($data['id']);
            return \response()->json([
                'message' => 'Successfully removed language.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
