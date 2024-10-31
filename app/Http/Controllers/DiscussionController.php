<?php

namespace App\Http\Controllers;

use App\DataTables\DiscussionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDiscussionRequest;
use App\Http\Requests\UpdateDiscussionRequest;
use App\Repositories\DiscussionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Services\SaveFileService;
use App\User;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DiscussionController extends AppBaseController
{
    /** @var  DiscussionRepository */
    private $discussionRepository;

    private $saveFileService;
    private $users;
    private $status = [
        'draft' => 'Draft',
        'hidden' => 'Hidden',
        'publish' => 'Publish',
        'archive' => 'Archive'
    ];
    private $path = 'discussions';

    public function __construct(DiscussionRepository $discussionRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:discussion-edit', ['only' => ['edit']]);
        $this->middleware('can:discussion-store', ['only' => ['store']]);
        $this->middleware('can:discussion-show', ['only' => ['show']]);
        $this->middleware('can:discussion-update', ['only' => ['update']]);
        $this->middleware('can:discussion-delete', ['only' => ['delete']]);
        $this->middleware('can:discussion-create', ['only' => ['create']]);
        $this->discussionRepository = $discussionRepo;
        $this->saveFileService = new SaveFileService();
        $this->users = User::role('Moderator')->pluck('name','id')->prepend('','');
    }

    /**
     * Display a listing of the Discussion.
     *
     * @param DiscussionDataTable $discussionDataTable
     * @return Response
     */
    public function index(DiscussionDataTable $discussionDataTable)
    {
        return $discussionDataTable->render('discussions.index');
    }

    /**
     * Show the form for creating a new Discussion.
     *
     * @return Response
     */
    public function create()
    {
        return view('discussions.create')
            ->with('users', $this->users)
            ->with('status', $this->status);
    }

    /**
     * Store a newly created Discussion in storage.
     *
     * @param CreateDiscussionRequest $request
     *
     * @return Response
     */
    public function store(CreateDiscussionRequest $request)
    {
        $input = $request->all();

        $input['image'] = $this->saveFileService->setImage(@$request->image)->setStorage($this->path)->handle();
        $discussion = $this->discussionRepository->create($input);

        Flash::success('Discussion saved successfully.');
        return redirect(route('discussions.index'));
    }

    /**
     * Display the specified Discussion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $discussion = $this->discussionRepository->findWithoutFail($id);

        if (empty($discussion)) {
            Flash::error('Discussion not found');
            return redirect(route('discussions.index'));
        }

        return view('discussions.show')->with('discussion', $discussion);
    }

    /**
     * Show the form for editing the specified Discussion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $discussion = $this->discussionRepository->findWithoutFail($id);

        if (empty($discussion)) {
            Flash::error('Discussion not found');
            return redirect(route('discussions.index'));
        }

        return view('discussions.edit')
            ->with('users', $this->users)
            ->with('discussion', $discussion)
            ->with('status', $this->status);
    }

    /**
     * Update the specified Discussion in storage.
     *
     * @param  int              $id
     * @param UpdateDiscussionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDiscussionRequest $request)
    {
        $discussion = $this->discussionRepository->findWithoutFail($id);

        if (empty($discussion)) {
            Flash::error('Discussion not found');
            return redirect(route('discussions.index'));
        }

        $input = $request->all();
        $input['image'] = $this->saveFileService->setImage(@$request->image)->setModel($discussion->image)->setStorage($this->path)->handle();
        $discussion = $this->discussionRepository->update($input, $id);

        Flash::success('Discussion updated successfully.');
        return redirect(route('discussions.index'));
    }

    /**
     * Remove the specified Discussion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $discussion = $this->discussionRepository->findWithoutFail($id);

        if (empty($discussion)) {
            Flash::error('Discussion not found');
            return redirect(route('discussions.index'));
        }

        $this->discussionRepository->delete($id);

        Flash::success('Discussion deleted successfully.');
        return redirect(route('discussions.index'));
    }

    /**
     * Store data Discussion from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $discussion = $this->discussionRepository->create($item->toArray());
            });
        });

        Flash::success('Discussion saved successfully.');
        return redirect(route('discussions.index'));
    }
}
