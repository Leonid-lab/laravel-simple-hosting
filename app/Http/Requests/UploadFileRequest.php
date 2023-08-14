<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UploadFileRequest extends FormRequest
{
    // Максимальный размер файла в мб
    public const MAX_FILE_SIZE_MB = 100;

    /**
     * Определяет, имеет ли пользователь право на этот запрос.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Определяет правила валидации для запроса.
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpeg,png,pdf,html|max:'.(self::MAX_FILE_SIZE_MB * 1024),
        ];
    }

    /**
     * Обработка неудачной валидации.
     *
     * @throws BindingResolutionException|HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Произошла ошибка',
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
