<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-blue-700 text-white px-6 py-4 shadow">
      <div class="max-w-6xl mx-auto flex items-center justify-between">
        <span class="font-bold text-lg">OMR — Trámites</span>
        <div class="flex gap-4">
          <router-link to="/" class="hover:underline">Trámites</router-link>
          <router-link to="/tramites/crear" class="hover:underline">Nuevo Trámite</router-link>
          <router-link to="/instituciones/crear" class="hover:underline">Nueva Institución</router-link>
        </div>
      </div>
    </nav>
    <main class="max-w-6xl mx-auto py-8 px-4">
      <router-view />
    </main>
  </div>
</template>