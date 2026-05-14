# Prueba Técnica — Desarrollador Fullstack
**Organismo de Mejora Regulatoria (OMR) — El Salvador**

---

## Descripción

Sistema web para el registro y consulta de Trámites Administrativos. Permite gestionar instituciones y trámites a través de una API REST consumida por una interfaz Vue.js.

---

## Tecnologías utilizadas

### Backend
- **PHP 8.2**
- **Laravel 10** — Framework principal
- **SQLite** — Base de datos en archivo local
- **Eloquent ORM** — Manejo de modelos y relaciones
- **Laravel Form Requests** — Validaciones
- **Laravel JsonResource** — Formateo de respuestas JSON

### Frontend
- **Vue.js 3** — Framework de interfaz
- **Vite** — Bundler y servidor de desarrollo
- **Vue Router 4** — Navegación entre vistas
- **Axios** — Cliente HTTP para consumir la API
- **Tailwind CSS 3** — Estilos y diseño

---

## Estructura del repositorio

```
tramites-omr/
├── tramites-api/          ← Backend Laravel 10
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Requests/
│   │   │   └── Resources/
│   │   ├── Models/
│   │   └── Services/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/
│   └── README.md
├── tramites-app/          ← Frontend Vue.js 3
│   ├── src/
│   │   ├── plugins/
│   │   ├── router/
│   │   └── views/
│   ├── package.json
│   └── README.md
└── README.md
```

---

## Instrucciones para correr el proyecto

### Backend — tramites-api

```bash
cd tramites-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

> La API quedará disponible en: `http://localhost:8000`

### Frontend — tramites-app

```bash
cd tramites-app
npm install
npm run dev
```

> La app quedará disponible en: `http://localhost:5173`

---

## Endpoints disponibles

| Método | Endpoint            | Descripción                          |
|--------|---------------------|--------------------------------------|
| GET    | /api/instituciones  | Listar instituciones activas         |
| POST   | /api/instituciones  | Crear nueva institución              |
| GET    | /api/tramites       | Listar trámites paginados con filtro |
| GET    | /api/tramites/{id}  | Obtener detalle de un trámite        |
| POST   | /api/tramites       | Crear nuevo trámite                  |
| PUT    | /api/tramites/{id}  | Actualizar trámite existente         |
| DELETE | /api/tramites/{id}  | Desactivar trámite (soft delete)     |

---

## Tiempo invertido por módulo

| Módulo                                                                                           | Tiempo        |
|--------------------------------------------------------------------------------------------------|---------------|
| Backend — Laravel (modelos, migraciones, seeders, servicios, controladores, rutas, validaciones) | ~6 horas      |
| Frontend — Vue.js (configuración, vistas, router, axios, estilos)                                | ~7 horas      |
| Configuración general, pruebas y ajustes                                                         | ~1 hora       |
| **Total**                                                                                        | **~14 horas** |

---

## Decisiones técnicas

### Backend

- **SQLite sobre MySQL/PostgreSQL:** Se eligió SQLite para simplificar la configuración y permitir que el proyecto arranque sin dependencias externas, tal como lo requiere la prueba.

- **Arquitectura Controller → Service:** Se separó la lógica de negocio en una capa de Services para mantener los controladores delgados y el código más mantenible y testeable.

- **Form Requests para validaciones:** Se usaron Form Requests de Laravel para centralizar y separar las reglas de validación del controlador, siguiendo las buenas prácticas del framework.

- **JsonResource para respuestas:** Todas las respuestas usan Resources de Laravel para garantizar una estructura JSON consistente y desacoplar el modelo de la respuesta HTTP.

- **Soft delete manual con campo `activo`:** En lugar de usar `SoftDeletes` de Laravel, se implementó un campo booleano `activo` según lo especificado en el documento, donde el DELETE desactiva el registro en vez de eliminarlo.

- **`whenLoaded` en TramiteResource:** Se usó `whenLoaded('institucion')` para cargar la relación solo cuando fue solicitada explícitamente, evitando el problema N+1.

### Frontend

- **Vue.js 3 con Composition API:** Se eligió Vue 3 con `<script setup>` por ser la versión más moderna y por la preferencia personal con la Composition API, que ofrece mejor organización del código.

- **Vite como bundler:** Se usó Vite por su velocidad de desarrollo y compatibilidad nativa con Vue 3.

- **Tailwind CSS:** Se eligió Tailwind por su utilidad para construir interfaces limpias y responsivas rápidamente sin necesidad de escribir CSS personalizado.

- **Axios centralizado:** Se configuró una instancia de Axios con `baseURL` fija en `src/plugins/axios.js` para evitar repetir la URL base en cada petición y facilitar cambios futuros.

- **Vue Router con rutas reutilizables:** La vista `RegistroTramite.vue` se reutiliza tanto para crear como para editar un trámite, detectando si hay un `id` en la ruta para determinar el modo.

---

## Flujo principal validado

1. Crear una institución desde **Nueva Institución**
2. Registrar un trámite asociado desde **Nuevo Trámite**
3. Consultar el trámite en el listado usando el filtro por institución
