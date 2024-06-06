<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warranty;
use App\Models\Service;

class WarrantyController extends Controller
{
    public function index()
    {
        $warranties = Warranty::with('service')->orderBy('no_garansi', 'desc')->get();
        return view('warranties.index', compact('warranties'));
    }

    public function create()
    {
        $services = Service::all();
        return view('warranties.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_garansi' => 'required|unique:warranties,no_garansi',
            'id_service' => 'required|exists:services,id_service',
            'start_date' => 'required|date',
        ]);

        $service = Service::findOrFail($request->id_service);
        $warranty_duration = $service->warranty_range;

        $end_date = date('Y-m-d', strtotime($request->start_date . " + $warranty_duration years"));

        Warranty::create([
            'no_garansi' => $request->no_garansi,
            'id_service' => $request->id_service,
            'start_date' => $request->start_date,
            'warranty_duration' => $warranty_duration,
            'end_date' => $end_date
        ]);

        return redirect()->route('warranties.index')->with('success', 'Warranty added successfully.');
    }

    public function edit($id)
    {
        $warranty = Warranty::findOrFail($id);
        $services = Service::all();
        return view('warranties.edit', compact('warranty', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_service' => 'required|exists:services,id_service',
            'start_date' => 'required|date',
        ]);

        $warranty = Warranty::findOrFail($id);
        $service = Service::findOrFail($request->id_service);
        $warranty_duration = $service->warranty_range;

        $end_date = date('Y-m-d', strtotime($request->start_date . " + $warranty_duration years"));

        $warranty->update([
            'id_service' => $request->id_service,
            'start_date' => $request->start_date,
            'warranty_duration' => $warranty_duration,
            'end_date' => $end_date
        ]);

        return redirect()->route('warranties.index')->with('success', 'Warranty updated successfully.');
    }

    public function destroy($id)
    {
        $warranty = Warranty::findOrFail($id);
        $warranty->delete();

        return redirect()->route('warranties.index')->with('success', 'Warranty deleted successfully.');
    }
}
