<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\ResourceInterface;


/**
 * Invoice Resource Model.
 */
class Invoice extends Model implements ResourceInterface
{
    use HasFactory;

    public static $createRules = [
        'customer' => 'required',
        'date' => 'date',
    ];

    public function validate_resource(Request $request)
    {
        Validator::make(json_decode($request->getContent(), true), Invoice::$createRules)->validate();

        $req = json_decode($request->getContent());

        // Check if the 'name' provided exists in the customer model.
        $res = Customer::where('name', $req->customer)->count();
        if ($res == null) {
            throw ValidationException::withMessages(["Provide a valid customer name"]);
        }
    }

    public function update_resource(Request $request)
    {
        $this->update(json_decode($request->getContent(), true));
    }

    protected $fillable = ['customer', 'date', 'amount', 'status'];
}
