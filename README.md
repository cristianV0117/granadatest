# 🌍 GranadaTest Backend - Laravel + GraphQL - Cristian Vasquez

Backend para el reto técnico FullStack de **Granada SAS**, desarrollado en **Laravel 12 (Sail)** con **PHP 8.4**, arquitectura limpia, patrón repository + use cases, integración de **GraphQL** y comunicación con una base de datos PostgreSQL alojada en **Railway**.

---

## 📦 Tecnologías usadas

- **Laravel 12.x** (con Laravel Sail)
- **PHP 8.4**
- **GraphQL (rebing/graphql-laravel)**
- **Docker (Laravel Sail)**
- **PostgreSQL (Railway)**
- **Patrón Repository + Casos de Uso + DTOs**
- **Principios SOLID**
- **PSR-4**
- **GitHub Actions (CI/CD)**

---

## ⚙️ Funcionalidad

### 🎯 Endpoints GraphQL

- `getTopCountries(limit: Int!)`:  
  Retorna dinámicamente los países con mayor densidad demográfica (`population / area`) consumiendo datos en tiempo real desde `https://restcountries.com/v3.1/all`.

- `getLogs(start_date: String, end_date: String)`:  
  Lista los logs históricos de uso filtrados por rango de fechas.

- `storeLog(input: LogInput!)`:  
  Guarda un nuevo log de consulta (automático desde el frontend).

- `updateLog(id: ID!, username: String!)`:  
  Permite editar el nombre de usuario en un log existente.

- `deleteLog(id: ID!)`:  
  Elimina un log por su ID.

---

## 🧱 Arquitectura

Implementación basada en principios SOLID y Clean Architecture:

## 🚀 Despliegue

### 🌐 Producción
- Frontend desplegado en: [https://granadatest-production.up.railway.app/graphql](https://granadatestfront-production.up.railway.app)
- Se comunica con el frontend angular mediante GraphQL alojado en Railway.


- Separación clara entre infraestructura y dominio.
- Uso de DTOs para entrada/salida de datos.
- Fácil extensión o reemplazo del motor de base de datos gracias al uso de interfaces y repositorios.

---

## 🗃 Base de Datos

- Motor: **PostgreSQL**
- Servicio: **Railway**
- Tabla: `logs`

| Campo                  | Tipo       | Descripción                                |
|------------------------|------------|--------------------------------------------|
| id                     | UUID       | Identificador único                        |
| username               | string     | Nombre del usuario que hizo la consulta    |
| request_timestamp      | timestamp  | Fecha y hora de la petición                |
| num_countries_returned | int        | Número de países retornados                |
| countries_details      | json       | Detalle de países con densidad calculada   |

---

## 🐳 Instalación y desarrollo local con Sail

```bash
# Clona el proyecto
git clone https://github.com/[TU_USUARIO]/granadatest-back.git
cd granadatest-back

# Copia las variables
cp .env.example .env

# Levanta el entorno
./vendor/bin/sail up -d

# Instala dependencias
./vendor/bin/sail composer install

# Ejecuta migraciones
./vendor/bin/sail artisan migrate

# Opcional: prueba el endpoint GraphQL
http://localhost/graphql

