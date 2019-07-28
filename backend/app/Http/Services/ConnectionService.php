<?php


namespace App\Http\Services;


class ConnectionService
{
    public function getPortalUrl()
    {
        return env('CFT_PORTAL_URL');
    }

    public function getBackendUrl()
    {
        return env('BACKEND_URL');
    }

    public function setPortalUrl($request)
    {
        $valid = validator($request->only(
            'url'
        ), [
            'url' => 'required|string|max:255|min:12'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }
        try {
            file_put_contents(app()->environmentFilePath(), str_replace(
                'CFT_PORTAL_URL' . '=' . $this->getPortalUrl(),
                'CFT_PORTAL_URL' . '=' . $request['url'],
                file_get_contents(app()->environmentFilePath())
            ));

            // Reload the cached config -- If you are on localhost, you need also restart server after change env
            exec('php artisan config:cache');
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}