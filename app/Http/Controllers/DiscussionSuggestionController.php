<?php

namespace App\Http\Controllers;

use App\DataTables\DiscussionSuggestionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDiscussionSuggestionRequest;
use App\Http\Requests\UpdateDiscussionSuggestionRequest;
use App\Repositories\DiscussionSuggestionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\User;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DiscussionSuggestionController extends AppBaseController
{
    /** @var  DiscussionSuggestionRepository */
    private $discussionSuggestionRepository;

    private $status = [
        'not_processed' => 'Not Processed',
        'processing' => 'Processing',
        'accepted' => 'Accepted',
        'cancel' => 'Cancelled',
    ];
    public function __construct(DiscussionSuggestionRepository $discussionSuggestionRepo)
    {
        $this->middleware('auth');
        $this->middleware('can:discussionSuggestion-edit', ['only' => ['edit']]);
        $this->middleware('can:discussionSuggestion-store', ['only' => ['store']]);
        $this->middleware('can:discussionSuggestion-show', ['only' => ['show']]);
        $this->middleware('can:discussionSuggestion-update', ['only' => ['update']]);
        $this->middleware('can:discussionSuggestion-delete', ['only' => ['delete']]);
        $this->middleware('can:discussionSuggestion-create', ['only' => ['create']]);
        $this->discussionSuggestionRepository = $discussionSuggestionRepo;
    }

    /**
     * Display a listing of the DiscussionSuggestion.
     *
     * @param DiscussionSuggestionDataTable $discussionSuggestionDataTable
     * @return Response
     */
    public function index(DiscussionSuggestionDataTable $discussionSuggestionDataTable)
    {
        return $discussionSuggestionDataTable->render('discussion_suggestions.index');
    }

    /**
     * Show the form for creating a new DiscussionSuggestion.
     *
     * @return Response
     */
    public function create()
    {
        $user = User::pluck('name','id');
        return view('discussion_suggestions.create')
            ->with('user', $user)
            ->with('status', $this->status);
    }

    /**
     * Store a newly created DiscussionSuggestion in storage.
     *
     * @param CreateDiscussionSuggestionRequest $request
     *
     * @return Response
     */
    public function store(CreateDiscussionSuggestionRequest $request)
    {
        $input = $request->all();

        $discussionSuggestion = $this->discussionSuggestionRepository->create($input);

        Flash::success('Discussion Suggestion saved successfully.');
        return redirect(route('discussionSuggestions.index'));
    }

    /**
     * Display the specified DiscussionSuggestion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $discussionSuggestion = $this->discussionSuggestionRepository->findWithoutFail($id);

        if (empty($discussionSuggestion)) {
            Flash::error('Discussion Suggestion not found');
            return redirect(route('discussionSuggestions.index'));
        }

        return view('discussion_suggestions.show')->with('discussionSuggestion', $discussionSuggestion);
    }

    /**
     * Show the form for editing the specified DiscussionSuggestion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $discussionSuggestion = $this->discussionSuggestionRepository->findWithoutFail($id);

        if (empty($discussionSuggestion)) {
            Flash::error('Discussion Suggestion not found');
            return redirect(route('discussionSuggestions.index'));
        }

        $user = $discussionSuggestion->user;
        $thisUser[$user->id] = $user->name;

        return view('discussion_suggestions.edit')
            ->with('user', $thisUser)
            ->with('discussionSuggestion', $discussionSuggestion)
            ->with('status', $this->status);
    }

    /**
     * Update the specified DiscussionSuggestion in storage.
     *
     * @param  int              $id
     * @param UpdateDiscussionSuggestionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDiscussionSuggestionRequest $request)
    {
        $discussionSuggestion = $this->discussionSuggestionRepository->findWithoutFail($id);

        if (empty($discussionSuggestion)) {
            Flash::error('Discussion Suggestion not found');
            return redirect(route('discussionSuggestions.index'));
        }

        $input = $request->all();
        $discussionSuggestion = $this->discussionSuggestionRepository->update($input, $id);

        Flash::success('Discussion Suggestion updated successfully.');
        return redirect(route('discussionSuggestions.index'));
    }

    /**
     * Remove the specified DiscussionSuggestion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $discussionSuggestion = $this->discussionSuggestionRepository->findWithoutFail($id);

        if (empty($discussionSuggestion)) {
            Flash::error('Discussion Suggestion not found');
            return redirect(route('discussionSuggestions.index'));
        }

        $this->discussionSuggestionRepository->delete($id);

        Flash::success('Discussion Suggestion deleted successfully.');
        return redirect(route('discussionSuggestions.index'));
    }

    /**
     * Store data DiscussionSuggestion from an excel file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function import(Request $request)
    {
        Excel::load($request->file('file'), function($reader) {
            $reader->each(function ($item) {
                $discussionSuggestion = $this->discussionSuggestionRepository->create($item->toArray());
            });
        });

        Flash::success('Discussion Suggestion saved successfully.');
        return redirect(route('discussionSuggestions.index'));
    }
}
