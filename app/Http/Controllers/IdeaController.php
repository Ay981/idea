<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Ideastatus;

use App\Models\Idea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->status;

        if (! in_array($status, Ideastatus::values(), true)) {
            $status = null;
        }

        $ideas = $user
            ->ideas()
            ->when(
                $status !== null,
                static fn ($query) => $query->where('status', $status),
            )
            ->latest()
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
{
  $idea= Auth::user()->ideas()->create($request->safe()->except('steps', 'image'));
    $idea->steps()->createMany(
        collect($request->validated('steps', []))
            ->map(fn ($step) => ['description' => $step, 'completed' => false])
            ->all()
    );
    $imagepath = $request->image?->store('ideas', 'public');
    $idea->update(['path_to_image' => $imagepath]);
      
    return redirect()->to('/ideas');

}
    public function show(Idea $idea): View
    {
        if ($idea->user_id !== Auth::id()) {
            abort(404);
        }

        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea): RedirectResponse
    {
        if ($idea->user_id !== Auth::id()) {
            abort(404);
        }

        $idea->delete();

        return redirect()->to('/ideas');
    }
}
