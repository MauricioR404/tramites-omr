<template>
  <div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Listado de Trámites</h1>

    <!-- Filtro -->
    <div class="bg-white rounded shadow p-4 mb-6 flex gap-4 items-end">
      <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700 mb-1">Filtrar por institución</label>
        <select v-model="filtroInstitucion" @change="cargarTramites(1)"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Todas</option>
          <option v-for="inst in instituciones" :key="inst.id" :value="inst.id">
            {{ inst.nombre }}
          </option>
        </select>
      </div>
      <router-link to="/tramites/crear"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Nuevo Trámite
      </router-link>
    </div>

    <!-- Cargando -->
    <div v-if="cargando" class="text-center py-10 text-gray-500">Cargando...</div>

    <!-- Tabla -->
    <div v-else class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
          <tr>
            <th class="px-4 py-3 text-left">Código</th>
            <th class="px-4 py-3 text-left">Nombre</th>
            <th class="px-4 py-3 text-left">Institución</th>
            <th class="px-4 py-3 text-left">Días Hábiles</th>
            <th class="px-4 py-3 text-left">Estado</th>
            <th class="px-4 py-3 text-left">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr v-for="tramite in tramites" :key="tramite.id" class="hover:bg-gray-50">
            <td class="px-4 py-3">{{ tramite.codigo }}</td>
            <td class="px-4 py-3">{{ tramite.nombre }}</td>
            <td class="px-4 py-3">{{ tramite.institucion?.nombre }}</td>
            <td class="px-4 py-3">{{ tramite.dias_habiles }}</td>
            <td class="px-4 py-3">
              <span :class="tramite.activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                class="px-2 py-1 rounded-full text-xs font-medium">
                {{ tramite.activo ? 'Activo' : 'Inactivo' }}
              </span>
            </td>
            <td class="px-4 py-3 flex gap-2">
              <router-link :to="`/tramites/${tramite.id}/editar`"
                class="bg-yellow-400 text-white px-3 py-1 rounded text-xs hover:bg-yellow-500">
                Ver
              </router-link>
              <button v-if="tramite.activo" @click="desactivar(tramite)"
                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                Desactivar
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginación -->
      <div class="flex justify-between items-center px-4 py-3 border-t text-sm text-gray-600">
        <span>Página {{ paginacion.current_page }} de {{ paginacion.last_page }}</span>
        <div class="flex gap-2">
          <button @click="cargarTramites(paginacion.current_page - 1)"
            :disabled="paginacion.current_page === 1"
            class="px-3 py-1 rounded border hover:bg-gray-100 disabled:opacity-40">
            Anterior
          </button>
          <button @click="cargarTramites(paginacion.current_page + 1)"
            :disabled="paginacion.current_page === paginacion.last_page"
            class="px-3 py-1 rounded border hover:bg-gray-100 disabled:opacity-40">
            Siguiente
          </button>
        </div>
      </div>
    </div>

    <!-- Error -->
    <div v-if="error" class="mt-4 bg-red-100 text-red-700 px-4 py-3 rounded">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../plugins/axios.js'

const tramites = ref([])
const instituciones = ref([])
const filtroInstitucion = ref('')
const cargando = ref(false)
const error = ref('')
const paginacion = ref({ current_page: 1, last_page: 1 })

const cargarInstituciones = async () => {
  const { data } = await api.get('/instituciones')
  instituciones.value = data.data
}

const cargarTramites = async (pagina = 1) => {
  cargando.value = true
  error.value = ''
  try {
    const params = { page: pagina }
    if (filtroInstitucion.value) params.institucion_id = filtroInstitucion.value
    const { data } = await api.get('/tramites', { params })
    tramites.value = data.data
    paginacion.value = data.meta
  } catch (e) {
    error.value = 'Error al cargar los trámites'
  } finally {
    cargando.value = false
  }
}

const desactivar = async (tramite) => {
  if (!confirm(`¿Desactivar el trámite "${tramite.nombre}"?`)) return
  try {
    await api.delete(`/tramites/${tramite.id}`)
    await cargarTramites(paginacion.value.current_page)
  } catch (e) {
    error.value = 'Error al desactivar el trámite'
  }
}

onMounted(() => {
  cargarInstituciones()
  cargarTramites()
})
</script>