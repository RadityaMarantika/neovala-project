<?php

namespace App\Http\Controllers;

use App\Models\MasterCustomer;
use Illuminate\Http\Request;

class MasterCustomerController extends Controller
{
    public function index()
    {
        $master_customers = MasterCustomer::all();
        return view('master_customers.index', compact('master_customers'));
    }

    public function create()
    {
        return view('master_customers.create');
    }

    public function store(Request $request)
    {
        MasterCustomer::create($request->all());
        return redirect()->route('master_customers.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(MasterCustomer $masterCustomer)
    {
        return view('master_customers.show', compact('masterCustomer'));
    }

    public function edit(MasterCustomer $masterCustomer)
    {
        return view('master_customers.edit', compact('masterCustomer'));
    }

    public function update(Request $request, MasterCustomer $masterCustomer)
    {
        $masterCustomer->update($request->all());
        return redirect()->route('master_customers.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(MasterCustomer $masterCustomer)
    {
        $masterCustomer->delete();
        return redirect()->route('master_customers.index')->with('success', 'Data berhasil dihapus');
    }
}
