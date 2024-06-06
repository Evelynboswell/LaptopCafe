<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('id_service', 'desc')->get();
        $total = Service::count();
        return view('services.index', compact(['services', 'total']));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required',
            'service_price' => 'required|numeric',
            'warranty_range' => 'required|integer'
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    public function edit($id_service)
    {
        $service = Service::findOrFail($id_service);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id_service)
    {
        $request->validate([
            'service_name' => 'required',
            'service_price' => 'required|numeric',
            'warranty_range' => 'required|integer'
        ]);

        $service = Service::findOrFail($id_service);
        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id_service)
    {
        $service = Service::findOrFail($id_service);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
