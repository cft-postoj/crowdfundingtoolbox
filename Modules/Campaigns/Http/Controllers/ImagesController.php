<?php

namespace Modules\Campaigns\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

use App\Http\Services\CrowdfundingHelper;
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
            $image = Image::create([
                'path' => $fileName,
                'type' => $fileType,
                'size' => $fileSize
            ]);
            $image->save();
            $imageUrl =
                (substr(asset('storage/public/uploads/' . $fileName), 0, 21) === 'http://localhost:8000') ?
                    str_replace('http://localhost:8000', 'http://localhost/crowdfundingToolbox', asset('storage/public/uploads/' . $fileName)) :
                    asset('storage/public/uploads/' . $fileName);

            return \response()->json([
                'message' => 'Image was successfully uploaded.',
                'file' => [
                    'id'    =>  $image->id,
                    'url' => $imageUrl
                ]
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

}
