<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop;
use App\Models\Customer;

class LaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::orderBy('id_laptop', 'desc')->get();
        $total = Laptop::count();
        return view('laptops.index', compact('laptops', 'total'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('laptops.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'laptop_brand' => 'required',
            'problem_description' => 'required'
        ]);

        Laptop::create($request->all());

        return redirect()->route('laptops.index')->with('success', 'Laptop added successfully.');
    }

    public function edit($id_laptop)
    {
        $laptop = Laptop::findOrFail($id_laptop);
        $customers = Customer::all();
        return view('laptops.edit', compact('laptop', 'customers'));
    }

    public function update(Request $request, $id_laptop)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'laptop_brand' => 'required',
            'problem_description' => 'required'
        ]);

        $laptop = Laptop::findOrFail($id_laptop);
        $laptop->update($request->all());

        return redirect()->route('laptops.index')->with('success', 'Laptop updated successfully.');
    }

    public function destroy($id_laptop)
    {
        $laptop = Laptop::findOrFail($id_laptop);
        $laptop->delete();

        return redirect()->route('laptops.index')->with('success', 'Laptop deleted successfully.');
    }
}
