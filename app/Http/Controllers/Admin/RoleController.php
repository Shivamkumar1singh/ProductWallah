<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Services\RoleService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $roles = $this->service->listRoles();
        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = $this->service->getPermissions();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $this->service->createRole($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function show(string $id): View
    {
        $role = $this->service->findRole($id);
        $rolePermissions = $this->service->getRolePermissions($id);

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    public function edit(string $id): View
    {
        $role = $this->service->findRole($id);
        $permissions = $this->service->getPermissions();
        $rolePermissions = $this->service->getPermissionIds($id);

        return view('admin.roles.edit', compact('role','permissions','rolePermissions'));
    }

    public function update(RoleRequest $request, string $id): RedirectResponse
    {
        $this->service->updateRole($id, $request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->service->deleteRole($id);
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }
}
