<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\BulkDestroyUser;
use App\Http\Requests\Admin\User\DestroyUser;
use App\Http\Requests\Admin\User\IndexUser;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateUser;
use App\Models\User;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    // Gestión de usuarios para la interfaz administrativa
    /**
     * Display a listing of the resource.
     *
     * @param IndexUser $request
     * @return array|Factory|View
     */
    public function index(IndexUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(User::class)->processRequestAndGet(
            // pass the request with params
            $request,
            ['id', 'name', 'email'], // Esto obtiene todas las columnas de la tabla users
            ['name', 'email'] // set columns to searchIn
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.user.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.user.create');

        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUser $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        // Store the User
        $user = User::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/users'), 
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')
            ];
        }
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @throws AuthorizationException
     * @return void
     */
    public function show(User $user)
    {
        $this->authorize('admin.user.show', $user);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(User $user)
    {
        $this->authorize('admin.user.edit', $user);

        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateUser $request, User $user)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values User
        $user->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/users'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUser $request
     * @param User $user
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUser $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyUser $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    User::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    /**
    *
    *GESTION DE USUARIOS PARA LA API
    *
    **/

    //Permite registrar nuevos usuarios.
    public function register(Request $request)
    {
        try{
            // Validación de datos de entrada
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }

            // Verificar que el usuario no esté registrado previamente
            if (User::whereEmail($request->input('email'))->exists()) {
                return response()->json(['error' => 'El usuario ya existe'], 422);
            }

            //crea el nuevo usuario en la base de datos usando los datos validados y la contraseña encriptada
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            
            return response()->json(['message' => 'Registro exitoso', 'user' => $user], 201);
        
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al registrar usuario: ' . $e->getMessage()], 500);
        }
    }

    //Permite a los usuarios iniciar sesión y genera un token.
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }

            $credentials = $request->only(['email', 'password']);

            if (!auth()->attempt($credentials)) {
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            }

            $user = auth()->user();

            // Verificar que el usuario esté activo y no esté bloqueado
            if (!$user->active || $user->blocked) {
                return response()->json(['error' => 'El usuario no está activo o está bloqueado'], 401);
            }

            $userModel = User::find($user->id); // Obtener la instancia de App\Models\User
            $token = $userModel->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'Autenticación exitosa', 'token' => $token, 'user' => $user, 'token_type' => 'Bearer'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al autenticar: ' . $e->getMessage()], 500);
        }
    }

    //Permite al usuario autenticado cerrar sesión.
    public function logout(Request $request)
    {
        // Elimina el token de acceso actual del usuario autenticado
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Cierre de sesión exitoso',
            'status' => 'success',
            'redirect' => null],200);
    }

    //Retorna los datos del usuario autenticado.
    public function profile(Request $request)
    {
        // Devuelve los datos del usuario autenticado
        $user = $request->user();
        return response()->json(['user' => $user], 200);
    }

    //Permite actualizar los datos del usuario autenticado.
    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Obtengo la instancia del usuario autenticado
        $user->update($request->all()); //Actualizo los datos del usuario con los datos proporcionados en la solicitud

        return response()->json(['user' => $user], 200);
    }

    
}
