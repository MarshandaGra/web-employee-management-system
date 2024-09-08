<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function reset_code(Company $company): mixed
    {
        $company->update([
            'company_code' => Company::company_generate()
        ]);

        return redirect()->route('applicants.index')->with('success', 'berhasil mereset kode rekrut!');
    }

    public function reset_invite(Company $company): mixed
    {
        $company->update([
            'company_invite' => Company::company_generate()
        ]);

        return redirect()->route('invited.index')->with('success', 'berhasil mereset kode undangan!');
    }
}
