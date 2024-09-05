<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SalaryRequest;
use App\Models\EmployeeDetail;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Salary::with('employee_detail');
        $employees = EmployeeDetail::where('company_id', Auth::user()->company->id)->get();


        if ($request->has('search')) {
            $query->whereHas('employee_detail', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
                ->orWhere('amount', 'like', '%' . $request->search . '%')
                ->orWhere('payment_date', 'like', '%' . $request->search . '%');
        }


        if ($request->has('sortBy') && $request->has('sortDirection')) {
            $query->orderBy($request->sortBy, $request->sortDirection);
        }

        $salaries = $query->paginate(10);

        $salaries->appends($request->all());

        return view('salaries.index', compact('salaries', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['company_id'] = Auth::user()->company->id;

        Salary::create($validatedData);

        return redirect()->route('salaries.index')->with('success', 'Gaji berhasil dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryRequest $request, $id)
    {
        $salarie = Salary::findOrFail($id);
        $salarie->update($request->validated());

        return redirect()->route('salaries.index')->with('success', 'Gaji berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salarie)
    {
        $salarie->delete();
        return redirect()->route('salaries.index')->with('danger', 'Data gaji berhasil dihapus');
    }
}
