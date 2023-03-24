import 'vanilla-ripplejs'

import './frontend.scss'
import './vue/all'
import './vue/filters'

import common from './routes/common'
import home from './routes/home'
import search from './routes/search'
import postProperty from './routes/postProperty'
import singleRoom from './routes/room'
import singleProject from './routes/project'
import singleService from './routes/service'
import aboutUs from './routes/about'
import contact from './routes/contact'
import compare from './routes/compare'
import academy from './routes/academy'
import singleProduct from './routes/product'
import account from './routes/account'
import managementService from './routes/managementService'
import landAndBuildingTax from './routes/landAndBuildingTax'
import inspectionService from './routes/inspectionService'
import interior from './routes/interiorService'

import Router from './util/Router'

const contactForm = contact
const termCourses = academy

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  common,
  home,
  search,
  postProperty,
  singleRoom,
  singleProject,
  singleService,
  aboutUs,
  contact,
  contactForm,
  compare,
  academy,
  termCourses,
  singleProduct,
  account,
  managementService,
  landAndBuildingTax,
  inspectionService,
  interior,
})

window.addEventListener('DOMContentLoaded', () => {
  routes.loadEvents()
})
