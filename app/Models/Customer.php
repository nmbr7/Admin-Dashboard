<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\ResourceInterface;

/**
 * Customer Resource Model.
 */
class Customer extends Model implements ResourceInterface
{
    use HasFactory;

    public static $createRules = [
        'name' => 'required',
        'email' => 'email',
    ];

    public function validate_resource(Request $request)
    {
        Validator::make(json_decode($request->getContent(), true), Customer::$createRules)->validate();
    }

    public function update_resource(Request $request)
    {
        $old_resource = clone $this;
        $this->update(json_decode($request->getContent(), true));

        // Update the corresponding customer name in Invoice model.
        Invoice::where('customer', $old_resource->name)->update(['customer' => $this->name]);
    }

    protected $fillable = ['name', 'phone', 'email', 'address'];
}
