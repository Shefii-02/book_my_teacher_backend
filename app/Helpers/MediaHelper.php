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
    public static function removeCompanyFile(int $fileId): bool
    {

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


}
