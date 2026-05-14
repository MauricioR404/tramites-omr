<template>
  <div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nueva Institución</h1>

    <div class="bg-white rounded shadow p-6">
      <form @submit.prevent="enviar">

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
          <input v-model="form.nombre" type="text"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <span v-if="errores.nombre" class="text-red-500 text-xs">{{ errores.nombre[0] }}</span>
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
          <select v-model="form.tipo"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Seleccione un tipo</option>
            <option value="MINISTERIO">Ministerio</option>
            <option value="ALCALDIA">Alcaldía</option>
            <option value="AUTONOMA">Autónoma</option>
          </select>
          <span v-if="errores.tipo" class="text-red-500 text-xs">{{ errores.tipo[0] }}</span>
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
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../plugins/axios.js'

const router = useRouter()

const form = ref({ nombre: '', tipo: '' })
const errores = ref({})
const exito = ref('')
const errorGeneral = ref('')
const enviando = ref(false)

const enviar = async () => {
  enviando.value = true
  errores.value = {}
  exito.value = ''
  errorGeneral.value = ''
  try {
    await api.post('/instituciones', form.value)
    exito.value = 'Institución creada correctamente'
    form.value = { nombre: '', tipo: '' }
    setTimeout(() => router.push('/'), 1500)
  } catch (e) {
    if (e.response?.status === 422) {
      errores.value = e.response.data.errors
    } else {
      errorGeneral.value = 'Error al guardar la institución'
    }
  } finally {
    enviando.value = false
  }
}
</script>