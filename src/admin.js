import './admin.scss'

import Router from './util/Router'
/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({})

window.addEventListener('DOMContentLoaded', () => {
  routes.loadEvents()
})
