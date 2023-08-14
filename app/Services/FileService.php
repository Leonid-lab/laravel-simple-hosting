<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use App\Repositories\FileRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class FileService
{
    protected FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * Store a newly created file in storage.
     */
    public function storeFile(UploadedFile $file, int $user_id): File
    {
        // Вызываем метод репозитория для сохранения файла
        return $this->fileRepository->storeFile($file, $user_id);
    }
    /**
     * Store a newly created file in storage.
     */
    public function getFileById($id): ?File
    {
        return $this->fileRepository->find($id);
    }
    /**
     * Update the specified file in storage.
     */
    public function update(int $id, array $data): File
    {
        // Вызываем метод репозитория для обновления файла
        return $this->fileRepository->update($id, $data);
    }

    /**
     * Delete the specified file from storage.
     */
    public function deleteFile(int $id): bool
    {
        // Вызываем метод репозитория для удаления файла
        return $this->fileRepository->deleteFile($id);
    }

    /**
     * Get all files associated with a user.
     *
     * @throws BindingResolutionException
     */
    public function index(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->files()->paginate($perPage);
    }
}
