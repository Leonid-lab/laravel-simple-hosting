<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Upload a new file.
     *
     * @throws BindingResolutionException
     */
    public function upload(UploadFileRequest $request): RedirectResponse
    {
        // Вызываем метод сервиса для загрузки файла
        $file = $this->fileService->storeFile($request->file('file'), auth()->user()->id);

        return redirect()->back();
        //        return response()->json(['message' => 'File uploaded successfully', 'file' => $file], 201);
    }

    /**
     *
     * Download file.
     *
     * @param int $id
     *
     * @return BinaryFileResponse|RedirectResponse
     * @throws BindingResolutionException
     */
    public function download(int $id): BinaryFileResponse|RedirectResponse
    {
        $file = $this->fileService->getFileById($id);

        if ($file) {
            $filePath = storage_path('app/public/'.$file->path);

            return response()->download($filePath, $file->name);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Update the specified file.
     *
     * @throws BindingResolutionException|ValidationException
     */
    public function update(UpdateFileRequest $request, int $id): RedirectResponse
    {
        // Вызываем метод сервиса для обновления файла
        $file = $this->fileService->update($id, $request->validated());

        return redirect()->back();
        //        return response()->json(['message' => 'File updated successfully', 'file' => $file]);
    }

    /**
     * Delete the specified file.
     *
     * @throws BindingResolutionException
     */
    public function delete(int $id): RedirectResponse
    {
        // Вызываем метод сервиса для удаления файла
        $this->fileService->deleteFile($id);

        return redirect()->back();
        //        return response()->json(['message' => 'File deleted successfully']);
    }

    /**
     * Get all files associated with the authenticated user.
     *
     * @throws BindingResolutionException
     */
    public function list(): View
    {
        $user = auth()->user();

        if ($user) {
            $files = $this->fileService->index($user, 10);

            return view('index', ['files' => $files]);
        }

        return view('index');
    }

    /**
     * @throws BindingResolutionException
     */
    public function show(int $id): View
    {
        $file = $this->fileService->getFileById($id);

        return view('show', ['file' => $file]);
    }
}
