<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_roles()
    {
        $roles = Role::where('is_del', 0)->whereIn('id', [5, 6])->get(['id', 'name', 'is_del'])->toArray();
        $converted_roles = Utility::arrayKeysToCamelCase($roles);

        $data = [
            'roles' => (array) $converted_roles,
        ];
        return successResponse('Roles Fetched Successfully', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_roles()
    {
        $roles = Role::where('is_del', 0)->whereIn('id', [1, 2, 3, 4])->get(['id', 'name', 'is_del'])->toArray();
        $converted_roles = Utility::arrayKeysToCamelCase($roles);

        $data = [
            'roles' => (array) $converted_roles,
        ];
        return successResponse('Roles Fetched Successfully', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
