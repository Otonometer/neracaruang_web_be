<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Models\EBook;
use Illuminate\Http\Request;
use App\Services\SaveFileService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\DataTables\EBookDataTable;
use App\Http\Controllers\AppBaseController;
use App\Repositories\EBookRepository;
use App\Http\Requests\UpdateSocialMediaRequest;
use App\Http\Requests\CreateEBookRequest;
use App\Http\Requests\UpdateEBookRequest;

class EBookController extends AppBaseController
{
    /** @var  EBookRepository */
    private $ebookRepository;

    private $saveFileService;
    private $path_image = 'ebook/image';
    private $path_file = 'ebook/file';

    public function __construct(EBookRepository $ebookRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:ebook-store', ['only' => ['store']]);
        $this->middleware('can:ebook-show', ['only' => ['show']]);;
        $this->middleware('can:ebook-create', ['only' => ['create']]);
        $this->middleware('can:ebook-edit', ['only' => ['edit']]);
        $this->middleware('can:ebook-update', ['only' => ['update']]);
        $this->middleware('can:ebook-delete', ['only' => ['delete']]);
        $this->ebookRepository = $ebookRepo;
        $this->saveFileService = new SaveFileService();
    }

    /**
     * Display a listing of the EBook.
     *
     * @param EBookDataTable $ebookDataTable
     * @return Response
     */
    public function index(EBookDataTable $ebookDataTable)
    {
        return $ebookDataTable->render('ebooks.index');
    }

    /**
     * Show the form for creating a new EBook.
     *
     * @return Response
     */
    public function create()
    {
        return view('ebooks.create');
    }

    /**
     * Store a newly created EBook in storage.
     *
     * @param CreateEBookRequest $request
     *
     * @return Response
     */
    public function store(CreateEBookRequest $request)
    {
        $input = $request->all();

        $input['image_uri'] = $this->saveFileService->setImage(@$request->image_uri)->setStorage($this->path_image)->handle();
        $input['download_uri'] = $this->saveFileService->setImage(@$request->download_uri)->setStorage($this->path_file)->handle();

        $ebook = $this->ebookRepository->create($input);

        Flash::success('EBook saved successfully.');
        return redirect(route('ebook.index'));
    }

    /**
     * Display the specified EBook.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ebook = $this->ebookRepository->findWithoutFail($id);

        if (empty($ebook)) {
            Flash::error('EBook not found');
            return redirect(route('ebook.index'));
        }

        return view('ebooks.show')->with('ebook', $ebook);
    }

    /**
     * Show the form for editing the specified SocialMedia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ebook = $this->ebookRepository->findWithoutFail($id);

        if (empty($ebook)) {
            Flash::error('EBook not found');
            return redirect(route('ebooks.index'));
        }

        return view('ebooks.edit')
            ->with('ebook', $ebook);
    }

    /**
     * Update the specified EBook in storage.
     *
     * @param  int              $id
     * @param UpdateEBookRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEBookRequest $request)
    {
        $ebook = $this->ebookRepository->findWithoutFail($id);

        if (empty($ebook)) {
            Flash::error('EBook not found');
            return redirect(route('ebook.index'));
        }

        $input = $request->all();
        $input['image_uri'] = $this->saveFileService->setImage(@$request->image)->setModel($ebook->image_uri)->setStorage($this->path_image)->handle();
        $input['download_uri'] = $this->saveFileService->setImage(@$request->download)->setModel($ebook->download_uri)->setStorage($this->path_image)->handle();
        $ebook = $this->ebookRepository->update($input, $id);

        Flash::success('EBook updated successfully.');
        return redirect(route('ebook.index'));
    }

    /**
     * Remove the specified EBook from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ebook = $this->ebookRepository->findWithoutFail($id);

        if (empty($ebook)) {
            Flash::error('EBook not found');
            return redirect(route('ebooks.index'));
        }

        if ($ebook->is_active == 1) {
            Flash::error('EBook must be inactive before deleting');
            return redirect(route('ebook.index'));
        }

        $this->ebookRepository->delete($id);

        Flash::success('EBook deleted successfully.');
        return redirect(route('ebook.index'));
    }

    /**
     * Store data SocialMedia from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $ebook = $this->ebookRepository->create($item->toArray());
            });
        });

        Flash::success('EBook saved successfully.');
        return redirect(route('ebook.index'));
    }
}
