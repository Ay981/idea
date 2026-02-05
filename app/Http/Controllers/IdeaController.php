<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Ideastatus;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ideas = Auth::user()
            ->ideas()
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->get();

        // select status, count(*) from ideas group by status
        $counts = Auth::user()->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $statusCounts = collect(Ideastatus::cases())
            ->mapWithKeys(fn ($status) => [
                $status->value => $counts->get($status->value, 0),
            ])
            ->put('all', Auth::user()->ideas()->count());

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => $statusCounts,
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
    public function store(StoreIdeaRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea): void
    {
        //
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
    public function destroy(Idea $idea): void
    {
        //
    }
}
