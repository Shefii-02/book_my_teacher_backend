<?php

namespace App\Helpers;

use App\Models\MediaFolder;
use App\Models\MediaFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MediaHelper
{
    /**
     * Upload file into company folder and record in DB
     */
    public static function uploadCompanyFile(int $companyId, string $folderName, UploadedFile $file, string $file_type, string $userID = null): ?int
    {
        // Ensure company base path
        $basePath = "companies/{$companyId}";
        if (!Storage::disk('public')->exists($basePath)) {
            Storage::disk('public')->makeDirectory($basePath);
        }

        // Ensure folder path
        $folderPath = "{$basePath}/{$folderName}";
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
        }

        // Save file
        $filePath = $file->store($folderPath, 'public');
        $fileName = basename($filePath);

        // Get or create media folder
        $folder = MediaFolder::firstOrCreate([
            'company_id' => $companyId,
            'name' => $folderName,
        ], [
            'path' => $folderPath,
            'slug' => Str::slug($folderName)
        ]);

        // Store in DB
        $mediaFile = MediaFile::create([
            'folder_id' => $folder->id,
            'user_id'   => $userID ? $userID : Auth::id(),
            'company_id' => $companyId,
            'name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $file_type,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return $mediaFile->id;
    }


    /**
     * Remove file from storage and DB
     */
    public static function removeCompanyFile($fileId): bool
    {
      if($$fileId){

        $mediaFile = MediaFile::find($fileId);

        if (!$mediaFile) {
            return false;
        }

        // Delete physical file
        if (Storage::disk('public')->exists($mediaFile->file_path)) {
            Storage::disk('public')->delete($mediaFile->file_path);
        }

        // Remove DB entry
        $mediaFile->delete();

        return true;
      }
      return false;
    }

// $this->updateMedia($user, $company_id, 'avatar', 'avatar', 'avatars');
// $this->updateMedia($user, $company_id, 'cv_file', 'cv', 'cv_files');

//     private function updateMedia($user, $company_id, $requestFile, $fileType, $folder)
// {
//     if ($request->hasFile($requestFile)) {
//         $oldFile = $user->$fileType ? $user->$fileType->file_path : null;
//         if ($oldFile && Storage::disk('public')->exists($oldFile)) {
//             Storage::disk('public')->delete($oldFile);
//         }
//         MediaFile::where('company_id', $company_id)
//             ->where('user_id', $user->id)
//             ->where('file_type', $fileType)
//             ->delete();

//         $file = $request->file($requestFile);
//         $path = $file->storeAs(
//             "uploads/{$folder}",
//             time().'_'.uniqid().'.'.$file->getClientOriginalExtension(),
//             'public'
//         );

//         MediaFile::create([
//             'user_id'    => $user->id,
//             'company_id' => $company_id,
//             'file_type'  => $fileType,
//             'file_path'  => $path,
//             'name'       => $file->getClientOriginalName(),
//             'mime_type'  => $file->getMimeType(),
//         ]);
//     }
// }


}
