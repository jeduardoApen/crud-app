# 🐳 Sistema de Autenticación con Docker

Sistema distribuido con autenticación de usuarios, manejo de privilegios (Admin/Consulta/Ingreso) y replicación MySQL maestro-esclavo.

## 🚀 Inicio Rápido

### Requisitos
- Docker & Docker Compose
- Git

### Instalación

```bash
# 1. Clonar repositorio
git clone https://github.com/tu-usuario/crud-php.git
cd crud-php/proyecto

# 2. Levantar contenedores
docker-compose up -d

# 3. Verificar estado
docker ps

```

## Servicios

| Servicio             | URL / Puerto         | Credenciales            |
|---------------------|---------------------|-------------------------|
| Aplicación Web      | http://localhost:8080 | -                       |
| MySQL (Principal)   | localhost:3307       | root / tu_contraseña    |
| MySQL (Respaldo)    | interno              | -                       |

## Usuarios de prueba

- **Admin**
  - Usuario: `admin`
  - Contraseña: `admin123`
  - Permisos: Control total

- **Consulta**
  - Usuario: `consulta1`
  - Contraseña: `cons123`
  - Permisos: Solo lectura

- **Ingreso**
  - Usuario: `ingreso1`
  - Contraseña: `ing123`
  - Permisos: Acceso básico

---

## Estructura del Proyecto

```
proyecto/
├── docker-compose.yml      # Configuración de contenedores
├── carga_inicial.sql       # Base de datos y datos iniciales
├── index.php               # Página principal
├── login.php               # Autenticación
├── dashboard.php           # Panel principal
├── usuarios.php            # CRUD usuarios (solo Admin)
├── conexion.php            # Conexión a BD
 ── auth.php                # Lógica de autenticación

```


## 🐳 Contenedores Docker

| Contenedor           | Función                | Puerto Host |
|---------------------|------------------------|-------------|
| mi-web              | PHP 8.3 + Apache       | 8080        |
| mi-mysql            | MySQL Maestro          | 3307        |
| mi-mysql-respaldo   | MySQL Esclavo          | -           |



## Comandos útiles

```bash
# Ver logs
docker-compose logs -f

# Reiniciar servicios
docker-compose restart

# Acceder a contenedor
docker exec -it mi-web bash

# Probar conexión PHP → MySQL
docker exec mi-web ping mi-mysql
```

## Niveles de Privilegio

| Rol      | Nivel | Permisos                         |
|----------|--------|----------------------------------|
| Admin    | 3      | CRUD completo de usuarios        |
| Consulta | 2      | Solo visualización de datos      |
| Ingreso  | 1      | Acceso básico al sistema         |

## Funcionalidades

- ✅ Autenticación segura  
- ✅ Control de sesiones  
- ✅ Registro de logs de actividad  
- ✅ Panel diferenciado por rol  
- ✅ CRUD de usuarios (solo Admin)  
- ✅ Replicación MySQL maestro-esclavo  

## 🛠️ Tecnologías

- **Backend:** PHP 8.3  
- **DB:** MySQL 8.0 (Replicación)  
- **Container:** Docker + Docker Compose  
- **Server:** Apache  


## Base de datos

```

┌─────────────────┐         ┌─────────────────┐
│      roles      │         │    usuarios     │
├─────────────────┤         ├─────────────────┤
│ id (PK)         │◄─────── │ id (PK)         │
│ nombre          │         │ username        │
│ descripcion     │         │ password        │
│ nivel_privilegio│         │ email           │
│ created_at      │         │ nombres         │
└─────────────────┘         │ apellidos       │
                            │ rol_id (FK)     │
                            │ activa          │
                            │ ultimo_acceso   │
                            │ created_at      │
                            └────────┬────────┘
                                     │
                          ┌──────────┴──────────┐
                          │                     │
                  ┌───────▼───────┐     ┌───────▼───────┐
                  │   sesiones    │     │     logs      │
                  ├───────────────┤     ├───────────────┤
                  │ id (PK)       │     │ id (PK)       │
                  │ usuario_id(FK)│     │ usuario_id(FK)│
                  │ fecha_inicio  │     │ accion        │
                  │ fecha_fin     │     │ created_at    │
                  │ activa        │     └───────────────┘
                  └───────────────┘

```

