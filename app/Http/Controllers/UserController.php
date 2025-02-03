<?php

namespace App\Http\Controllers;


use App\Services\UserService;
use App\Services\UserDataService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userDataService;
    protected $userService;

    // Constructor único que recibe ambos servicios
    public function __construct(UserDataService $userDataService, UserService $userService)
    {
        $this->userDataService = $userDataService;
        $this->userService = $userService;
    }

    /**
     * Mostrar el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = $this->userDataService->getCreatePageData();
        return view('users.create', $data);
    }

    /**
     * Almacenar un nuevo usuario en la base de datos.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();  // Solo datos validados
        $this->userService->createUser($validatedData);  // Usar datos validados
        return redirect()->route('management.dashboard')->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Mostrar la vista de gestión de usuarios.
     *
     * @return \Illuminate\View\View
     */
    // public function manage()
    // {
    //     $this->authorize('manage-users'); // Usar políticas de autorización de Laravel

    //     $users = $this->userDataService->getAllUsers();
    //     return view('users.manage', compact('users'));
    // }

    // public function listOperatorsByGroup()
    // {
    //     // Obtener el grupo del usuario autenticado (asumiendo que es un supervisor)
    //     $groupId = auth()->user()->group_id;
    //     $role = auth()->user()->role;

    //     // Usar el servicio para obtener los operadores
    //     $operators = $this->userService->getOperatorsByGroup($groupId, $role);

    //     return view('users.management.operators', compact('operators'));
    // }

    /**
     * Mostrar el formulario para editar un usuario.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = $this->userService->getEditPageData($id);

        return view('users.management.edit', $data);
    }

    public function update(UpdateUserRequest $request, $id)
    {

        $validatedData = $request->validated();

        $this->userService->updateUser($id, $validatedData);
        return redirect()->route('users.operators')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Buscar y eliminar (lógicamente) al usuario
        $this->userService->delete($id);

        return redirect()->route('users.operators')->with('success', 'Usuario eliminado correctamente.');
    }
}
