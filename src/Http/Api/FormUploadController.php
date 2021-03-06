<?php

namespace Code16\Sharp\Http\Api;

use Code16\Sharp\Utils\FileUtil;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Controller;

class FormUploadController extends Controller
{

    /**
     * @param FileUtil $fileUtil
     * @return \Illuminate\Http\JsonResponse
     * @throws FileNotFoundException
     */
    public function store(FileUtil $fileUtil)
    {
        $file = request()->file('file');

        if (!$file) {
            throw new FileNotFoundException;
        }

        $baseDir = config('sharp.uploads.tmp_dir', 'tmp');

        $filename = $fileUtil->findAvailableName(
            $file->getClientOriginalName(), $baseDir
        );

        $file->storeAs($baseDir, $filename, 'local');

        return response()->json([
            "name" => $filename
        ]);
    }

}