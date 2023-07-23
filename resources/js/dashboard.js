import $ from 'jquery'

window.$ = $

import 'datatables.net-dt'

import AdvancedSearchController from './controllers/advanced-search_controller.js'

application.register("advanced-search", AdvancedSearchController)
