<?php
namespace App\Http\Controllers;

use App\Models\ServiceTransaction;
use App\Models\User;
use App\Models\Customer;
use App\Models\Laptop;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Warranty;
use DateTime;

class ServiceTransactionController extends Controller
{
    public function index()
    {
        $service_transactions = ServiceTransaction::with(['technician', 'customer', 'laptop', 'warranty'])->get();
        return view('service_transactions.index', compact('service_transactions'));
    }

    public function create()
    {
        $technicians = User::all(); // Fetch all users from the users table
        $customers = Customer::with('laptops')->get(); // Fetch customers with their laptops
        $services = Service::all();

        $lastTransaction = ServiceTransaction::orderBy('transaction_id', 'desc')->first();
        $nextTransactionId = $lastTransaction ? $lastTransaction->transaction_id + 1 : 1;
        $nextInvoiceNumber = str_pad($nextTransactionId, 3, '0', STR_PAD_LEFT);

        $lastWarranty = Warranty::orderBy('no_warranty', 'desc')->first();
        $nextWarrantyNumber = $lastWarranty ? str_pad(intval($lastWarranty->no_warranty) + 1, 3, '0', STR_PAD_LEFT) : '001';

        return view('service_transactions.create', compact('technicians', 'customers', 'services', 'nextInvoiceNumber', 'nextWarrantyNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:service_transactions,invoice_number',
            // other validation rules...
        ]);

        // Remove currency formatting from total price
        $totalPrice = preg_replace('/[^0-9]/', '', $request->total_price); // Remove all non-numeric characters

        // Calculate end date based on start date and warranty range
        $warrantyStartDate = $request->warranty_start_date;
        $warrantyEndDate = $request->warranty_end_date;

        // Calculate warranty duration in months
        $startDate = new DateTime($warrantyStartDate);
        $endDate = new DateTime($warrantyEndDate);
        $warrantyDuration = $startDate->diff($endDate)->m + ($startDate->diff($endDate)->y * 12);

        // Create or find the warranty
        $lastWarranty = Warranty::orderBy('no_warranty', 'desc')->first();
        $nextWarrantyNumber = $lastWarranty ? str_pad(intval($lastWarranty->no_warranty) + 1, 3, '0', STR_PAD_LEFT) : '001';

        $warranty = Warranty::firstOrCreate(
            ['no_warranty' => $nextWarrantyNumber],
            [
                'id_service' => $request->service_id[0], // Assuming the first service ID is used for the warranty
                'start_date' => $warrantyStartDate,
                'end_date' => $warrantyEndDate,
                'warranty_duration' => $warrantyDuration
            ]
        );

        // Create the service transaction
        $transaction = new ServiceTransaction($request->except('total_price', 'warranty_id', 'service_id'));
        $transaction->total_price = $totalPrice;
        $transaction->warranty_id = $warranty->no_warranty;
        $transaction->service_ids = json_encode($request->service_id); // Convert the service_ids array to a JSON string
        $transaction->save();

        return redirect()->route('service_transactions.index')->with('success', 'Service transaction created successfully.');
    }

    public function edit($id)
    {
        $serviceTransaction = ServiceTransaction::with(['technician', 'customer', 'laptop', 'warranty'])->findOrFail($id);
        $technicians = User::all(); // Fetch all users from the users table
        $customers = Customer::with('laptops')->get(); // Fetch customers with their laptops
        $services = Service::all();

        return view('service_transactions.edit', compact('serviceTransaction', 'technicians', 'customers', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_number' => 'required|unique:service_transactions,invoice_number,' . $id . ',transaction_id',
            // other validation rules...
        ]);

        // Remove currency formatting from total price
        $totalPrice = preg_replace('/[^0-9]/', '', $request->total_price); // Remove all non-numeric characters

        $transaction = ServiceTransaction::findOrFail($id);
        $transaction->fill($request->except('total_price', 'service_id'));
        $transaction->total_price = $totalPrice;
        $transaction->service_ids = json_encode($request->service_id); // Convert the service_ids array to a JSON string
        $transaction->save();

        return redirect()->route('service_transactions.index')->with('success', 'Service transaction updated successfully.');
    }
    public function getLaptopDetails($laptopId)
    {
        $laptop = Laptop::find($laptopId);
        return response()->json($laptop);
    }
    public function destroy($id)
    {
        $transaction = ServiceTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('service_transactions.index')->with('success', 'Service transaction deleted successfully.');
    }
    public function showPayForm($transaction_id)
    {
        $transaction = ServiceTransaction::findOrFail($transaction_id);
        return view('service_transactions.pay', compact('transaction'));
    }

    public function processPayment(Request $request, $transaction_id)
    {
        $transaction = ServiceTransaction::findOrFail($transaction_id);
        $totalAmount = $transaction->total_price;
        $paymentAmount = preg_replace('/[^0-9]/', '', $request->payment_amount);

        if ($paymentAmount >= $totalAmount) {
            $changeAmount = $paymentAmount - $totalAmount;
            $transaction->status = 'completed';
            $transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful. Change: Rp. ' . number_format($changeAmount, 0, ',', '.')
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Payment amount is less than the total amount.'], 400);
        }
    }
    public function show($transaction_id)
    {
        $serviceTransaction = ServiceTransaction::with(['technician', 'customer', 'laptop', 'warranty'])->findOrFail($transaction_id);
        $technicians = User::all();
        $customers = Customer::with('laptops')->get();
        $services = Service::all();

        return view('service_transactions.view', compact('serviceTransaction', 'technicians', 'customers', 'services'));
    }
    public function print($transaction_id)
    {
        $serviceTransaction = ServiceTransaction::with(['technician', 'customer', 'laptop', 'warranty'])->findOrFail($transaction_id);
        $services = Service::all();

        return view('service_transactions.print', compact('serviceTransaction', 'services'));
    }
}
