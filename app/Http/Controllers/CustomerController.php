<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('customer_id', 'desc')->get();
        $total = Customer::count();
        return view('customers.index', compact(['customers', 'total']));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'customer_name' => 'required',
            'customer_phone_number' => 'required|unique:customers,customer_phone_number',
        ]);

        $customer = Customer::create($validation);

        if ($customer) {
            session()->flash('success', 'Customer added successfully.');
            return redirect(route('customers.index'));
        } else {
            session()->flash('error', 'There was a problem adding the customer.');
            return redirect(route('customers.create'));
        }
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validation = $request->validate([
            'customer_name' => 'required',
            'customer_phone_number' => 'required|unique:customers,customer_phone_number,' . $id . ',customer_id',
        ]);

        $customer->update($validation);

        if ($customer) {
            session()->flash('success', 'Customer updated successfully.');
            return redirect(route('customers.index'));
        } else {
            session()->flash('error', 'There was a problem updating the customer.');
            return redirect(route('customers.edit', $id));
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        if ($customer) {
            session()->flash('success', 'Customer deleted successfully.');
            return redirect(route('customers.index'));
        } else {
            session()->flash('error', 'There was a problem deleting the customer.');
            return redirect(route('customers.index'));
        }
    }
}
