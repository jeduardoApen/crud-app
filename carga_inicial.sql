CREATE TABLE
    `crud_app`.roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL UNIQUE,
        descripcion TEXT,
        nivel_privilegio INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    `crud_app`.usuarios (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100) UNIQUE,
        `nombres` VARCHAR(100),
        `apellidos` VARCHAR(100),
        `rol_id` INT NOT NULL,
        `activa` CHAR(1) DEFAULT 'A',
        `ultimo_acceso` TIMESTAMP NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`rol_id`) REFERENCES roles (`id`) ON DELETE RESTRICT
    );

CREATE table
    `crud_app`.sesiones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        fecha_fin TIMESTAMP NULL,
        activa BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
    );

-- Tabla de logs
CREATE table
    `crud_app`.logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NULL,
        accion VARCHAR(200) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE SET NULL
    );

-- Insertar roles
INSERT INTO
    roles (nombre, descripcion, nivel_privilegio)
VALUES
    ('Admin', 'Control total del sistema', 3),
    ('Consulta', 'Acceso solo lectura a datos', 2),
    ('Ingreso', 'Acceso limitado al login', 1);

--Usuarios
INSERT INTO
    usuarios (
        username,
        password,
        email,
        nombres,
        apellidos,
        rol_id,
        activa,
        ultimo_acceso
    )
VALUES
    (
        'emorales',
        'clave123',
        'elena.morales@email.com',
        'Elena',
        'Morales',
        1,
        'A',
        NULL
    ),
    (
        'rjimenez',
        'pass456',
        'raul.jimenez@email.com',
        'Raúl',
        'Jiménez',
        2,
        'A',
        NULL
    ),
    (
        'sflores',
        'admin2024',
        'silvia.flores@email.com',
        'Silvia',
        'Flores',
        1,
        'B',
        NULL
    ),
    (
        'arojas',
        'acceso1',
        'andres.rojas@email.com',
        'Andrés',
        'Rojas',
        3,
        'A',
        NULL
    ),
    (
        'pnavarro',
        'nav123',
        'patricia.navarro@email.com',
        'Patricia',
        'Navarro',
        2,
        'B',
        NULL
    ),
    (
        'gcastro',
        'castro456',
        'gabriel.castro@email.com',
        'Gabriel',
        'Castro',
        1,
        'A',
        NULL
    ),
    (
        'mruiz',
        'ruiz789',
        'monica.ruiz@email.com',
        'Mónica',
        'Ruiz',
        3,
        'A',
        NULL
    ),
    (
        'fvargas',
        'vargas321',
        'fernando.vargas@email.com',
        'Fernando',
        'Vargas',
        2,
        'B',
        NULL
    ),
    (
        'lmendoza',
        'mendoza999',
        'laura.mendoza@email.com',
        'Laura',
        'Mendoza',
        1,
        'A',
        NULL
    ),
    (
        'icabrera',
        'cabrera777',
        'ivan.cabrera@email.com',
        'Iván',
        'Cabrera',
        2,
        'B',
        NULL
    );