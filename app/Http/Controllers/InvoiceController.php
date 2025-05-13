<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinary;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Crea una nueva factura
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $decodedItems = json_decode($request->input('items'), true);

        if (!is_array($decodedItems)) {
            return response()->json(['message' => 'Formato de ítems inválido'], 400);
        }
        $request->merge(['items' => $decodedItems]);
        $validated = $request->validate([
            'id_client' => 'required|exists:users,id',
            'id_veterinary' => 'required|exists:veterinaries,id',
            'id_appointment' => 'required|exists:appointments,id',
            'date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array',
            'total' => 'required|numeric',
            'tax_percentage' => 'required|numeric',
            'total_with_tax' => 'required|numeric',
        ]);
        $invoice = new Invoice($validated);
        $invoice->save();
        foreach ($validated['items'] as $itemData) {
            $item = new InvoiceItem($itemData);
            $item->id_invoice = $invoice->id;
            $item->save();
        }
        $invoiceItems = InvoiceItem::where('id_invoice', $invoice->id)->get();

        return response()->json([
            'id' => $invoice->id,
            'items' => $invoiceItems, 
            'total' => $invoice->total,
            'tax_percentage' => $invoice->tax_percentage,
            'total_with_tax' => $invoice->total_with_tax,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Cambia el estado de una factura
     */
    public function changeState(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $validated = $request->validate([
            'status' => 'required|in:Pendiente,Pagada,Anulada',
        ]);
        $invoice->status = $validated['status'];
        $invoice->save();

        return redirect()->route('veterinary.showInvoices')->with('success', 'Estado de la factura actualizado.');
    }

    /**
     * Permite descargar una factura en formato pdf
     */
    public function download($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $pdf = \PDF::loadView('pdf.invoice', compact('invoice'));

        return $pdf->download('factura_' . $invoice->id . '.pdf');
    }
}
