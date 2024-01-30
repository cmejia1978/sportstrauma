<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use Bican\Roles\Models\Role;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class UsersController extends Controller
{
    protected $auth;
    
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    protected $messages = array(
        'name.required'     => 'Debe ingresar un nombre',
        'email.required'    => 'Debe ingresar una dirección de correo',
        'email.email'       => 'Debe ingresar una dirección de correo válida',
        'email.unique'      => 'Esta dirección de correo ya esta registrada',
        'password.required' => 'Debe ingresar una contraseña',
        'password.min'      => 'Debe ingresar una contraseña con un mínimo de 6 caracteres',
    );

    public function getUsersData() {
        return Datatables::of(
            User//::with('roles')
                ::join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.updated_at', 'roles.name as rolename'))
            //->editColumn('id', $rowControls)
            ->make(true);
    }

    public function getUsers($reqOrderBy = 'created_at', $reqOrder = 'desc', $reqPages = 10, $reqWhere = 'all')
    {
        return view('admin.user.users');
    }


    public function getAddUser()
    {
        $roles = Role::all();
        return view('admin.user.new', ['roles' => $roles]);
    }

    public function postAddUser(Request $request)
    {
        $validation = $this->validateInput($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ], $this->messages);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation, 'user')->withInput();
        }

        $user = $this->create($request->all());

        return redirect('admin/users')->with(['message' => 'El usuario ha sido agregado con éxito.', 'user_id' => $user['id']]);
    }

    public function getUpdateUser($id)
    {
        $user = User::with('roles')->get()->find($id);
        $roles = Role::all();

        return view('admin.user.update', ['user' => $user, 'roles' => $roles]);
    }

    public function postUpdateUser(Request $request)
    {
        $validation = $this->validateInput($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $request->get('user_id'),
            'password' => 'min:6',
        ], $this->messages);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation, 'user')->withInput();
        }

        $user = $this->update($request->all());

        return redirect('admin/users')->with(['message' => 'El usuario se actualizado con éxito.', 'user_id' => $user['id']]);
    }

    public function getRemoveUser($id)
    {
        $user = User::find($id);

        return view('admin.user.remove', ['user' => $user]);
    }

    public function postRemoveUser(Request $request)
    {
        $id = $request->get('user_id');
        $this->remove($id);
        return redirect('admin/users')->with(['message' => 'Se ha eliminado al usuario con éxito.']);
    }

    protected function validateInput(Request $request, $rules, array $messages)
    {
        return Validator::make($request->all(), $rules, $messages);
    }

    protected function remove($id)
    {
        $user = User::find($id);
        $user->delete();
    }

    protected function update($data)
    {
        $user = User::find($data['user_id']);

        if ($user) {
            $user->name = $data['name'];
            $user->email = $data['email'];
            if ($data['password']) {
                $user->password = bcrypt($data['password']);
            }
            $user->save();

            $user->detachAllRoles();

            $role = Role::find($data['role']);
            $user->attachRole($role);
        }

        return $user;
    }

    protected function create($data)
    {
        $user = User::create(array(
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password'])
        ));

        $role = Role::find($data['role']);
        $user->attachRole($role);

        return $user;
    }

}
