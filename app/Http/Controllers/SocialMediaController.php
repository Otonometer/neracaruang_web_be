<?php

namespace App\Http\Controllers;

use App\DataTables\SocialMediaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSocialMediaRequest;
use App\Http\Requests\UpdateSocialMediaRequest;
use App\Repositories\SocialMediaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Services\SaveFileService;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SocialMediaController extends AppBaseController
{
    /** @var  SocialMediaRepository */
    private $socialMediaRepository;

    private $saveFileService;
    private $path = 'social_media';

    public function __construct(SocialMediaRepository $socialMediaRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:socialMedia-edit', ['only' => ['edit']]);
        $this->middleware('can:socialMedia-store', ['only' => ['store']]);
        $this->middleware('can:socialMedia-show', ['only' => ['show']]);
        $this->middleware('can:socialMedia-update', ['only' => ['update']]);
        $this->middleware('can:socialMedia-delete', ['only' => ['delete']]);
        $this->middleware('can:socialMedia-create', ['only' => ['create']]);
        $this->socialMediaRepository = $socialMediaRepo;
        $this->saveFileService = new SaveFileService();
    }

    /**
     * Display a listing of the SocialMedia.
     *
     * @param SocialMediaDataTable $socialMediaDataTable
     * @return Response
     */
    public function index(SocialMediaDataTable $socialMediaDataTable)
    {
        return $socialMediaDataTable->render('social_media.index');
    }

    /**
     * Show the form for creating a new SocialMedia.
     *
     * @return Response
     */
    public function create()
    {


        return view('social_media.create');
    }

    /**
     * Store a newly created SocialMedia in storage.
     *
     * @param CreateSocialMediaRequest $request
     *
     * @return Response
     */
    public function store(CreateSocialMediaRequest $request)
    {
        $input = $request->all();

        $input['image'] = $this->saveFileService->setImage(@$request->image)->setStorage($this->path)->handle();
        $input['image_green'] = $this->saveFileService->setImage(@$request->image_green)->setStorage($this->path)->handle();

        $socialMedia = $this->socialMediaRepository->create($input);

        Flash::success('Social Media saved successfully.');
        return redirect(route('socialMedia.index'));
    }

    /**
     * Display the specified SocialMedia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $socialMedia = $this->socialMediaRepository->findWithoutFail($id);

        if (empty($socialMedia)) {
            Flash::error('Social Media not found');
            return redirect(route('socialMedia.index'));
        }

        return view('social_media.show')->with('socialMedia', $socialMedia);
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
        $socialMedia = $this->socialMediaRepository->findWithoutFail($id);

        if (empty($socialMedia)) {
            Flash::error('Social Media not found');
            return redirect(route('socialMedia.index'));
        }

        return view('social_media.edit')
            ->with('socialMedia', $socialMedia);
    }

    /**
     * Update the specified SocialMedia in storage.
     *
     * @param  int              $id
     * @param UpdateSocialMediaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSocialMediaRequest $request)
    {
        $socialMedia = $this->socialMediaRepository->findWithoutFail($id);

        if (empty($socialMedia)) {
            Flash::error('Social Media not found');
            return redirect(route('socialMedia.index'));
        }

        $input = $request->all();
        $input['image'] = $this->saveFileService->setImage(@$request->image)->setModel($socialMedia->image)->setStorage($this->path)->handle();
        $input['image_green'] = $this->saveFileService->setImage(@$request->image_green)->setModel($socialMedia->image_green)->setStorage($this->path)->handle();
        $socialMedia = $this->socialMediaRepository->update($input, $id);

        Flash::success('Social Media updated successfully.');
        return redirect(route('socialMedia.index'));
    }

    /**
     * Remove the specified SocialMedia from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $socialMedia = $this->socialMediaRepository->findWithoutFail($id);

        if (empty($socialMedia)) {
            Flash::error('Social Media not found');
            return redirect(route('socialMedia.index'));
        }

        $this->socialMediaRepository->delete($id);

        Flash::success('Social Media deleted successfully.');
        return redirect(route('socialMedia.index'));
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
                $socialMedia = $this->socialMediaRepository->create($item->toArray());
            });
        });

        Flash::success('Social Media saved successfully.');
        return redirect(route('socialMedia.index'));
    }
}
