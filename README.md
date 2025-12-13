📌 Descripción general

Proyecto E-commerce desarrollado con Laravel (API REST) y Angular (SPA).
El sistema permite la gestión y consulta de productos mediante un catálogo paginado por cursor, autenticación con JWT, carrito de compras y órdenes.

El frontend consume la API backend mediante HTTP y se comunica usando tokens JWT.

🧱 Arquitectura del proyecto
Project-Ecommerce/
├── app/                    # Laravel (backend API)
├── config/
├── database/
├── public/
├── routes/
├── resources/
│   └── frontend/           # Angular (frontend SPA)
│          ├── src/
│          ├── angular.json
│          └── package.json
├── .env
├── composer.json
└── README.md

🛠 Tecnologías utilizadas
Backend

PHP 8.x

Laravel 12

PostgreSQL 17

JWT (autenticación)

API REST

Frontend

Angular 18

TypeScript

SCSS / Tailwind CSS (opcional)

Angular CLI

📋 Requisitos previos

Antes de instalar el proyecto, asegúrate de tener:

PHP >= 8.2

Composer

Node.js >= 18

npm

PostgreSQL >= 17

Angular CLI (npm install -g @angular/cli)

Git