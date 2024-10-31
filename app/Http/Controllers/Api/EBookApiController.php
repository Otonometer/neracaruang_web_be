<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\EBookRequest;
use App\Http\Controllers\Controller;
use App\Repositories\EBookRepository;

class EBookApiController extends Controller
{
    public function __construct
    (
        private EBookRepository $ebookRepository,
    )
    {
    }
    public function getEbooks(EBookRequest $request){
        try {
            $params = $request->validated();

            $slug = $params['slug'] ?? null;
            if ($slug) {
                $ebook = $this->ebookRepository->where('slug', $slug)->where('is_active', 1)->first();

                if (!$ebook) {
                    return $this->sendError('Ebook not found.', 404);
                }

                $ebook->makeHidden(['id', 'is_active']);
                $ebook->increment('view_count');

                return $this->sendSuccess($ebook);
            }

            $ebooks = $this->ebookRepository->where('is_active', 1);

            $sort_popular = $params['sort_popular'] ?? null;
            if ($sort_popular == true) {
                $ebooks = $ebooks->orderBy('download_count', 'desc');
            }

            $ebooks = $ebooks->get()->makeHidden(['id', 'is_active']);

            return $this->sendResponse($ebooks,'Success get data.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function downloadEbook($slug){
        try {
            $ebook = $this->ebookRepository->where('slug', $slug)->where('is_active', 1)->first();

            if (!$ebook) {
                return $this->sendError('Ebook not found.', 404);
            }

            $ebook->increment('download_count');
            if(!file_exists(public_path('storage/ebooks/'.$ebook->file))){
                return $this->sendError('Ebook file not found.', 404);
            }

            return response()->download(public_path('storage/ebooks/'.$ebook->file));
        } catch (\Throwable $th) {
            return $this->sendError('Failed to download ebook.',500);
        }
    }
}
