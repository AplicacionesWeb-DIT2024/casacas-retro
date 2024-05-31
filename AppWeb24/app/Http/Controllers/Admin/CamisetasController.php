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
//use Illuminate\Http\Request;

class CamisetasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCamiseta $request
     * @return array|Factory|View
     */
    public function index(IndexCamiseta $request){
        return $this->filterByCategory($request, null);
    }
    public function indexClubesNacionales(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, 'Clubes Nacionales');
    }

    public function indexClubesInternacionales(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, 'Clubes Internacionales');
    }

    public function indexSelecciones(IndexCamiseta $request)
    {
        return $this->filterByCategory($request, 'Selecciones');
    }

    private function filterByCategory(IndexCamiseta $request, ?string $category)
    {

        //$query = Camiseta::query();

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
            ['id', 'Nombre', 'Descripción', 'Precio', 'Talle', 'Cantidad', 'Categoría'],
            // set columns to searchIn
            ['id', 'Nombre', 'Descripción', 'Talle', 'Categoría']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.camiseta.index', ['data' => $data]);
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

        // Store the Camiseta
        $camisetum = Camiseta::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/camisetas'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
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

        // Update changed values Camiseta
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
