<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    
    public function index()
    {
        $invoices = Invoice::with('customer')->get();
        return response()->json(
            [
                'invoices'=>$invoices
            ]
            );
    }


    public function search(Request $request)
    {

        if($request->s){
        $invoice = Invoice::with('customer')
        ->where('id','LIKE',"%$request->s%")
        ->get();
        return response()->json([
            'invoices'=>$invoice
        ]);

       }
       else{
        return $this->index();
       }
    }
    public function create(Request $request)
    {
     $counter = Counter::where('key','invoice')->first();
     $random = Counter::where('key','invoice')->first();

     $invoice = Invoice::orderBy('id','DESC')->first();
if($invoice){
$invoice = $invoice->id + 1;
$counters = $counter->value + $invoice;
}
else{
    $counters = $counter->value ;
}
$formData=[
    'number'=> $counter->prefix . $counters,
    'customer_id'=>1,
    'customer'=>null,
    'invoice_date'=>date("Y-m-d"),
    'due_date'=>null,
    'reference'=>'reference',
    'discount'=>0,
    'terms_and_conditions'=>'default terms and conditions',
    'products'=>[
        'product_id'=>1,
        'product'=>null,
        'unit_price'=>111,
        'quantity'=>1
    ]
];
return response()->json($formData);
    }





    public function store(Request $request)
    {
        try{
        $invoice_product = $request->invoice_product;
        $invoice_data['sub_total'] = $request->subtotal;
        $invoice_data['discount'] = $request->discount;
        $invoice_data['total'] = $request->total;
        $invoice_data['customer_id'] = $request->customer_id;
        $invoice_data['invoice_date'] = $request->invoice_date;
        $invoice_data['due_date'] = $request->due_date;
        $invoice_data['number'] = $request->number;
        $invoice_data['reference'] = $request->reference;
        $invoice_data['terms_and_conditions'] = $request->terms_and_conditions;



        $invoice = Invoice::create($invoice_data);


        foreach(json_decode($invoice_product) as $product){
            $item_data['product_id'] = $product->id;
            $item_data['invoice_id'] = $invoice->id;
            $item_data['unit_price'] = $product->unite_price;
            $item_data['quantity'] = $product->quantity;

            InvoiceProduct::create($item_data);

        }
    }
    catch (\Exception $e) {
        return $e;
}



    }

    public function show($id)
    {

        $invoice = Invoice::with(['customer','items.product'])->where('id',$id)->first();
     return response()->json([
        'invoice'=>$invoice
     ])  ;
    }


    public function delete_item($id)
    {
     $item= InvoiceProduct::find($id);
     if($item){
     $item->delete();}
    }
}
