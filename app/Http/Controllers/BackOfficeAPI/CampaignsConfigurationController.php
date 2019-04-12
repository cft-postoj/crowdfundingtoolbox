<?php

namespace App\Http\Controllers\BackOfficeAPI;

use App\BackOfficeAPI\CampaignsConfiguration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CampaignsConfigurationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/backoffice/crowdfunding-settings/all",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Get general settings.",
     *     operationId="crowdFundingSettings",
     *     @OA\Response(
     *         response=200,
     *         description="Successfull!",
     *
     * )
     * )
     */
    protected function get()
    {
        return CampaignsConfiguration::all();
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/crowdfunding-settings/colors",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Get default colors.",
     *     operationId="crowdFundingSettingsColors",
     *     @OA\Response(
     *         response=200,
     *         description="Successfull!",
     *
     * )
     * )
     */
    protected function getColors()
    {
        return response()->json([
            'colors' => CampaignsConfiguration::where('id', 1)->get()[0]['colors']
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/crowdfunding-settings/fonts",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Get default fonts.",
     *     operationId="crowdFundingSettingsColors",
     *     @OA\Response(
     *         response=200,
     *         description="Successfull!",
     *
     * )
     * )
     */
    protected function getFonts()
    {
        return response()->json([
            'fonts' => json_decode(CampaignsConfiguration::where('id', 1)->get()[0]['fonts'])
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/crowdfunding-settings/general-page-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Get general page settings.",
     *     operationId="crowdFundingSettingsGetGeneralPageSettings",
     *     @OA\Response(
     *         response=200,
     *         description="Successfull!",
     *
     * )
     * )
     */
    protected function getGeneralPageSettings()
    {
        $config = CampaignsConfiguration::where('id', 1)->get()[0];
        return \response()->json([
            'fonts' => json_decode($config['fonts'], true),
            'colors'    =>  json_decode($config['colors'], true),
            'font_settings_headline_text'   =>  json_decode($config['font_settings_headline_text'], true),
            'font_settings_additional_text' =>  json_decode($config['font_settings_additional_text'], true)
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/crowdfunding-settings/general-page-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Get general page settings.",
     *     operationId="crowdFundingSettingsGetGeneralPageSettings",
     *     @OA\Response(
     *         response=200,
     *         description="Successfull!",
     *
     * )
     * )
     */
    protected function getCtaSettings()
    {
        $config = json_decode(CampaignsConfiguration::where('id', 1)->get()[0]['cta'], true);
        return \response()->json([
            'default'   =>  $config['default'],
            'hover' =>  $config['hover']
        ], Response::HTTP_OK);
    }


    /**
     * @OA\Get(
     *     path="/api/backoffice/crowdfunding-settings/widgets-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Get widgets settings.",
     *     operationId="crowdFundingSettingsWidgetsSettings",
     *     @OA\Response(
     *         response=200,
     *         description="Successfull!",
     *
     * )
     * )
     */
    protected function getWidgetSettings()
    {
        $config = CampaignsConfiguration::where('id', 1)->get()[0];
        return \response()->json([
            'general'   =>  json_decode($config['widget_settings'], true)
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/api/backoffice/crowdfunding-settings/general-page-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Update General page settings",
     *     description="Only for authenticated users.",
     *     operationId="updateGeneralPageSettings",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated settings!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="fonts", type="json"
     *           ),
     *          @OA\Property(
     *              property="colors", type="json"
     *           ),
     *     @OA\Property(
     *              property="font_settings_title", type="json"
     *           ),
     *     @OA\Property(
     *              property="font_settings_additional_text", type="json"
     *           ),
     *          example={
     *              "fonts": "['Roboto', 'Roboto Slab']",
     *     "colors":"['#000000', '#FFFFFF']",
     *     "font_settings_title":{"fontFamily":"Roboto", "fontWeight":"bold", "color": "#FFFFFF", "backgroundColor": "rgba(0,0,0,0}", "fontSize": 24},
     *     "font_settings_additional_text": {"fontFamily":"Roboto Slab", "fontWeight":"light", "color": "#FFFFFF", "backgroundColor": "rgba(0,0,0,0}", "fontSize": 20}}
     *
     *       ),
     *
     * )
     * )
     */
    protected function updateGeneralPageSettings(Request $request)
    {
        try {
            $valid = validator($request->only('colors', 'fonts', 'font_settings_headline_text', 'font_settings_additional_text'), [
                'colors' => 'required|array',
                'fonts' => 'required|array',
                'font_settings_headline_text' => 'required|array',
                'font_settings_additional_text' => 'required|array'
            ]);

            if ($valid->fails()) {
                $jsonError = response()->json([
                    'error' => $valid->errors()
                ], Response::HTTP_BAD_REQUEST);
                return $jsonError;
            }


            CampaignsConfiguration::where('id', 1)->update([
                'fonts' => json_encode($request['fonts']),
                'colors' => json_encode($request['colors']),
                'font_settings_headline_text' => json_encode($request['font_settings_headline_text']),
                'font_settings_additional_text' => json_encode($request['font_settings_additional_text'])
            ]);

            return \response([
                'message' => 'Successfully updated General Page Settings.'
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/backoffice/crowdfunding-settings/cta-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Update CTA settings",
     *     description="Only for authenticated users.",
     *     operationId="updateCTASettings",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated settings!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="default", type="json"
     *           ),
     *          @OA\Property(
     *              property="hover", type="json"
     *           ),
     *          example={
     *              "default": {
     * "padding": "0 auto 0 auto",
     * "margin": "0 auto 0 auto",
     * "fontSettings": {
     * "fontFamily": "Roboto Slab",
     * "fontWeight": "bold",
     * "alignment": "center",
     * "color": "#FFFFFF",
     * "fontSize": 24
     * },
     * "design": {
     * "fill": {
     * "selected": true,
     * "color": "#B71100",
     * "opacity": 100
     * },
     * "border": {
     * "selected": false,
     * "color": "#B71100",
     * "size": 2,
     * "opacity": 0
     * },
     * "shadow": {
     * "selected": false,
     * "color": "#B71100",
     * "x": 2,
     * "y": 2,
     * "b": 2,
     * "opacity": 0
     * },
     * "radius": "0"
     * }
     * },
     *
     * "hover": {
     * "type": "fade",
     * "fontSettings": {
     * "fontWeight": "bold",
     * "color": "#FFFFFF"
     * },
     * "design": {
     * "fill": {
     * "selected": true,
     * "color": "#B71100",
     * "opacity": 100
     * },
     * "border": {
     * "selected": false,
     * "color": "#B71100",
     * "size": 2,
     * "opacity": 0
     * },
     * "shadow": {
     * "selected": false,
     * "color": "#B71100",
     * "x": 2,
     * "y": 2,
     * "b": 2,
     * "opacity": 0
     * },
     * "radius": "0"
     * }
     *
     *
     * }
     * }
     *
     *       ),
     *
     * )
     * )
     */
    protected function updateCallToActionSettings(Request $request)
    {
        try {
            $valid = validator($request->only('default', 'hover', 'default.fontSettings', 'default.design'), [
                'default' => 'required|array',
                'hover' => 'required|array',
                'default.fontSettings' => 'required|array',
                'default.design' => 'required|array'
            ]);

            if ($valid->fails()) {
                $jsonError = response()->json([
                    'error' => $valid->errors()
                ], Response::HTTP_BAD_REQUEST);
                return $jsonError;
            }

            $reqObject = array(
              'default' =>  $request['default'],
              'hover'   =>  $request['hover']
            );

            CampaignsConfiguration::where('id', 1)->update([
                'cta' => json_encode($reqObject),
            ]);

            return \response([
                'message' => 'Successfully updated CTA Settings.'
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/backoffice/crowdfunding-settings/widgets-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Update Widgets settings",
     *     description="Only for authenticated users.",
     *     operationId="updateWidgetsSettings",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated settings!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="general", type="json"
     *           ),
     *          @OA\Property(
     *              property="landing", type="json"
     *           ),
     *     @OA\Property(
     *              property="sidebar", type="json"
     *           ),
     *     @OA\Property(
     *              property="leaderboard", type="json"
     *           ),
     *     @OA\Property(
     *              property="popup", type="json"
     *           ),
     *     @OA\Property(
     *              property="fixed", type="json"
     *           ),
     *     @OA\Property(
     *              property="locked", type="json"
     *           ),
     *     @OA\Property(
     *              property="article", type="json"
     *           ),
     *          example={
    "general": {
    "padding": "0 auto 0 auto",
    "margin": "0 auto 0 auto"
    },
    "landing": {
    "position": "relative",
    "display": "block",
    "width": "100%",
    "height": "100%"
    },
    "sidebar": {
    "position": "relative",
    "display": "block",
    "width": "100%",
    "maxWidth": "400px",
    "height": "600px"
    },
    "leaderboard": {
    "position": "relative",
    "display": "block",
    "width": "100%",
    "height": "300px"
    },
    "popup": {
    "position": "absolute",
    "display": "block",
    "maxWidth": "450px",
    "width": "100%",
    "height": "300px"
    },
    "fixed": {
    "position": "fixed",
    "display": "block",
    "width": "100%",
    "height": "80px",
    "position": "bottom"
    },
    "locked": {
    "position": "relative",
    "display": "block"
    },
    "article": {
    "position": "relative",
    "display": "block"
    }
     *     }
     *
     *       ),
     *
     * )
     * )
     */
    protected function updateWidgetSettings(Request $request)
    {
        try {
            $valid = validator($request->only('general', 'landing', 'sidebar', 'leaderboard', 'popup', 'fixed', 'locked', 'article', 'article_link', 'custom'), [
                'general' => 'required|array',
                'landing' => 'required|array',
                'sidebar' => 'required|array',
                'leaderboard' => 'required|array',
                'popup' => 'required|array',
                'fixed' => 'required|array',
                'locked' => 'required|array',
                'article' => 'required|array',
                'article_link' => 'required|array',
                'custom' => 'required|array'
            ]);

            if ($valid->fails()) {
                $jsonError = response()->json([
                    'error' => $valid->errors()
                ], Response::HTTP_BAD_REQUEST);
                return $jsonError;
            }

            CampaignsConfiguration::where('id', 1)->update([
                'widget_settings' => json_encode($request['general']),
                'landing' => json_encode($request['landing']),
                'sidebar' => json_encode($request['sidebar']),
                'leaderboard' => json_encode($request['leaderboard']),
                'popup' => json_encode($request['popup']),
                'fixed' => json_encode($request['fixed']),
                'locked' => json_encode($request['locked']),
                'article' => json_encode($request['article']),
                'article_link' => json_encode($request['article_link']),
                'custom' => json_encode($request['custom'])
            ]);

            return \response([
                'message' => 'Successfully updated Widgets Settings.'
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
