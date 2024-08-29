<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\KanbanBoard;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // display a list of user project
    public function my_project()
    {
        $kanbanboard = KanbanBoard::with(['project', 'kanbantasks'])->get();
        return view('myproject.index', compact('kanbanboard'));
    }

    // Mark a project as completed
    public function mark_completed($id)
    {
        $project = Project::findOrFail($id);

        Project::where('id', $id)->update([
            'status' => 'Completed',
            'completed_at' => Carbon::now(),
            'name' => $project->name, // Pastikan 'name' diambil dari proyek yang ada
        ]);

        return redirect()->route('projects.index')->with('success', 'Proyek telah berhasil diselesaikan.');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Project::query();

        // Pencarian
        $search = $request->input('search');
        if ($search) {
            $query->search($search);
        }

        // Filter Status
        $statuses = $request->input('status');
        if ($statuses) {
            $query->whereIn('status', $statuses);
        }

        // Validasi Sort Direction
        $request->validate([
            'sortDirection' => 'in:asc,desc',
        ]);

        // Sorting
        $sortBy = $request->input('sortBy', 'id'); // Default sort by 'id'
        $sortDirection = $request->input('sortDirection', 'asc'); // Default sort direction 'asc'

        // Dapatkan hasil query dengan pagination
        $projects = $query->orderBy($sortBy, $sortDirection)->paginate(10);
        $projects->appends($request->all());

        return view('projects.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());
        KanbanBoard::create([
            'name' => $project->name,
            'project_id' => $project->id
        ]);
        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Data berhasil dihapus');
    }
}
