<template>
  <div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
      {{ esEdicion ? 'Editar Trámite' : 'Nuevo Trámite' }}
    </h1>

    <div class="bg-white rounded shadow p-6">
      <form @submit.prevent="enviar">

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Código</label>
          <input v-model="form.codigo" type="text" :disabled="esEdicion"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100" />
          <span v-if="errores.codigo" class="text-red-500 text-xs">{{ errores.codigo[0] }}</span>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
          <input v-model="form.nombre" type="text"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <span v-if="errores.nombre" class="text-red-500 text-xs">{{ errores.nombre[0] }}</span>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
          <textarea v-model="form.descripcion" rows="3"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Institución</label>
          <select v-model="form.institucion_id"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Seleccione una institución</option>
            <option v-for="inst in instituciones" :key="inst.id" :value="inst.id">
              {{ inst.nombre }}
            </option>
          </select>
          <span v-if="errores.institucion_id" class="text-red-500 text-xs">{{ errores.institucion_id[0] }}</span>
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Días Hábiles</label>
          <input v-model="form.dias_habiles" type="number" min="1"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <span v-if="errores.dias_habiles" class="text-red-500 text-xs">{{ errores.dias_habiles[0] }}</span>
        </div>

        <!-- Mensaje éxito -->
        <div v-if="exito" class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
          {{ exito }}
        </div>

        <!-- Mensaje error -->
        <div v-if="errorGeneral" class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">
          {{ errorGeneral }}
        </div>

        <div class="flex gap-3">
          <button type="submit" :disabled="enviando"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
            {{ enviando ? 'Guardando...' : 'Guardar' }}
          </button>
          <router-link to="/"
            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
            Cancelar
          </router-link>
        </div>

      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../plugins/axios.js'

const route = useRoute()
const router = useRouter()

const esEdicion = computed(() => !!route.params.id)

const form = ref({ codigo: '', nombre: '', descripcion: '', institucion_id: '', dias_habiles: '' })
const instituciones = ref([])
const errores = ref({})
const exito = ref('')
const errorGeneral = ref('')
const enviando = ref(false)

const cargarInstituciones = async () => {
  const { data } = await api.get('/instituciones')
  instituciones.value = data.data
}

const cargarTramite = async () => {
  const { data } = await api.get(`/tramites/${route.params.id}`)
  const t = data.data
  form.value = {
    codigo: t.codigo,
    nombre: t.nombre,
    descripcion: t.descripcion,
    institucion_id: t.institucion?.id,
    dias_habiles: t.dias_habiles
  }
}

const enviar = async () => {
  enviando.value = true
  errores.value = {}
  exito.value = ''
  errorGeneral.value = ''
  try {
    if (esEdicion.value) {
      await api.put(`/tramites/${route.params.id}`, form.value)
      exito.value = 'Trámite actualizado correctamente'
    } else {
      await api.post('/tramites', form.value)
      exito.value = 'Trámite creado correctamente'
      setTimeout(() => router.push('/'), 1500)
    }
  } catch (e) {
    if (e.response?.status === 422) {
      errores.value = e.response.data.errors
    } else {
      errorGeneral.value = 'Error al guardar el trámite'
    }
  } finally {
    enviando.value = false
  }
}

onMounted(() => {
  cargarInstituciones()
  if (esEdicion.value) cargarTramite()
})
</script>