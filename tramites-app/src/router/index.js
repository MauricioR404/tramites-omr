import { createRouter, createWebHistory } from 'vue-router'

import ListadoTramites from '../views/ListadoTramites.vue'
import RegistroTramite from '../views/RegistroTramite.vue'
import RegistroInstitucion from '../views/RegistroInstitucion.vue'

const routes = [
    { path: '/',                  component: ListadoTramites },
    { path: '/tramites/crear',    component: RegistroTramite },
    { path: '/tramites/:id/editar', component: RegistroTramite },
    { path: '/instituciones/crear', component: RegistroInstitucion },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router