# Simple Admin Dashboard

A simple UI to display some Customer and Invoice data.

## Build Dependencies

-   Frontend - NPM, Angular
-   Backend - PHP, Laravel
-   DB - sqlite. DB file is available at `/database/database.sqlite`, `sqlite shell` is required to run DB queries directly; like for adding new users in the `users` table.

## How to Build & Run the server

To build and run the project run `php artisan serve` from the project root folder, and visit `http://127.0.0.1:8000` to access the UI.

The Angular UI related deployment files are in the `/public/assets/angular` folder,

## APIs

### API controllers

Provide mainly two APIs - login and resources APIs

-   PHP Resource API controller - `App\Http\Controllers\ResourceController`
-   PHP Login API controller - `App\Http\Controllers\LoginController`

The provided Resource APIs can be used to manage two resources:

-   Customer Resource

    ```
    {
        id: string,
        name: string,
        phone: string,
        email: string,
        address: string
    }
    ```

-   Invoice Resource

    ```
    {
        id: string,
        customer: string,
        date: string,
        amount: number,
        status: string  /** [Paid/Unpaid/Cancelled] */
    }
    ```

### API Route Details

1.  `GET` - `/resources/{type}`

    -   API to get a list of resources based on the `type` param.
    -   `type` can either have value `customers` or `invoices`.
    -   `index` method in `App\Http\Controllers\ResourceController` handles this API.
    -   Resturn `Customer` and `Invoice` Contracts

2.  `POST` - `/resources/{type}`

    -   API to create a resources based on the `type` param.
    -   `store` method in `App\Http\Controllers\ResourceController` handles this API.
    -   Takes `Customer` and `Invoice` Contracts (`id` is not required) as `JSON`.

3.  `PUT` - `/resources/{type}/{id}`

    -   API to update a resources based on the `type` and `id` param .
    -   `update` method in `App\Http\Controllers\ResourceController` handles this API.
    -   Takes `Customer` and `Invoice` Contracts (`id` in the body is not considered) as `JSON` .

4.  `POST` - `/login`

    -   `login` method in `App\Http\LoginController` handles this API.
    -   Takes Login contract as `JSON`

        ```
        {
            username: string
            password: string
        }
        ```

    -   Returns `set-cookie` header with `session` value, this cookie value will be required for subsequent API calls to `Resources` API.
    -   **Note**:- Will need to manually add `username` and `password` values in the `users` DB table. `api_token` is generated and added to `users` table on all new login.
