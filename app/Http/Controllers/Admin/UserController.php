<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->getAllPaginated();
        return view('admin.users.index', $data);
    }

    public function create()
    {
        $roles = $this->service->getAllRoles();
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserStoreRequest $request)
    {
        $this->service->createUser($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = $this->service->findUser($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $data = $this->service->getUserForEdit($id);
        return view('admin.users.edit', $data);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $this->service->updateUser($request->validated(), $id);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $this->service->deleteUser($id);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
