import Public from './Public'
import Auth from './Auth'
import Settings from './Settings'
import AccesosController from './AccesosController'
import RolesController from './RolesController'
import ProductLocationController from './ProductLocationController'
import ProductController from './ProductController'
import ProductImageController from './ProductImageController'

const Controllers = {
    Public: Object.assign(Public, Public),
    Auth: Object.assign(Auth, Auth),
    Settings: Object.assign(Settings, Settings),
    AccesosController: Object.assign(AccesosController, AccesosController),
    RolesController: Object.assign(RolesController, RolesController),
    ProductLocationController: Object.assign(ProductLocationController, ProductLocationController),
    ProductController: Object.assign(ProductController, ProductController),
    ProductImageController: Object.assign(ProductImageController, ProductImageController),
}

export default Controllers