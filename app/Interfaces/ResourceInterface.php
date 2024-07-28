<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/** 
 * Resource Interface to be implemented by all the Resource Models
 */
interface ResourceInterface
{
    /** Validate the provided resource from the api request. */
    public function validate_resource(Request $request);

    /** Update the provided resource from the api request. */
    public function update_resource(Request $request);
}
