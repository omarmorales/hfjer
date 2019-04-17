# Herramienta YTT: herramienta de focalización de Jóvenes en Riesgo
[![version](https://img.shields.io/badge/versi%C3%B3n-1.0.0--alpha-blue.svg)](https://semver.org)

Juntos para la Prevención de la Violencia (JPV) es un programa de la Agencia de los Estados Unidos para el Desarrollo Internacional (USAID) en México que persigue el objetivo central de construir capacidades en los distintos niveles de gobierno, organizaciones de la sociedad y sector privado para el diseño, implementación y evaluación de intervenciones de prevención de la violencia y el crimen basadas en evidencia, de forma que éstas puedan ser replicadas y escaladas en el contexto
mexicano.
Ante un contexto adverso para la juventud, esta población es la más afectada por el crimen y la violencia, por tanto, surge la necesidad de implementar planes, acciones, programas y modelos de intervención que por un lado, identifiquen el nivel de riesgo en el que se encuentra este tipo de población, valorando por una parte el grado de exposición a la violencia y criminalidad de la comunidad o residencia donde se desenvuelven y, por el otro, mejorar los esfuerzos para disminuir los comportamientos violentos que aumentan la probabilidad a generar actos violentos o delictivos de esas personas.
Desde el punto de vista de la prevención de la violencia que se genera en la juventud, la función de la prevención requiere enfocarse en generar condiciones que permitan disminuir el nivel de riesgo, disminuir los efectos de la exposición a la violencia y el crimen, además de la disminución de los comportamientos de riesgo que pueden generar mayor probabilidad de que a un adolescente o
joven cometa un acto violento o un delito.
De esta forma, la herramienta de focalización de jóvenes en riesgo busca crear un proceso en el que las y los actores locales obtengan información para tener mayor claridad del nivel de riesgo de las personas jóvenes con las que se encuentran trabajando en la implementación de modelos de prevención.

## :black_nib: Lenguajes de programación utilizados

* PHP para el backend de la aplicación, utilizando el framework de código abierto para desarrollar aplicaciones y servicios web Laravel en su versión más reciente al 22 de marzo de 2019 5.7
* Javascript para el frontend de la aplicación, utilizando el marco de código abierto para crear interfaces de usuario y aplicaciones de una sola página Vue.js


## :computer: Instalación local de la aplicación

* `cd ` dentro del folder del proyecto.
* Correr ` composer install `
* Crear archivo `.env` a partir del archivo `.env.example` y agregar información de base de datos local.
* Correr ` php artisan key:generate` para generar api key
* Correr ` npm install ` o  ` yarn install `
* Correr ` php artisan migrate ` para migrar los modelos de la base de datos.
* Correr ` php artisan db:seed ` para agregar datos de los seeders a base de datos local
* Correr ` php artisan passport:install ` para instalar las llaves de passport

## 📦 Paquetes o dependencias utilizadas

* [axios](https://github.com/axios/axios)
* [boostrap](https://getbootstrap.com/docs/4.0/getting-started/introduction/)
* [cross-env](https://www.npmjs.com/package/cross-env)
* [jquery](https://jquery.com/)
* [laravel-mix](https://laravel.com/docs/5.8/mix)
* [lodash](https://lodash.com/)
* [popper.js](https://popper.js.org/index.html)
* [vue](https://vuejs.org/)
* [fontawesome](https://fontawesome.com/)
* [admin-lte](https://adminlte.io/themes/dev/AdminLTE/index.html)
* [laravel-vue-pagination](https://github.com/gilbitron/laravel-vue-pagination)
* [moment](https://momentjs.com/)
* [sweetalert2](https://sweetalert2.github.io/)
* [vform](https://github.com/cretueusebiu/vform)
* [vue-multiselect](https://vue-multiselect.js.org/)
* [vue-progressbar](https://github.com/hilongjw/vue-progressbar)
* [vue-router](https://router.vuejs.org/)
* [vue-i18n](http://kazupon.github.io/vue-i18n/)
* [laravel-passport](https://laravel.com/docs/5.8/passport)
* [laravel-excel](https://laravel-excel.com/)
