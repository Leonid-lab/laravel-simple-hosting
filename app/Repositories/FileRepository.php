<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;

class FileRepository implements FileRepositoryInterface
{
    /**
     * Store a newly created file in storage.
     *
     * @throws BindingResolutionException
     */
    public function storeFile(UploadedFile $file, int $user_id): File
    {
        // Получаем имя файла и путь для сохранения
        $filename = $file->getClientOriginalName();
        $path = $file->store('uploads', 'public');

        // Создаем новую запись файла в базе данных
        return File::create([
            'name' => $filename,
            'path' => $path,
            'user_id' => $user_id,
        ]);
    }

    /**
     * Update the specified file in storage.
     */
    public function update(int $id, array $data): File
    {
        // Находим файл по ID
        $file = File::findOrFail($id);

        // Обновляем атрибуты файла и сохраняем
        $file->update($data);

        return $file;
    }

    public function find($id): ?File
    {
        return File::find($id);
    }
    /**
     * Delete the specified file from storage.
     */
    public function deleteFile(int $id): bool
    {
        // Находим файл по ID и удаляем
        $file = File::findOrFail($id);

        try {
            Storage::disk('public')->delete($file->path);
        } catch (FilesystemException|\Throwable $e) {
            Log::error('An error '.$e->getMessage().' occurred in file deletion');

            return false;
        }

        return $file->delete();
    }

    /**
     * Get all files associated with a user.
     *
     * @throws BindingResolutionException
     */
    public function index(User $user): LengthAwarePaginator
    {
        // Получаем все файлы, принадлежащие пользователю
        return File::where('user_id', $user->id)->paginate(10);
    }
}
