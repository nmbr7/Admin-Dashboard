<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Routing\Controllers\HasMiddleware;


/** 
 * Resources Controller.
 */
class ResourceController extends Controller  implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            function (Request $request, Closure $next) {
                $res = User::where('api_token', $request->cookie('session'))->count();

                if ($res == null) {
                    return response("Unauthorized", 401);
                }

                return $next($request);
            },
        ];
    }

    /**
     * Get all resources.
     */
    public function index($type)
    {
        $resourceInstance = getResourceInstance($type);
        return $resourceInstance::all();
    }

    /**
     * Create a resource.
     */
    public function store(Request $request, $type)
    {
        $resourceInstance = getResourceInstance($type);
        $resourceInstance->validate_resource($request);

        return $resourceInstance::create(json_decode($request->getContent(), true));
    }

    /**
     * Update a resource.
     */
    public function update(Request $request, $type, $id)
    {
        $resourceInstance = getResourceInstance($type);
        $resource = $resourceInstance::findOrFail($id);

        $resource->validate_resource($request);
        $resource->update_resource($request);

        return $resource;
    }
}


/**
 * Enum representing different resources
 * Note: A corresponding enum value should be added for all newly added Resource model in [Apps\Models]
 */
enum Resource_Type: string
{
        // Entry for [App\Models\Invoice]
    case Invoices = "invoices";

        // Entry for [App\Models\Customer]
    case Customers = "customers";
}

/**
 * Enum representing different resources
 * Note: A corresponding enum value should be added for all newly added Resource model in [Apps\Models]
 */
function getResourceInstance($type)
{
    switch (Resource_Type::tryFrom($type)) {
        case Resource_Type::Invoices:
            return new Invoice;
            break;
        case Resource_Type::Customers:
            return new Customer;
            break;
        default:
            throw ValidationException::withMessages(['error' => "Invalid value provided for 'type' url param."]);
    }
}
