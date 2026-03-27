import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/accesos',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::index
* @see app/Http/Controllers/AccesosController.php:14
* @route '/admin/accesos'
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
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
*/
export const listar = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: listar.url(options),
    method: 'get',
})

listar.definition = {
    methods: ["get","head"],
    url: '/admin/accesos/listar',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
*/
listar.url = (options?: RouteQueryOptions) => {
    return listar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
*/
listar.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: listar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
*/
listar.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: listar.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
*/
const listarForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: listar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
*/
listarForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: listar.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::listar
* @see app/Http/Controllers/AccesosController.php:0
* @route '/admin/accesos/listar'
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
* @see \App\Http\Controllers\AccesosController::toggleStatus
* @see app/Http/Controllers/AccesosController.php:166
* @route '/admin/accesos/{id}/toggle-status'
*/
export const toggleStatus = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleStatus.url(args, options),
    method: 'post',
})

toggleStatus.definition = {
    methods: ["post"],
    url: '/admin/accesos/{id}/toggle-status',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AccesosController::toggleStatus
* @see app/Http/Controllers/AccesosController.php:166
* @route '/admin/accesos/{id}/toggle-status'
*/
toggleStatus.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return toggleStatus.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::toggleStatus
* @see app/Http/Controllers/AccesosController.php:166
* @route '/admin/accesos/{id}/toggle-status'
*/
toggleStatus.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleStatus.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccesosController::toggleStatus
* @see app/Http/Controllers/AccesosController.php:166
* @route '/admin/accesos/{id}/toggle-status'
*/
const toggleStatusForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleStatus.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccesosController::toggleStatus
* @see app/Http/Controllers/AccesosController.php:166
* @route '/admin/accesos/{id}/toggle-status'
*/
toggleStatusForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleStatus.url(args, options),
    method: 'post',
})

toggleStatus.form = toggleStatusForm

/**
* @see \App\Http\Controllers\AccesosController::store
* @see app/Http/Controllers/AccesosController.php:72
* @route '/admin/accesos'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/accesos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AccesosController::store
* @see app/Http/Controllers/AccesosController.php:72
* @route '/admin/accesos'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::store
* @see app/Http/Controllers/AccesosController.php:72
* @route '/admin/accesos'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccesosController::store
* @see app/Http/Controllers/AccesosController.php:72
* @route '/admin/accesos'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccesosController::store
* @see app/Http/Controllers/AccesosController.php:72
* @route '/admin/accesos'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\AccesosController::update
* @see app/Http/Controllers/AccesosController.php:123
* @route '/admin/accesos/{id}'
*/
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/accesos/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\AccesosController::update
* @see app/Http/Controllers/AccesosController.php:123
* @route '/admin/accesos/{id}'
*/
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::update
* @see app/Http/Controllers/AccesosController.php:123
* @route '/admin/accesos/{id}'
*/
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\AccesosController::update
* @see app/Http/Controllers/AccesosController.php:123
* @route '/admin/accesos/{id}'
*/
const updateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccesosController::update
* @see app/Http/Controllers/AccesosController.php:123
* @route '/admin/accesos/{id}'
*/
updateForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\AccesosController::destroy
* @see app/Http/Controllers/AccesosController.php:192
* @route '/admin/accesos/{id}'
*/
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/accesos/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\AccesosController::destroy
* @see app/Http/Controllers/AccesosController.php:192
* @route '/admin/accesos/{id}'
*/
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::destroy
* @see app/Http/Controllers/AccesosController.php:192
* @route '/admin/accesos/{id}'
*/
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\AccesosController::destroy
* @see app/Http/Controllers/AccesosController.php:192
* @route '/admin/accesos/{id}'
*/
const destroyForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccesosController::destroy
* @see app/Http/Controllers/AccesosController.php:192
* @route '/admin/accesos/{id}'
*/
destroyForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
export const accesos = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: accesos.url(options),
    method: 'get',
})

accesos.definition = {
    methods: ["get","head"],
    url: '/accesos',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
accesos.url = (options?: RouteQueryOptions) => {
    return accesos.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
accesos.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: accesos.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
accesos.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: accesos.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
const accesosForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: accesos.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
accesosForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: accesos.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccesosController::accesos
* @see app/Http/Controllers/AccesosController.php:0
* @route '/accesos'
*/
accesosForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: accesos.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

accesos.form = accesosForm

const AccesosController = { index, listar, toggleStatus, store, update, destroy, accesos }

export default AccesosController