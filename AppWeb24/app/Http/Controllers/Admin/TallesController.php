<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Talle\BulkDestroyTalle;
use App\Http\Requests\Admin\Talle\DestroyTalle;
use App\Http\Requests\Admin\Talle\IndexTalle;
use App\Http\Requests\Admin\Talle\StoreTalle;
use App\Http\Requests\Admin\Talle\UpdateTalle;
use App\Models\Talle;
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

class TallesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTalle $request
     * @return array|Factory|View
     */
    public function index(IndexTalle $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Talle::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'Talle', 'Ancho', 'Altura'],

            // set columns to searchIn
            ['id', 'Talle', 'Ancho', 'Altura']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.talle.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.talle.create');

        return view('admin.talle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTalle $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTalle $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Talle
        $talle = Talle::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/talles'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/talles');
    }

    /**
     * Display the specified resource.
     *
     * @param Talle $talle
     * @throws AuthorizationException
     * @return void
     */
    public function show(Talle $talle)
    {
        $this->authorize('admin.talle.show', $talle);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Talle $talle
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Talle $talle)
    {
        $this->authorize('admin.talle.edit', $talle);


        return view('admin.talle.edit', [
            'talle' => $talle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTalle $request
     * @param Talle $talle
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTalle $request, Talle $talle)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Talle
        $talle->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/talles'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/talles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTalle $request
     * @param Talle $talle
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTalle $request, Talle $talle)
    {
        $talle->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTalle $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTalle $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Talle::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
