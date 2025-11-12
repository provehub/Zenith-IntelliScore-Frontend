import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../wayfinder'
/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \MainController::dashboard
* @see [unknown]:0
* @route '/dashboard'
*/
dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dashboard.form = dashboardForm

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
export const userDashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userDashboard.url(options),
    method: 'get',
})

userDashboard.definition = {
    methods: ["get","head"],
    url: '/user/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
userDashboard.url = (options?: RouteQueryOptions) => {
    return userDashboard.definition.url + queryParams(options)
}

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
userDashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userDashboard.url(options),
    method: 'get',
})

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
userDashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: userDashboard.url(options),
    method: 'head',
})

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
const userDashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: userDashboard.url(options),
    method: 'get',
})

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
userDashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: userDashboard.url(options),
    method: 'get',
})

/**
* @see \MainController::userDashboard
* @see [unknown]:0
* @route '/user/dashboard'
*/
userDashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: userDashboard.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

userDashboard.form = userDashboardForm

const MainController = { dashboard, userDashboard }

export default MainController