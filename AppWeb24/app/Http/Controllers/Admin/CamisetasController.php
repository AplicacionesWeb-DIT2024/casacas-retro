<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Camiseta\BulkDestroyCamiseta;
use App\Http\Requests\Admin\Camiseta\DestroyCamiseta;
use App\Http\Requests\Admin\Camiseta\IndexCamiseta;
use App\Http\Requests\Admin\Camiseta\StoreCamiseta;
use App\Http\Requests\Admin\Camiseta\UpdateCamiseta;
use App\Models\Camiseta;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CamisetasController extends Controller
{

    public function apiIndex()
    {
        $camisetas = Camiseta::all();
        return response()->json($camisetas);
    }

    public function apiIndexClubesNacionales()
    {
        $camisetas = Camiseta::where('Categoría', 'Club Nacional')->get();
        return response()->json($camisetas);
    }

    public function apiIndexClubesInternacionales()
    {
        $camisetas = Camiseta::where('Categoría', 'Club Internacional')->get();
        return response()->json($camisetas);
    }

    public function apiIndexSelecciones()
    {
        $camisetas = Camiseta::where('Categoría', 'Selección')->get();
        return response()->json($camisetas);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCamiseta $request
     * @return array|Factory|View
     */
    public function index(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, null);
    }
    public function indexClubesNacionales(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, 'Club Nacional');
    }

    public function indexClubesInternacionales(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, 'Club Internacional');
    }

    public function indexSelecciones(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, 'Selección');
    }

    private function filterByCategory(IndexCamiseta $request, ?string $category)
    {

        $query = Camiseta::query();

        // Filtra por categoría si está proporcionada
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Camiseta::class)
            ->modifyQuery(function ($query) use ($category) {
                if ($category) {
                    $query->where('Categoría', $category);
                }
            })
            ->processRequestAndGet(
            // pass the request with params
            $request,
            // set columns to query
            ['id', 'Nombre', 'Descripción', 'Precio', 'Talle', 'Cantidad', 'Categoría', 'Imagen'],
            // set columns to searchIn
            ['id', 'Nombre', 'Descripción', 'Talle', 'Categoría']
        );

        if ($request->ajax() || $request->wantsJson() || $request->query('json', false)) {
            if ($request->has('bulk')) {
                return response()->json(['bulkItems' => $data->pluck('id')]);
            }
            return response()->json(['data' => $data]);
        }

        return view('admin.camiseta.index', ['data' => $data, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.camiseta.create');

        return view('admin.camiseta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCamiseta $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCamiseta $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Procesar la imagen proporcionada
        if ($request->hasFile('Imagen')) {
            try {
                $image = $request->file('Imagen');
                $extension = $image->getClientOriginalExtension();
                if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    throw new \Exception('El archivo no es una imagen válida');
                }
                $filename = 'casacas-retro/' . Str::random(10) . '.' . $extension;
                $image->storeAs('public', $filename);
                $sanitized['Imagen'] = asset('storage/' . $filename);

                // verifica que la imagen se haya guardado con éxito antes de actualizar el array $sanitized.
                if (!file_exists(storage_path('app/public/' . $filename))) {
                    throw new Exception('Error al guardar la imagen');
                }
            } catch (Exception $e) {
                // Manejar errores si falla la subida de la imagen
                return back()->withErrors(['error' => 'Error al cargar la imagen: ' . $e->getMessage()]);
            }
        }else {
            $sanitized['Imagen'] = 'app/public/casacas-retro/messi2010.jpeg'; // Establecer imagen predeterminada
        }

        // Guardar la camiseta en la base de datos
        Camiseta::create($sanitized);

        // Redireccionar a la vista de la camiseta
        if ($request->ajax()) {
            return [
                'redirect' => url('admin/camisetas'), 
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')
            ];
        }

        return redirect('admin/camisetas');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCamiseta $request
     * @param Camiseta $camisetum
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCamiseta $request, Camiseta $camisetum)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Procesar la imagen si se proporciona
        if ($request->hasFile('Imagen')) {
            try {
                $image = $request->file('Imagen');
                $imageName = 'camiseta_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $sanitized['Nombre']) . '.' . $image->getClientOriginalExtension();
                
                // Guardar la imagen en la carpeta public/camisetas
                $image->move(public_path('camisetas'), $imageName);

                // Guardar la ruta de la imagen en el campo 'Imagen'
                $sanitized['Imagen'] = 'camisetas/' . $imageName;

                // Eliminar la imagen anterior si existe
                if ($camisetum->Imagen) {
                    $oldImagePath = public_path($camisetum->Imagen);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            } catch (Exception $e) {
                return back()->withErrors(['error' => 'Error uploading image: ' . $e->getMessage()]);
            }
        }

        // Actualizar la camiseta en la base de datos
        $camisetum->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/camisetas'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/camisetas');
    }

    /**
     * Display the specified resource.
     *
     * @param Camiseta $camisetum
     * @throws AuthorizationException
     * @return void
     */
    public function show(Camiseta $camisetum)
    {
        $this->authorize('admin.camiseta.show', $camisetum);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Camiseta $camisetum
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Camiseta $camisetum)
    {
        $this->authorize('admin.camiseta.edit', $camisetum);


        return view('admin.camiseta.edit', [
            'camisetum' => $camisetum,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCamiseta $request
     * @param Camiseta $camisetum
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCamiseta $request, Camiseta $camisetum)
    {
        $camisetum->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCamiseta $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCamiseta $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Camiseta::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
