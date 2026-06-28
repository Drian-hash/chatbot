<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{
    /**
     * LIST USER
     */
    public function index(Request $request)
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");

            });

        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.user.index',
            compact('users')
        );
    }

    /**
     * EXPORT EXCEL
     */
    public function export()
    {
        return Excel::download(
            new UserExport,
            'data-user.xlsx'
        );
    }
}

