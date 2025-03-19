<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Translation\FileTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;
use Aws\S3\S3Client;

class FileController extends Controller
{

    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->get('ajax')['new'];
    
        $data['accessibility'] = 'free';
        $data['storage'] = 's3';
    
        $rules = [
            'webinar_id' => 'required',
            'chapter_id' => 'required',
            'title' => 'required|max:255',
            'accessibility' => 'required',
            'description' => 'nullable',
        ];
    
        $validator = Validator::make($data, $rules);
    
        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $video = $request->file('ajax.new.file_path');
        $filename = $video->getClientOriginalName();
        $s3 = Storage::disk('s3');
        $path = $s3->putFileAs('videos', $video, $filename, 'public', [
            'multipart' => true
        ]);
        $url = 'https://videos-abajim-1.s3.de.io.cloud.ovh.net/videos/' . $filename;
    
        $webinar = Webinar::find($data['webinar_id']);
    
        if (!empty($webinar) && $webinar->canAccess($user)) {
            $data['file_type'] = 'video';
            $data['file_path'] = $url;
            $data['volume'] = $video->getSize();
    
      
        $webinar = Webinar::find($data['webinar_id']);
        if(!empty($webinar) && $webinar->status === Webinar::$active) {
                $data['status'] = File::$Inactive;
        }else{
            $data['status'] = File::$Active;
        }
            
            $file = File::create([
                'creator_id' => $user->id,
                'webinar_id' => $data['webinar_id'],
                'chapter_id' => $data['chapter_id'],
                'file' => $url,
                'status' => $data['status'],
                'file_type' => $data['file_type'],
                'accessibility' => $data['accessibility'],
                'storage' => $data['storage'],
                'online_viewer' => (!empty($data['online_viewer']) && $data['online_viewer'] == 'on'),
                'downloadable' => false,
                'created_at' => time(),
                'volume' => $data['volume'],
            ]);
    
            if (!empty($file)) {
                FileTranslation::updateOrCreate([
                    'file_id' => $file->id,
                    'locale' => mb_strtolower($data['locale']),
                ], [
                    'title' => $data['title'],
                ]);
    
                WebinarChapterItem::makeItem($user->id, $file->chapter_id, $file->id, WebinarChapterItem::$chapterFile);
            }
    
            return response()->json([
                'code' => 200,
            ], 200);
        }
    
        abort(403);
    }
    

    private function handleUnZipFile($data)
    {
        $path = $data['file_path'];
        $interactiveType = $data['interactive_type'] ?? null;
        $interactiveFileName = $data['interactive_file_name'] ?? null;

        $storage = Storage::disk('public');
        $user = auth()->user();

        $fileInfo = $this->fileInfo($path);

        $extractPath = $user->id . '/' . $fileInfo['name'];
        $storageExtractPath = $storage->url($extractPath);

        if (!$storage->exists($extractPath)) {
            $storage->makeDirectory($extractPath);

            $filePath = public_path($path);

            $zip = new \ZipArchive();
            $res = $zip->open($filePath);

            if ($res) {
                $zip->extractTo(public_path($storageExtractPath));

                $zip->close();
            }
        }

        $fileName = 'index.html';

        if ($interactiveType == 'i_spring') {
            $fileName = 'story.html';
        } elseif ($interactiveType == 'custom') {
            $fileName = $interactiveFileName;
        }

        return $storageExtractPath . '/' . $fileName;
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $data = $request->get('ajax')[$id];
    
        $data['accessibility'] = 'free';
        $data['storage'] = 's3';
    
        $rules = [
            'webinar_id' => 'required',
            'chapter_id' => 'required',
            'title' => 'required|max:255',
            'accessibility' => 'required',
            'description' => 'nullable',
        ];
    
        $validator = Validator::make($data, $rules);
    
        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        if ($request->hasFile('ajax.' . $id . '.file_path')) {
            $video = $request->file('ajax.' . $id . '.file_path');
            $filename = $video->getClientOriginalName();
            $path = Storage::disk('s3')->putFileAs('videos', $video, $filename, 'public');
            $url = 'https://videos-abajim-1.s3.de.io.cloud.ovh.net/videos/' . $filename;
            $data['volume'] = $video->getSize();
            $data['file_type'] = 'video';
        }
    
        $file = File::where('id', $id)
            ->where('creator_id', $user->id)
            ->first();
        $webinar = Webinar::find($data['webinar_id']);
        
        if (!empty($webinar) && $webinar->status === Webinar::$active) {
                $data['status'] = File::$Inactive;
        } else {
            $data['status'] = File::$Active;
        }
    
        if (!empty($file)) {
            $file->update([
                'file' => $url ?? $file->file,
                'volume' => $data['volume'] ?? $file->volume,
                'file_type' => $data['file_type'] ?? $file->file_type,
                'accessibility' => $data['accessibility'],
                'storage' => $data['storage'],
                'online_viewer' => !empty($data['online_viewer']) && $data['online_viewer'] == 'on',
                'downloadable' => false,
                'status' => $data['status'],
                'updated_at' => time()
            ]);
    
            FileTranslation::updateOrCreate([
                'file_id' => $file->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
            ]);
    
            return response()->json([
                'code' => 200,
            ], 200);
        }
    
        abort(403);
    }
    
    public function fileInfo($path)
    {
        $file = array();

        $file_path = public_path($path);

        $filePath = pathinfo($file_path);

        $file['name'] = $filePath['filename'];
        $file['extension'] = $filePath['extension'];
        $file['size'] = filesize($file_path);

        return $file;
    }

    private function uploadFileToS3($file)
    {
        $user = auth()->user();

        $path = 'store/' . $user->id;

        $result = [
            'path' => null,
            'status' => true
        ];

        try {
            $fileName = time() . $file->getClientOriginalName();

            $storage = Storage::disk('minio');

            if (!$storage->exists($path)) {
                $storage->makeDirectory($path);
            }

            $path = $storage->put($path, $file, $fileName);
            $result['path'] = $storage->url($path);
        } catch (\Exception $ex) {

            $result = [
                'path' => response([
                    'code' => 500,
                    'message' => $ex->getMessage(),
                    'traces' => $ex->getTrace(),
                ], 500),
                'status' => false
            ];
        }

        return $result;
    }

    public function destroy(Request $request, $id)
    {
        $file = File::where('id', $id)
            ->where('creator_id', auth()->id())
            ->first();

        if (!empty($file)) {
            WebinarChapterItem::where('user_id', $file->creator_id)
                ->where('item_id', $file->id)
                ->where('type', WebinarChapterItem::$chapterFile)
                ->delete();

            $file->delete();
        }

        return response()->json([
            'code' => 200
        ], 200);
    }
}
