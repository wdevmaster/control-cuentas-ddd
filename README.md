Proyecto Laravel para Fintech  

Este proyecto fue desarrollado para abordar una prueba técnica, diseñado específicamente para un sistema financiero (**fintech**). La estructura del sistema fue concebida bajo la metodología **Domain-Driven Design (DDD)**, lo cual garantiza escalabilidad, legibilidad del código y facilita la integración de nuevas funcionalidades.  

A continuación, se presentan los detalles del proyecto, pasos básicos de instalación y ejecución, así como la implementación de estrategias **CI/CD** para un despliegue eficiente y continuo.  

---

### **Descripción del Proyecto**  

El proyecto tiene como objetivo gestionar dos módulos principales:  
- **Cuentas**: Responsable de administrar la información de cuentas bancarias.  
- **Transacciones**: Encargado de procesar y registrar las transacciones relacionadas con las cuentas.  

Dado el tamaño reducido del sistema en esta etapa inicial, ambos módulos fueron desarrollados dentro del mismo proyecto Laravel en lugar de separar la lógica en microservicios. Sin embargo, se siguieron prácticas que facilitan la futura transición hacia una arquitectura basada en microservicios, si el sistema requiere escalabilidad en el futuro.  

#### **Decisiones Técnicas**  
- **Metodología DDD**: La estructura se alinea con las sugerencias de DDD, incorporando una separación clara entre los dominios.  
- **Pruebas Abstraídas**: Las pruebas se encuentran dentro del contexto de cada módulo, permitiendo una migración más sencilla hacia microservicios independientes en el futuro.  
- **Estructura Vertical**: Se adoptó una estructura de carpetas que permite mantener una lógica modular y autónoma por cada dominio.  

---

### **Requisitos Previos**  
- PHP >= 8.1  
- Composer >= 2.0  
- Laravel >= 10.x  
- MySQL >= 8.0  
---

### **Pasos de Instalación**  

1. **Instalar Dependencias de Composer**  
   ```bash
   composer install
   ```

2. **Configurar Variables de Entorno**  
   - Duplicar el archivo `.env.example` y renombrarlo a `.env`.  
   - Configurar las variables de entorno, como la conexión a la base de datos:  
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=tu_base_de_datos
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
     ```
    > Recuerde que esta credenciales debe ser las misma del entorno docker.
3. **Generar la Clave de la Aplicación**  
   ```bash
   php artisan key:generate
   ```

4. **Ejecutar las Migraciones**  
   ```bash
   php artisan migrate
   ```

5. **(Opcional) Sembrar Datos de Prueba**  
   Si es necesario, puedes poblar la base de datos con datos iniciales:  
   ```bash
   php artisan db:seed
   ```

   Por defecto, la aplicación estará disponible en:  
   [http://127.0.0.1:8000](http://127.0.0.1:8000)  

---

### **Estrategias CI/CD**  

Para garantizar una integración continua y un despliegue eficiente, el proyecto utiliza herramientas de **CI/CD** que facilitan la implementación de nuevas funcionalidades:  

- **GitHubActions de CI/CD**: Configurado para realizar pruebas unitarias y de integración en cada `push` o `pull request` a ramas principales.  
- **Deploy Automático**: El sistema se despliega automáticamente en un entorno staging o producción, minimizando el tiempo de entrega.  

#### **Ejemplo de Flujo CI/CD**  
1. Validación del código y pruebas en el pipeline.  
2. Construcción de contenedores Docker (opcional).  
3. Implementación automática en el servidor destino.  

---

### **Estructura del Proyecto**  

La estructura principal del proyecto sigue las buenas prácticas de **DDD** y está organizada de la siguiente forma:  

```
src/
├── Context/
│   ├── Accounts/
│   │   ├── Domain/
│   │   ├── Application/
│   │   ├── Infrastructure/
│   │   └── Tests/
│   └── Transaction/
│       ├── Domain/
│       ├── Application/
│       ├── Infrastructure/
│       └── Tests/
└── ...
```

Esta estructura asegura una clara separación de responsabilidades, lo que facilita la migración a microservicios si es necesario.  

---

### **Conclusión**  

Este proyecto está diseñado con la escalabilidad en mente, siguiendo principios de diseño robustos y estrategias modernas de CI/CD. Su modularidad permite la fácil implementación de nuevas funcionalidades y la transición futura a una arquitectura distribuida.  
