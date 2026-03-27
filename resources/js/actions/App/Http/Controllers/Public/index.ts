import HomeController from './HomeController'
import ContactoController from './ContactoController'
import PropiedadPublicController from './PropiedadPublicController'

const Public = {
    HomeController: Object.assign(HomeController, HomeController),
    ContactoController: Object.assign(ContactoController, ContactoController),
    PropiedadPublicController: Object.assign(PropiedadPublicController, PropiedadPublicController),
}

export default Public