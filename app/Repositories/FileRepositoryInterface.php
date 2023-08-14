<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

interface FileRepositoryInterface
{
    /**
     * Store a newly created file in storage.
     */
    public function storeFile(UploadedFile $file, int $user_id): File;

    /**
     * Update the specified file in storage.
     */
    public function update(int $id, array $data): File;

    /**
     * Delete the specified file from storage.
     */
    public function deleteFile(int $id): bool;

    /**
     * Get all files associated with a user.
     */
    public function index(User $user): LengthAwarePaginator;

    /**
     * Get all file details.
     */
    public function find(int $id): ?File;
}
