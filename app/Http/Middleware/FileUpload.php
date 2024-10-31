<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FileUpload
{

    private function isDocumentOrImage(string $ext): string
    {
        if ($ext === "png" || $ext === "gif" || $ext === "psd" || $ext === "tiff" || $ext === "jpg" || $ext === "jpeg") {
            return "image";
        } else if ($ext === "docx" || $ext === "doc" || $ext === "pdf" || $ext === "ppt" || $ext === "xlsx" || $ext === "xls") {
            return "document";
        }
    }

    private function isValidExtDocument(string $ext): bool
    {
        if ($ext === "docx" || $ext === "doc" || $ext === "pdf" || $ext === "ppt" || $ext === "xlsx" || $ext === "xls") {
            return true;
        }

        return false;
    }

    private function isValidExtImage(string $ext): bool
    {
        if ($ext === "png" || $ext === "gif" || $ext === "psd" || $ext === "tiff" || $ext === "jpg" || $ext === "jpeg") {
            return true;
        }
        return false;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $name is a name input from request name
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ... $name)
    {
        // validation request
        if (!$request->hasAny($name)) {
            return false;
        }

        $input = $request->only($name);

        foreach ($input as $key => $value) {
            $isDocumentOrImage = $this->isDocumentOrImage($value);
            $file = $request->file($key);

            // if the file has been uploaded with HTTP and no error occurre
            if (!$file->isValid()) {
                return false;
            }

            if ($isDocumentOrImage === "document")
            {
                if (!$this->isValidExtDocument($file->extension())) {
                    return false;
                }
            } else if ($isDocumentOrImage === "image") {
                if (!$this->isValidExtImage($file->extension())) {
                    return false;
                }
            }
        }

        return $next($request);
    }
}
