<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
materno_infantil
├─ .editorconfig
├─ app
│  ├─ Http
│  │  └─ Controllers
│  │     ├─ Controller.php
│  │     ├─ LoginController.php
│  │     └─ UsuarioController.php
│  ├─ Models
│  │  └─ User.php
│  └─ Providers
│     └─ AppServiceProvider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ permission.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  └─ 2025_09_29_050210_create_permission_tables.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     └─ UserSeeder.php
├─ middleware('permission
├─ middleware('role
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  └─ bootstrap.js
│  └─ views
│     ├─ auth
│     │  └─ login.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ barra-lateral.blade.php
│     │  └─ cabecera.blade.php
│     ├─ usuarios
│     │  ├─ create.blade.php
│     │  └─ index.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10fc56e2cc979335478a7198abdc7c46.php
│  │     ├─ 1514db3e60cb902058878108ac3c33b0.php
│  │     ├─ 1bcaf3752a783e03d039fda69e69309b.php
│  │     ├─ 1d0cb51c719e333cf506ea1cf9ab11fc.php
│  │     ├─ 1dd8fc5998702d939003dca2c61442eb.php
│  │     ├─ 1f8b41343afcc088c3356f18abd79a47.php
│  │     ├─ 20cd95a627b52794a42d61448a51b979.php
│  │     ├─ 224cadbe374d5f5df2d5ed4f7fb54739.php
│  │     ├─ 22b2c5f1e98abf4b209bd6a0262a982f.php
│  │     ├─ 28770f051c2a849e69a2d7d084398c64.php
│  │     ├─ 2b95ffea677cd78d3d3f2def0fbb14ca.php
│  │     ├─ 2f9bb8f15b015e5ceae4662edd1629bc.php
│  │     ├─ 305ae57cf8b5c783fff089bb32caacc3.php
│  │     ├─ 414f1701a9c6ff3eb84eb1035e627528.php
│  │     ├─ 4387a56882271bfb45c985f738ca8fc7.php
│  │     ├─ 462bb8799e767404beda7e653f8403d1.php
│  │     ├─ 4dca87a3f44f66b67dfa910b1d82c5e3.php
│  │     ├─ 4f1e3baf43920270ad3eb29c2897a512.php
│  │     ├─ 4fbf27c9321cddda15be08dfe0b2b2ba.php
│  │     ├─ 55914053d5114313932e15666aaab453.php
│  │     ├─ 627026c976b5ac3f860d79ed4d9d608d.php
│  │     ├─ 6765bbae7430596ffc9e163e81a6eb41.php
│  │     ├─ 6b1db0e0f1af6839f147df38269a029c.php
│  │     ├─ 8a92b2174f8be3cee34935867f4e9b72.php
│  │     ├─ 8ad648c947b1331fc01a1088bc8e1967.php
│  │     ├─ 909293bced5d263b1f3fdaea3fb5cb33.php
│  │     ├─ 99343d8e94df1fad7c19c0d65a86d08d.php
│  │     ├─ 9fa45b706e65a2aaf71efed391085a7c.php
│  │     ├─ a47a5ffb2ac69267a0288e6bb0b3e077.php
│  │     ├─ a532b193188235b4a78df01360840a1d.php
│  │     ├─ b57f2477c75a7d768cb00967086386d0.php
│  │     ├─ bbb267696607d52341c9f847ea6a029b.php
│  │     ├─ c13595c4556a8cccfd905a2b4522d882.php
│  │     ├─ ce289de77a93e62107639914b92f05d4.php
│  │     ├─ d8d0c10651325688d78d6a568e9b6ff5.php
│  │     ├─ df3d558aa57076a48c32dc28397ae2e7.php
│  │     ├─ e3a096ba5b0f0db8c0679d9f96da6fcd.php
│  │     ├─ e598391bfb66139252b9a8cba5ca2e9b.php
│  │     ├─ e5da2d50b519947f674b121a40492ef8.php
│  │     ├─ e74e9eba682cc27fc4117510d315c3a3.php
│  │     ├─ e9aff1fae3901d6890f0319cc1ec3452.php
│  │     ├─ eba08070fbda759e4c9099e54d40b6b2.php
│  │     ├─ ec3250e61d3a8cfe0e34cd544a86d06c.php
│  │     ├─ ed6bde42a1dae7a77ef1ab7e9aed927f.php
│  │     ├─ f50182cf76bca2bfb63e022a45e9530a.php
│  │     ├─ f590ae4f4c4641ec4d6d4ae35b9c4e81.php
│  │     └─ fb0aa786dc6a954e07d2c070624fa960.php
│  └─ logs
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```
```
materno_infantil
├─ .editorconfig
├─ app
│  ├─ Http
│  │  └─ Controllers
│  │     ├─ Controller.php
│  │     ├─ LoginController.php
│  │     ├─ PacienteController.php
│  │     └─ UsuarioController.php
│  ├─ Models
│  │  ├─ Paciente.php
│  │  ├─ Seguimiento.php
│  │  ├─ Tutor.php
│  │  └─ User.php
│  └─ Providers
│     └─ AppServiceProvider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ permission.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2025_09_29_050210_create_permission_tables.php
│  │  ├─ 2025_10_06_052732_crear_tabla_tutores.php
│  │  ├─ 2025_10_06_065144_crear_tabla_pacientes.php
│  │  └─ 2025_10_08_055643_create_seguimientos_table.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     └─ UserSeeder.php
├─ middleware('permission
├─ middleware('role
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  ├─ app.css
│  │  ├─ pacientes.css
│  │  └─ usuarios.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  └─ pacientes.js
│  └─ views
│     ├─ auth
│     │  └─ login.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  └─ barra-lateral.blade.php
│     ├─ pacientes
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ usuarios
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10fc56e2cc979335478a7198abdc7c46.php
│  │     ├─ 1514db3e60cb902058878108ac3c33b0.php
│  │     ├─ 1bcaf3752a783e03d039fda69e69309b.php
│  │     ├─ 1d0cb51c719e333cf506ea1cf9ab11fc.php
│  │     ├─ 1dd8fc5998702d939003dca2c61442eb.php
│  │     ├─ 1f8b41343afcc088c3356f18abd79a47.php
│  │     ├─ 20cd95a627b52794a42d61448a51b979.php
│  │     ├─ 224cadbe374d5f5df2d5ed4f7fb54739.php
│  │     ├─ 22b2c5f1e98abf4b209bd6a0262a982f.php
│  │     ├─ 28770f051c2a849e69a2d7d084398c64.php
│  │     ├─ 2b95ffea677cd78d3d3f2def0fbb14ca.php
│  │     ├─ 2ea1e885e53980f15d014c338a89b280.php
│  │     ├─ 2f9bb8f15b015e5ceae4662edd1629bc.php
│  │     ├─ 305ae57cf8b5c783fff089bb32caacc3.php
│  │     ├─ 32d5df0422ea3a14e6ecc9b06d9c9cfe.php
│  │     ├─ 414f1701a9c6ff3eb84eb1035e627528.php
│  │     ├─ 4387a56882271bfb45c985f738ca8fc7.php
│  │     ├─ 439fec72b8f1272733207b984ab80de8.php
│  │     ├─ 4449a4130976f45ad3d5104252190a91.php
│  │     ├─ 462bb8799e767404beda7e653f8403d1.php
│  │     ├─ 4dca87a3f44f66b67dfa910b1d82c5e3.php
│  │     ├─ 4f1e3baf43920270ad3eb29c2897a512.php
│  │     ├─ 4fbf27c9321cddda15be08dfe0b2b2ba.php
│  │     ├─ 55914053d5114313932e15666aaab453.php
│  │     ├─ 627026c976b5ac3f860d79ed4d9d608d.php
│  │     ├─ 6765bbae7430596ffc9e163e81a6eb41.php
│  │     ├─ 6b1db0e0f1af6839f147df38269a029c.php
│  │     ├─ 71a23cc83b7438b594805a523379a418.php
│  │     ├─ 74f73fe0144d7a3a1d315acaee4450d7.php
│  │     ├─ 8a92b2174f8be3cee34935867f4e9b72.php
│  │     ├─ 8ad648c947b1331fc01a1088bc8e1967.php
│  │     ├─ 909293bced5d263b1f3fdaea3fb5cb33.php
│  │     ├─ 91719c240dacb0283f0b2a89ac7d45ac.php
│  │     ├─ 9306d0f255f88e087f7043d9f3ab6e7c.php
│  │     ├─ 99343d8e94df1fad7c19c0d65a86d08d.php
│  │     ├─ 9f2837143dd8e1baac0ea8fde0f1b3c9.php
│  │     ├─ 9fa45b706e65a2aaf71efed391085a7c.php
│  │     ├─ a0a007fd290e86336c61e2550ecd6d21.php
│  │     ├─ a47a5ffb2ac69267a0288e6bb0b3e077.php
│  │     ├─ a532b193188235b4a78df01360840a1d.php
│  │     ├─ af112a591fe0f3d445dcad87f1158008.php
│  │     ├─ b018599cdc06e19da7ff0c5a5f70fa0f.php
│  │     ├─ b57f2477c75a7d768cb00967086386d0.php
│  │     ├─ bbb267696607d52341c9f847ea6a029b.php
│  │     ├─ c13595c4556a8cccfd905a2b4522d882.php
│  │     ├─ ce289de77a93e62107639914b92f05d4.php
│  │     ├─ d8d0c10651325688d78d6a568e9b6ff5.php
│  │     ├─ df3d558aa57076a48c32dc28397ae2e7.php
│  │     ├─ e3a096ba5b0f0db8c0679d9f96da6fcd.php
│  │     ├─ e598391bfb66139252b9a8cba5ca2e9b.php
│  │     ├─ e5da2d50b519947f674b121a40492ef8.php
│  │     ├─ e74e9eba682cc27fc4117510d315c3a3.php
│  │     ├─ e9aff1fae3901d6890f0319cc1ec3452.php
│  │     ├─ eba08070fbda759e4c9099e54d40b6b2.php
│  │     ├─ ec3250e61d3a8cfe0e34cd544a86d06c.php
│  │     ├─ ed6bde42a1dae7a77ef1ab7e9aed927f.php
│  │     ├─ f50182cf76bca2bfb63e022a45e9530a.php
│  │     ├─ f590ae4f4c4641ec4d6d4ae35b9c4e81.php
│  │     ├─ fa749779640e005dd7b1f2a04152bf22.php
│  │     └─ fb0aa786dc6a954e07d2c070624fa960.php
│  └─ logs
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```
```
materno_infantil
├─ .editorconfig
├─ app
│  ├─ Http
│  │  └─ Controllers
│  │     ├─ Controller.php
│  │     ├─ LoginController.php
│  │     ├─ MedidaController.php
│  │     ├─ MoleculaCaloricaController.php
│  │     ├─ PacienteController.php
│  │     ├─ SeguimientoController.php
│  │     └─ UsuarioController.php
│  ├─ Models
│  │  ├─ Evaluacion.php
│  │  ├─ FrisanchoRef.php
│  │  ├─ Medida.php
│  │  ├─ MoleculaCalorica.php
│  │  ├─ OmsRef.php
│  │  ├─ Paciente.php
│  │  ├─ Tutor.php
│  │  └─ User.php
│  └─ Providers
│     └─ AppServiceProvider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ permission.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2025_09_29_050210_create_permission_tables.php
│  │  ├─ 2025_10_06_052732_crear_tabla_tutores.php
│  │  ├─ 2025_10_06_065144_crear_tabla_pacientes.php
│  │  ├─ 2025_10_08_055643_create_seguimientos_table.php
│  │  ├─ 2025_10_20_013001_create_oms_ref_table.php
│  │  ├─ 2025_10_20_013002_create_frisancho_ref_table.php
│  │  ├─ 2025_10_20_013003_create_medidas_table.php
│  │  ├─ 2025_10_20_013004_create_evaluaciones_table.php
│  │  └─ 2025_10_22_065639_create_molecula_calorica_table.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     └─ UserSeeder.php
├─ middleware('permission
├─ middleware('role
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  ├─ app.css
│  │  ├─ pacientes.css
│  │  └─ usuarios.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  └─ pacientes.js
│  └─ views
│     ├─ auth
│     │  └─ login.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  └─ barra-lateral.blade.php
│     ├─ medidas
│     │  ├─ calculos.blade.php
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ molecula_calorica
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ pacientes
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ seguimientos
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  ├─ partials
│     │  │  ├─ form-seguimiento.blade.php
│     │  │  ├─ linea-tiempo.blade.php
│     │  │  └─ tabla-seguimientos.blade.php
│     │  └─ show.blade.php
│     ├─ usuarios
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10fc56e2cc979335478a7198abdc7c46.php
│  │     ├─ 1514db3e60cb902058878108ac3c33b0.php
│  │     ├─ 1bcaf3752a783e03d039fda69e69309b.php
│  │     ├─ 1d0cb51c719e333cf506ea1cf9ab11fc.php
│  │     ├─ 1dd8fc5998702d939003dca2c61442eb.php
│  │     ├─ 1f8b41343afcc088c3356f18abd79a47.php
│  │     ├─ 20cd95a627b52794a42d61448a51b979.php
│  │     ├─ 224cadbe374d5f5df2d5ed4f7fb54739.php
│  │     ├─ 22b2c5f1e98abf4b209bd6a0262a982f.php
│  │     ├─ 282f68d918db3969ca8e702bea8454bb.php
│  │     ├─ 28770f051c2a849e69a2d7d084398c64.php
│  │     ├─ 2b95ffea677cd78d3d3f2def0fbb14ca.php
│  │     ├─ 2ea1e885e53980f15d014c338a89b280.php
│  │     ├─ 2f9bb8f15b015e5ceae4662edd1629bc.php
│  │     ├─ 305ae57cf8b5c783fff089bb32caacc3.php
│  │     ├─ 32d5df0422ea3a14e6ecc9b06d9c9cfe.php
│  │     ├─ 3368b44422bbae4af6b41a5331d31588.php
│  │     ├─ 414f1701a9c6ff3eb84eb1035e627528.php
│  │     ├─ 4387a56882271bfb45c985f738ca8fc7.php
│  │     ├─ 439fec72b8f1272733207b984ab80de8.php
│  │     ├─ 4449a4130976f45ad3d5104252190a91.php
│  │     ├─ 462bb8799e767404beda7e653f8403d1.php
│  │     ├─ 4d49a8e487c7a4d4421ee198a4adfd10.php
│  │     ├─ 4dca87a3f44f66b67dfa910b1d82c5e3.php
│  │     ├─ 4f1e3baf43920270ad3eb29c2897a512.php
│  │     ├─ 4fbf27c9321cddda15be08dfe0b2b2ba.php
│  │     ├─ 55914053d5114313932e15666aaab453.php
│  │     ├─ 5d50f65ec267f55bd3accc88ffa88d14.php
│  │     ├─ 627026c976b5ac3f860d79ed4d9d608d.php
│  │     ├─ 6765bbae7430596ffc9e163e81a6eb41.php
│  │     ├─ 6b1db0e0f1af6839f147df38269a029c.php
│  │     ├─ 6ee7db10b2bc4c3286f280225025ad57.php
│  │     ├─ 71a23cc83b7438b594805a523379a418.php
│  │     ├─ 74f73fe0144d7a3a1d315acaee4450d7.php
│  │     ├─ 854e806d815c0911eaf21eb37e7ef299.php
│  │     ├─ 8a92b2174f8be3cee34935867f4e9b72.php
│  │     ├─ 8ad648c947b1331fc01a1088bc8e1967.php
│  │     ├─ 909293bced5d263b1f3fdaea3fb5cb33.php
│  │     ├─ 91719c240dacb0283f0b2a89ac7d45ac.php
│  │     ├─ 9306d0f255f88e087f7043d9f3ab6e7c.php
│  │     ├─ 98c24394fe9b4b5c85684e6595da9d6d.php
│  │     ├─ 99343d8e94df1fad7c19c0d65a86d08d.php
│  │     ├─ 9f2837143dd8e1baac0ea8fde0f1b3c9.php
│  │     ├─ 9fa45b706e65a2aaf71efed391085a7c.php
│  │     ├─ a0a007fd290e86336c61e2550ecd6d21.php
│  │     ├─ a47a5ffb2ac69267a0288e6bb0b3e077.php
│  │     ├─ a532b193188235b4a78df01360840a1d.php
│  │     ├─ aa5c688cd7eefe796f963e4f659979fa.php
│  │     ├─ af112a591fe0f3d445dcad87f1158008.php
│  │     ├─ b018599cdc06e19da7ff0c5a5f70fa0f.php
│  │     ├─ b57f2477c75a7d768cb00967086386d0.php
│  │     ├─ bbb267696607d52341c9f847ea6a029b.php
│  │     ├─ bcedeea149823f17d67999a93df96a1d.php
│  │     ├─ c13595c4556a8cccfd905a2b4522d882.php
│  │     ├─ cc6b89f9d8591ff898a12c7d99dec38f.php
│  │     ├─ ce289de77a93e62107639914b92f05d4.php
│  │     ├─ ce352bd5d177e11780fa7ee8b898f046.php
│  │     ├─ d45e669dc0bb940644f2817b1be08e63.php
│  │     ├─ d8d0c10651325688d78d6a568e9b6ff5.php
│  │     ├─ df3d558aa57076a48c32dc28397ae2e7.php
│  │     ├─ e3a096ba5b0f0db8c0679d9f96da6fcd.php
│  │     ├─ e4d48b768135dbe4963fd5c114b48ea8.php
│  │     ├─ e598391bfb66139252b9a8cba5ca2e9b.php
│  │     ├─ e5da2d50b519947f674b121a40492ef8.php
│  │     ├─ e74e9eba682cc27fc4117510d315c3a3.php
│  │     ├─ e9aff1fae3901d6890f0319cc1ec3452.php
│  │     ├─ eba08070fbda759e4c9099e54d40b6b2.php
│  │     ├─ ec3250e61d3a8cfe0e34cd544a86d06c.php
│  │     ├─ ed6bde42a1dae7a77ef1ab7e9aed927f.php
│  │     ├─ f50182cf76bca2bfb63e022a45e9530a.php
│  │     ├─ f590ae4f4c4641ec4d6d4ae35b9c4e81.php
│  │     ├─ fa749779640e005dd7b1f2a04152bf22.php
│  │     └─ fb0aa786dc6a954e07d2c070624fa960.php
│  └─ logs
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```
```
materno_infantil
├─ .editorconfig
├─ app
│  ├─ Http
│  │  └─ Controllers
│  │     ├─ Controller.php
│  │     ├─ LoginController.php
│  │     ├─ MedidaController.php
│  │     ├─ MoleculaCaloricaController.php
│  │     ├─ PacienteController.php
│  │     ├─ RequerimientoNutricionalController.php
│  │     ├─ SeguimientoController.php
│  │     └─ UsuarioController.php
│  ├─ Models
│  │  ├─ Evaluacion.php
│  │  ├─ FrisanchoRef.php
│  │  ├─ Medida.php
│  │  ├─ MoleculaCalorica.php
│  │  ├─ OmsRef.php
│  │  ├─ Paciente.php
│  │  ├─ RequerimientoNutricional.php
│  │  ├─ Tutor.php
│  │  └─ User.php
│  └─ Providers
│     └─ AppServiceProvider.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ permission.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2025_09_29_050210_create_permission_tables.php
│  │  ├─ 2025_10_06_052732_crear_tabla_tutores.php
│  │  ├─ 2025_10_06_065144_crear_tabla_pacientes.php
│  │  ├─ 2025_10_08_055643_create_seguimientos_table.php
│  │  ├─ 2025_10_20_013001_create_oms_ref_table.php
│  │  ├─ 2025_10_20_013002_create_frisancho_ref_table.php
│  │  ├─ 2025_10_20_013003_create_medidas_table.php
│  │  ├─ 2025_10_20_013004_create_evaluaciones_table.php
│  │  ├─ 2025_10_22_065639_create_molecula_calorica_table.php
│  │  └─ 2025_10_24_074402_create_requerimientos_nutricionales_table.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     └─ UserSeeder.php
├─ middleware('permission
├─ middleware('role
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  ├─ app.css
│  │  ├─ pacientes.css
│  │  └─ usuarios.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  └─ pacientes.js
│  └─ views
│     ├─ auth
│     │  └─ login.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  └─ barra-lateral.blade.php
│     ├─ medidas
│     │  ├─ calculos.blade.php
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ moleculaCalorica
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ pacientes
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ requerimiento_nutricional
│     │  ├─ create.blade.php
│     │  └─ index.blade.php
│     ├─ seguimientos
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  ├─ partials
│     │  │  ├─ form-seguimiento.blade.php
│     │  │  ├─ linea-tiempo.blade.php
│     │  │  └─ tabla-seguimientos.blade.php
│     │  └─ show.blade.php
│     ├─ usuarios
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 10fc56e2cc979335478a7198abdc7c46.php
│  │     ├─ 1514db3e60cb902058878108ac3c33b0.php
│  │     ├─ 1bcaf3752a783e03d039fda69e69309b.php
│  │     ├─ 1d0cb51c719e333cf506ea1cf9ab11fc.php
│  │     ├─ 1dd8fc5998702d939003dca2c61442eb.php
│  │     ├─ 1f8b41343afcc088c3356f18abd79a47.php
│  │     ├─ 20cd95a627b52794a42d61448a51b979.php
│  │     ├─ 224cadbe374d5f5df2d5ed4f7fb54739.php
│  │     ├─ 22b2c5f1e98abf4b209bd6a0262a982f.php
│  │     ├─ 282f68d918db3969ca8e702bea8454bb.php
│  │     ├─ 28770f051c2a849e69a2d7d084398c64.php
│  │     ├─ 2b95ffea677cd78d3d3f2def0fbb14ca.php
│  │     ├─ 2ea1e885e53980f15d014c338a89b280.php
│  │     ├─ 2f9bb8f15b015e5ceae4662edd1629bc.php
│  │     ├─ 305ae57cf8b5c783fff089bb32caacc3.php
│  │     ├─ 32d5df0422ea3a14e6ecc9b06d9c9cfe.php
│  │     ├─ 3368b44422bbae4af6b41a5331d31588.php
│  │     ├─ 414f1701a9c6ff3eb84eb1035e627528.php
│  │     ├─ 4387a56882271bfb45c985f738ca8fc7.php
│  │     ├─ 439fec72b8f1272733207b984ab80de8.php
│  │     ├─ 4449a4130976f45ad3d5104252190a91.php
│  │     ├─ 462bb8799e767404beda7e653f8403d1.php
│  │     ├─ 4d49a8e487c7a4d4421ee198a4adfd10.php
│  │     ├─ 4dca87a3f44f66b67dfa910b1d82c5e3.php
│  │     ├─ 4f1e3baf43920270ad3eb29c2897a512.php
│  │     ├─ 4fbf27c9321cddda15be08dfe0b2b2ba.php
│  │     ├─ 55914053d5114313932e15666aaab453.php
│  │     ├─ 5c419f640e9f4ce29569fb1c725b2f5f.php
│  │     ├─ 5d50f65ec267f55bd3accc88ffa88d14.php
│  │     ├─ 627026c976b5ac3f860d79ed4d9d608d.php
│  │     ├─ 6765bbae7430596ffc9e163e81a6eb41.php
│  │     ├─ 6b1db0e0f1af6839f147df38269a029c.php
│  │     ├─ 6ee7db10b2bc4c3286f280225025ad57.php
│  │     ├─ 71a23cc83b7438b594805a523379a418.php
│  │     ├─ 74f73fe0144d7a3a1d315acaee4450d7.php
│  │     ├─ 854e806d815c0911eaf21eb37e7ef299.php
│  │     ├─ 8a92b2174f8be3cee34935867f4e9b72.php
│  │     ├─ 8ad648c947b1331fc01a1088bc8e1967.php
│  │     ├─ 909293bced5d263b1f3fdaea3fb5cb33.php
│  │     ├─ 91719c240dacb0283f0b2a89ac7d45ac.php
│  │     ├─ 9306d0f255f88e087f7043d9f3ab6e7c.php
│  │     ├─ 98c24394fe9b4b5c85684e6595da9d6d.php
│  │     ├─ 99343d8e94df1fad7c19c0d65a86d08d.php
│  │     ├─ 9f2837143dd8e1baac0ea8fde0f1b3c9.php
│  │     ├─ 9fa45b706e65a2aaf71efed391085a7c.php
│  │     ├─ a0a007fd290e86336c61e2550ecd6d21.php
│  │     ├─ a47a5ffb2ac69267a0288e6bb0b3e077.php
│  │     ├─ a532b193188235b4a78df01360840a1d.php
│  │     ├─ aa5c688cd7eefe796f963e4f659979fa.php
│  │     ├─ af112a591fe0f3d445dcad87f1158008.php
│  │     ├─ b018599cdc06e19da7ff0c5a5f70fa0f.php
│  │     ├─ b0d5e7190f413670bc34f9b2d0a9d693.php
│  │     ├─ b57f2477c75a7d768cb00967086386d0.php
│  │     ├─ bbb267696607d52341c9f847ea6a029b.php
│  │     ├─ bcedeea149823f17d67999a93df96a1d.php
│  │     ├─ c13595c4556a8cccfd905a2b4522d882.php
│  │     ├─ cc6b89f9d8591ff898a12c7d99dec38f.php
│  │     ├─ ce289de77a93e62107639914b92f05d4.php
│  │     ├─ ce352bd5d177e11780fa7ee8b898f046.php
│  │     ├─ d45e669dc0bb940644f2817b1be08e63.php
│  │     ├─ d8d0c10651325688d78d6a568e9b6ff5.php
│  │     ├─ df3d558aa57076a48c32dc28397ae2e7.php
│  │     ├─ e3a096ba5b0f0db8c0679d9f96da6fcd.php
│  │     ├─ e4d48b768135dbe4963fd5c114b48ea8.php
│  │     ├─ e598391bfb66139252b9a8cba5ca2e9b.php
│  │     ├─ e5da2d50b519947f674b121a40492ef8.php
│  │     ├─ e74e9eba682cc27fc4117510d315c3a3.php
│  │     ├─ e9aff1fae3901d6890f0319cc1ec3452.php
│  │     ├─ eba08070fbda759e4c9099e54d40b6b2.php
│  │     ├─ ec3250e61d3a8cfe0e34cd544a86d06c.php
│  │     ├─ ed6bde42a1dae7a77ef1ab7e9aed927f.php
│  │     ├─ f50182cf76bca2bfb63e022a45e9530a.php
│  │     ├─ f590ae4f4c4641ec4d6d4ae35b9c4e81.php
│  │     ├─ fa749779640e005dd7b1f2a04152bf22.php
│  │     └─ fb0aa786dc6a954e07d2c070624fa960.php
│  └─ logs
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```