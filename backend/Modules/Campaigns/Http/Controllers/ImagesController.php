<?php

namespace Modules\Campaigns\Http\Controllers;

use App\Http\Services\CrowdfundingHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Campaigns\Entities\Image;

class ImagesController extends Controller
{
    private $imagePath;
    private $helper;

    public function __construct(CrowdfundingHelper $h)
    {
        $this->imagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $this->helper = $h;
    }


    /**
     * @OA\Post(
     *     path="/api/backoffice/upload",
     *     tags={"Image upload"},
     *     summary="Upload image via FormData (for campaigns and widgets)",
     *     description="Only for authenticated users.",
     *     operationId="uploadImage",
     *     @OA\Response(
     *         response=201,
     *         description="After successfully uploding image it returns file url.",
     *     @OA\JsonContent(
     *     type="object",
    @OA\Property(property="image", type="File")
     * )
     *     ),
     *     @OA\MediaType(
     *             mediaType="image"
     * ),
     *     @OA\RequestBody(
     *      description="Upload image via FormData (for campaigns and widgets). On frontend side, please use FormData for upload.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="image", type="File"
     *           ),
     *          example={
     *              "image": "File"}
     *
     *       )
     *
     * )
     * )
     */
    protected function upload(Request $request)
    {
        // TODO - image compression on frontend part
        try {
            if ($request->hasFile('image')) {
                $valid = validator($request->only('image'), [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);
                if ($valid->fails()) {
                    $jsonError = response()->json([
                        'error' => $valid->errors()
                    ], Response::HTTP_BAD_REQUEST);
                    return $jsonError;
                }

                $file = $request->file('image');
                $name = $this->fileName($file->getClientOriginalName());
                $size = (string)$file->getSize();
                $type = (string)$file->getClientMimeType();
                $file->move($this->imagePath, $name);

                return $this->createDBRecord($name, $type, $size);

            } else {
                return \response()->json([
                    'error' => 'File image is required.'
                ], Response::HTTP_BAD_REQUEST);
            }

        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function createDBRecord($fileName, $fileType, $fileSize)
    {
        try {
            $imageCreated = Image::create([
                'path' => $fileName,
                'type' => $fileType,
                'size' => $fileSize
            ]);

            return \response()->json([
                'message' => 'Image was successfully uploaded.',
                'file' => $imageCreated
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    private function fileName($name)
    {
        if (Storage::disk('public')->exists($name)) {
            return $this->fileName($this->helper->getRandomString(5) . '-' . $name);
        }
        return $name;
    }

    protected function uploadWysiwyg(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $valid = validator($request->only('file'), [
                    'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);
                if ($valid->fails()) {
                    $jsonError = response()->json([
                        'error' => $valid->errors()
                    ], Response::HTTP_BAD_REQUEST);
                    return $jsonError;
                }

                $file = $request->file('file');
                $name = $this->fileName($file->getClientOriginalName());
                $size = (string)$file->getSize();
                $type = (string)$file->getClientMimeType();
                $file->move($this->imagePath, $name);

                $responsePath = (strpos($this->imagePath, '/postoj-backend/') !== false) ?
                    env('BACKEND_URL') . explode('/postoj-backend', $this->imagePath)[1] : $this->imagePath;

               return \response()->json([
                    'status' => true,
                   'originalName' => $name,
                   'generatedName' => $name,
                   'msg' => 'Image upload successful',
                   'imageUrl' => $responsePath . $name

               ], Response::HTTP_CREATED);

            } else {
                return \response()->json([
                    'error' => 'File image is required.'
                ], Response::HTTP_BAD_REQUEST);
            }

        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
