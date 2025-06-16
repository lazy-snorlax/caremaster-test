# About Vue Front-End
This Vue front-end has been modified from the vanilla install to account for large scale rapid expansion in a few ways. The goal of this readme is to explain how this works.

## Stores
This application uses Pinia for state management. It is installed in the `stores/index.ts` file. This is also where you would define any plugins that Pinia should use. In this case, it is the axios interceptor class, which you can read about below.

In order to create more stores, simply create a `stores.ts` file, import the defineStore from pinia and go from there. Have a look at the `companies.ts` store for an example on this should work.

### Axios Interceptor
The `utilities/http.ts` is an axios interceptor class, with 2 goals:
 - Handle any errors thrown by the axios instance or what it's connecting to gracefully,
 - Handle any potential redirects when a user is not authorized for an action
This also has the added benefit of keeping the axios calls in the stores clean, without the need of a try/catch block.


## Composables
In this application, a lot of the computed values from the store states were abstracted away into composables. This was done for one reason: To not have to re-define the getters/setters on every page where they are needed (e.g. need data in company state when looking at an employee)

There are other composables, mainly to check the current user state (are you logged in?, who is logged in?) as well one for the admin widgets. (Admittedly, the admin widget one is probably superfluous.)


## Vue-Router
This application uses the `vue-router` package, but a few modifications have been implemented to rapid development & scalability.

### Router
The router is defined in the `router/index.ts` and sets up the routes, router guards and middleware. These can be found within the `router` subdirectory of this project. 

### Middleware & Guards
Currently, there is one router guard in place, checking if the current user is authenticated (who is then redirected to the login if they are not). Other guards can be setup following this pattern, for instance, if a user has authorized for certain actions within the application.

### Routes
All the routes in the application are defined in the `routes` subdirectory. Follow the `companies.ts` to create the routes needed. They have been designed for rapid development and expansion, and should allow for nearly any type of meta data per route.

### Templates
All the routes have been designed to have a base template implemented. You can modify templates in the `templates` directory, but make sure that any new ones are defined in the `templates/index.ts` with the appropriate key.
