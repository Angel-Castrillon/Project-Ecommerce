## 1. Objetivo

Diseñar y documentar el **modelo de datos de productos** para el módulo de catálogo del E-commerce, garantizando compatibilidad con:

- API REST desarrollada en Laravel 12
- ORM Eloquent
- PostgreSQL 17
- Catálogo paginado por **cursor** (no por COUNT)
- Filtros y ordenamiento
- CRUD de productos
- Campos de auditoría
- Eliminación lógica (soft delete)

> Este documento es **solo para diseño y documentación**.

---

## 2. Entidad Principal: `products`

### 2.1 Descripción general

La tabla `products` almacena la información base de los productos disponibles en el sistema.  
Está diseñada para ser consultada frecuentemente por el catálogo, por lo que prioriza:

- Ordenamientos estables
- Índices eficientes
- Compatibilidad con cursor pagination

---

## 3. Estructura de la tabla `products`

### 3.1 Campos

| Campo | Tipo (PostgreSQL) | Obligatorio | Descripción |
|------|-------------------|------------|-------------|
| `id` | `bigserial` (PK) | Sí | Identificador único incremental. Ideal para cursor pagination |
| `sku` | `varchar(64)` | No | Código único del producto |
| `name` | `varchar(180)` | Sí | Nombre del producto |
| `slug` | `varchar(200)` | Sí | Identificador URL-friendly y único |
| `description` | `text` | No | Descripción detallada del producto |
| `price` | `numeric(12,2)` | Sí | Precio del producto |
| `stock` | `integer` | Sí | Cantidad disponible en inventario |
| `is_active` | `boolean` | Sí | Indica si el producto es visible en el catálogo |
| `category_id` | `bigint` (FK) | No | Relación con categorías (opcional) |
| `created_by` | `bigint` (FK) | No | Usuario que creó el registro |
| `updated_by` | `bigint` (FK) | No | Usuario que modificó el registro |
| `deleted_by` | `bigint` (FK) | No | Usuario que eliminó lógicamente el registro |
| `created_at` | `timestamp` | Sí | Fecha de creación |
| `updated_at` | `timestamp` | Sí | Fecha de actualización |
| `deleted_at` | `timestamp` | No | Eliminación lógica (soft delete) |

---

## 4. Reglas y Restricciones

### 4.1 Unicidad
- `sku` debe ser único.
- `slug` debe ser único para evitar conflictos en URLs.

### 4.2 Validaciones a nivel base de datos
- `price >= 0`
- `stock >= 0`

### 4.3 Eliminación lógica
- La eliminación de productos se maneja mediante `deleted_at`.
- No se eliminan registros físicamente para conservar historial y auditoría.

---

## 5. Índices y Performance

El catálogo debe ser rápido y escalable, especialmente al usar cursor pagination.

### 5.1 Índices principales

- Clave primaria automática: `(id)`
- `(is_active, id)` → catálogo activo paginado
- `(category_id, id)` → filtro por categoría
- `(price, id)` → filtro y ordenamiento por precio
- `(created_at, id)` → ordenamiento por fecha

### 5.2 Búsqueda
- Índice único en `sku`
- Índice en `name` para búsquedas simples

---

## 6. Catálogo de Productos (POST)

### 6.1 Filtros soportados

- `search` → búsqueda por nombre (y opcionalmente por SKU)
- `category_id`
- `min_price`
- `max_price`
- `is_active`
- `in_stock` (stock > 0)

### 6.2 Ordenamiento permitido

- `id`
- `created_at`
- `price`
- `name`

### 6.3 Cursor Pagination

- El catálogo utiliza **cursor pagination**.
- No se realizan consultas `COUNT(*)`.
- El ordenamiento debe ser **estable**.

Ejemplos válidos:
- `ORDER BY id ASC`
- `ORDER BY price ASC, id ASC`
- `ORDER BY created_at DESC, id DESC`

El campo `id` se utiliza como **tie-breaker** para evitar duplicados o saltos entre páginas.

---

## 7. Relaciones

### 7.1 Categorías
- `products.category_id` → `categories.id`
- Permite filtros por categoría.

### 7.2 Usuarios (auditoría)
- `created_by`, `updated_by`, `deleted_by` → `users.id`
- Recomendado `ON DELETE SET NULL` para no perder historial si un usuario se desactiva.

---

## 8. Criterios de Aceptación – T-05

- [x] Modelo de datos documentado
- [x] Campos definidos con tipos y reglas
- [x] Índices orientados a catálogo y cursor pagination
- [x] Auditoría incluida
- [x] Sin implementación de código (solo diseño)

---

## 9. Nota Final

Este documento actúa como **fuente de verdad** para la implementación técnica del módulo de productos.  
Cualquier cambio futuro en migraciones o modelos debe estar alineado con este diseño o reflejarse en una actualización del documento.