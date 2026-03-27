import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/ubicaciones',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::index
* @see app/Http/Controllers/ProductLocationController.php:20
* @route '/admin/ubicaciones'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
export const mapa = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mapa.url(options),
    method: 'get',
})

mapa.definition = {
    methods: ["get","head"],
    url: '/admin/ubicaciones/mapa',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
mapa.url = (options?: RouteQueryOptions) => {
    return mapa.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
mapa.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mapa.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
mapa.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mapa.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
const mapaForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: mapa.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
mapaForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: mapa.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::mapa
* @see app/Http/Controllers/ProductLocationController.php:359
* @route '/admin/ubicaciones/mapa'
*/
mapaForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: mapa.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

mapa.form = mapaForm

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
export const asignar = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: asignar.url(options),
    method: 'get',
})

asignar.definition = {
    methods: ["get","head"],
    url: '/admin/ubicaciones/asignar',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
asignar.url = (options?: RouteQueryOptions) => {
    return asignar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
asignar.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: asignar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
asignar.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: asignar.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
const asignarForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: asignar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
asignarForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: asignar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::asignar
* @see app/Http/Controllers/ProductLocationController.php:401
* @route '/admin/ubicaciones/asignar'
*/
asignarForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: asignar.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

asignar.form = asignarForm

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
export const editar = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editar.url(options),
    method: 'get',
})

editar.definition = {
    methods: ["get","head"],
    url: '/admin/ubicaciones/editar',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
editar.url = (options?: RouteQueryOptions) => {
    return editar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
editar.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
editar.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: editar.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
const editarForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
editarForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::editar
* @see app/Http/Controllers/ProductLocationController.php:437
* @route '/admin/ubicaciones/editar'
*/
editarForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editar.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

editar.form = editarForm

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
export const listar = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: listar.url(options),
    method: 'get',
})

listar.definition = {
    methods: ["get","head"],
    url: '/admin/ubicaciones/api/listar',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
listar.url = (options?: RouteQueryOptions) => {
    return listar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
listar.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: listar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
listar.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: listar.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
const listarForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: listar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
listarForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: listar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::listar
* @see app/Http/Controllers/ProductLocationController.php:66
* @route '/admin/ubicaciones/api/listar'
*/
listarForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: listar.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

listar.form = listarForm

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
export const show = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/ubicaciones/api/{product}/obtener',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
show.url = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { product: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            product: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        product: typeof args.product === 'object'
        ? args.product.id
        : args.product,
    }

    return show.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
show.get = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
show.head = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
const showForm = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
showForm.get = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProductLocationController::show
* @see app/Http/Controllers/ProductLocationController.php:111
* @route '/admin/ubicaciones/api/{product}/obtener'
*/
showForm.head = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\ProductLocationController::store
* @see app/Http/Controllers/ProductLocationController.php:140
* @route '/admin/ubicaciones/api/{product}'
*/
export const store = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/ubicaciones/api/{product}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ProductLocationController::store
* @see app/Http/Controllers/ProductLocationController.php:140
* @route '/admin/ubicaciones/api/{product}'
*/
store.url = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { product: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            product: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        product: typeof args.product === 'object'
        ? args.product.id
        : args.product,
    }

    return store.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::store
* @see app/Http/Controllers/ProductLocationController.php:140
* @route '/admin/ubicaciones/api/{product}'
*/
store.post = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::store
* @see app/Http/Controllers/ProductLocationController.php:140
* @route '/admin/ubicaciones/api/{product}'
*/
const storeForm = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::store
* @see app/Http/Controllers/ProductLocationController.php:140
* @route '/admin/ubicaciones/api/{product}'
*/
storeForm.post = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\ProductLocationController::toggleActive
* @see app/Http/Controllers/ProductLocationController.php:200
* @route '/admin/ubicaciones/api/{product}/toggle-status'
*/
export const toggleActive = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleActive.url(args, options),
    method: 'post',
})

toggleActive.definition = {
    methods: ["post"],
    url: '/admin/ubicaciones/api/{product}/toggle-status',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ProductLocationController::toggleActive
* @see app/Http/Controllers/ProductLocationController.php:200
* @route '/admin/ubicaciones/api/{product}/toggle-status'
*/
toggleActive.url = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { product: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            product: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        product: typeof args.product === 'object'
        ? args.product.id
        : args.product,
    }

    return toggleActive.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::toggleActive
* @see app/Http/Controllers/ProductLocationController.php:200
* @route '/admin/ubicaciones/api/{product}/toggle-status'
*/
toggleActive.post = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleActive.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::toggleActive
* @see app/Http/Controllers/ProductLocationController.php:200
* @route '/admin/ubicaciones/api/{product}/toggle-status'
*/
const toggleActiveForm = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleActive.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::toggleActive
* @see app/Http/Controllers/ProductLocationController.php:200
* @route '/admin/ubicaciones/api/{product}/toggle-status'
*/
toggleActiveForm.post = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleActive.url(args, options),
    method: 'post',
})

toggleActive.form = toggleActiveForm

/**
* @see \App\Http\Controllers\ProductLocationController::destroy
* @see app/Http/Controllers/ProductLocationController.php:236
* @route '/admin/ubicaciones/api/{product}'
*/
export const destroy = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/ubicaciones/api/{product}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\ProductLocationController::destroy
* @see app/Http/Controllers/ProductLocationController.php:236
* @route '/admin/ubicaciones/api/{product}'
*/
destroy.url = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { product: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            product: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        product: typeof args.product === 'object'
        ? args.product.id
        : args.product,
    }

    return destroy.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::destroy
* @see app/Http/Controllers/ProductLocationController.php:236
* @route '/admin/ubicaciones/api/{product}'
*/
destroy.delete = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\ProductLocationController::destroy
* @see app/Http/Controllers/ProductLocationController.php:236
* @route '/admin/ubicaciones/api/{product}'
*/
const destroyForm = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::destroy
* @see app/Http/Controllers/ProductLocationController.php:236
* @route '/admin/ubicaciones/api/{product}'
*/
destroyForm.delete = (args: { product: number | { id: number } } | [product: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

/**
* @see \App\Http\Controllers\ProductLocationController::nearby
* @see app/Http/Controllers/ProductLocationController.php:264
* @route '/admin/ubicaciones/api/cercanos'
*/
export const nearby = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: nearby.url(options),
    method: 'post',
})

nearby.definition = {
    methods: ["post"],
    url: '/admin/ubicaciones/api/cercanos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ProductLocationController::nearby
* @see app/Http/Controllers/ProductLocationController.php:264
* @route '/admin/ubicaciones/api/cercanos'
*/
nearby.url = (options?: RouteQueryOptions) => {
    return nearby.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductLocationController::nearby
* @see app/Http/Controllers/ProductLocationController.php:264
* @route '/admin/ubicaciones/api/cercanos'
*/
nearby.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: nearby.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::nearby
* @see app/Http/Controllers/ProductLocationController.php:264
* @route '/admin/ubicaciones/api/cercanos'
*/
const nearbyForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: nearby.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductLocationController::nearby
* @see app/Http/Controllers/ProductLocationController.php:264
* @route '/admin/ubicaciones/api/cercanos'
*/
nearbyForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: nearby.url(options),
    method: 'post',
})

nearby.form = nearbyForm

const ProductLocationController = { index, mapa, asignar, editar, listar, show, store, toggleActive, destroy, nearby }

export default ProductLocationController