<template>
    <div class="show-evaluation container">
        <div class="row content-header" v-if="loading" style="height: 100vh">
            <div class="col-md-12 text-center">
                <p>
                    <i class="fas fa-spinner fa-pulse fa-4x"></i>
                </p>
                <p class="h4">Cargando...</p>
            </div>
        </div>
        <div v-else>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/home">Grupos</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    <router-link :to="`/group/${$route.params.group}`">{{ group.name }}</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    <router-link :to="`/group/${$route.params.group}/${$route.params.user}`">{{ beneficiary.folio }}</router-link>
                                </li>
                                <li class="breadcrumb-item active">Evaluación</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center font-weight-bold text-uppercase">
                        Evaluación YTT
                    </h2>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">
                                Información general
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Persona beneficiaria</label>
                                        <p>
                                            {{ beneficiary.folio  }}
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label>Herramienta</label>
                                        <p>
                                            {{ group.evaluation  }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Grupo</label>
                                        <p>
                                            {{ group.name  }}
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha de creación</label>
                                        <p>
                                            {{ evaluation.created_at | myDate  }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">
                                Respuestas
                            </p>
                        </div>
                        <div class="card-body">
                            <span class="d-none">{{ getEvaluation.created_at }}</span>
                            <div class="list-group">
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Bajo rendimiento escolar</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Contexto escolar</h5>
                                    <h5>
                                        <span class="badge badge-success" v-if="evaluation.answer1 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer1 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer1 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer1 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information1 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Ausencia de una figura parental</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer2 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer2 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer2 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer2 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information2 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Escasa habilidad de educar de los padres</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Estilos de crianza</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer3 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer3 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer3 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer3 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information3 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Rechazo de grupo de iguales</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Exposición de violencia en el hogar</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer4 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer4 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer4 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer4 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information4 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Desorganización comunitaria</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Criminalidad de los padres/cuidador</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer5 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer5 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer5 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer5 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information5 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Falta de Apoyo Personal / Social de otros adultos</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Inseguridad comunitaria</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer6 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer6 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer6 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer6 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information6 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Exposición a la violencia en el hogar</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Apoyo social percibido</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer7 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer7 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer7 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer7 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information7 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Historia de Maltrato en la niñez</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Historia de Maltrato en la niñez</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer8 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer8 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer8 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer8 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information8 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Bajo cumplimiento de metas o acuerdos</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Cumplimiento de metas o acuerdos</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer9 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer9 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer9 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer9 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information9 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Los déficits de atención / hiperactividad</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Inatención / hiperactividad</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer10 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer10 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer10 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer10 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information10 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Estrés/ incapacidad para enfrentar dificultades</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Actitudes hacia la violencia.</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer11 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer11 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer11 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer11 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information11 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Actitudes negativas</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Empatía / remordimiento</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer12 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer12 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer12 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer12 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information12 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Baja empatía / remordimiento</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Comportamiento impulsivo</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer13 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer13 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer13 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer13 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information13 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Comportamiento impulsivo</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Manejo del enojo</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer14 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer14 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer14 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer14 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information14 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Problemas con el manejo del enfado</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Delincuencia en grupo de iguales</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer15 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer15 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer15 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer15 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information15 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Delincuencia en grupo de iguales</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Iniciación temprana en la violencia</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer16 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer16 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer16 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer16 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information16 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Iniciación temprana en la violencia</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Violencia física interpersonal</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer17 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer17 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer17 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer17 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information17 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Violencia Previa</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Historia de actos delictivos no violentos</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer18 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer18 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer18 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer18 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information18 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Historia de actos delictivos no violentos</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Problemas con la ley</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer19 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer19 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer19 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer19 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information19 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv1'">Antecedentes de medidas judiciales</h5>
                                    <h5 class="mb-1" v-show="evaluation_selected == 'yttv2'">Dificultades por el uso de sustancias</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer20 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer20 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer20 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer20 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information20 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action" v-if="evaluation_selected == 'yttv1'">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Dificultades por el uso de sustancias</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer21 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer21 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer21 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer21 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information21 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action" v-if="evaluation_selected == 'yttv1'">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Historia de las autolesiones o intentos de suicidio</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer22 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer22 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer22 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer22 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information22 }}</p>
                                </a>
                                <a href="" class="list-group-item list-group-item-action" v-if="evaluation_selected == 'yttv1'">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Criminalidad de los padres / cuidador</h5>
                                    <h5 class="text-muted">
                                        <span class="badge badge-success" v-if="evaluation.answer23 == 0">Bajo</span>
                                        <span class="badge badge-warning" v-else-if="evaluation.answer23 == 1">Medio</span>
                                        <span class="badge badge-danger" v-else-if="evaluation.answer23 == 2">Alto</span>
                                        <span class="badge badge-dark" v-else-if="evaluation.answer23 == 3">Crítico</span>
                                        <span class="badge badge-secondary" v-else>Sin respuesta</span>
                                    </h5>
                                    </div>
                                    <p class="mb-1">{{ evaluation.information23 }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mb-3" name="button" @click.prevent="printme">
                Imprimir
                <i class="fas fa-print"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            loading: false,
            evaluation_selected: '',
            beneficiary: {},
            group: {},
            evaluation: {},
        }),
        methods: {
            printme(){
                window.print();
            },
            loadBeneficiary(){
                this.loading = true;
                axios.get('/api/beneficiary_by_folio/'+this.$route.params.user).then(({data}) => (
                    this.beneficiary = data,
                    this.group = data.group,
                    this.evaluation_selected = data.group.evaluation,
                    this.loading = false
                )).catch(()=>{
                    this.loading = false;
                });
            },
        },
        computed:{
            getEvaluation: function () {
                if(this.evaluation_selected == 'yttv1') 
                    this.evaluation = this.beneficiary.ytt1_evaluations.find(
                        evaluation => evaluation.id == this.$route.params.id
                    );
                else if (this.evaluation_selected == 'yttv2')
                    this.evaluation = this.beneficiary.ytt2_evaluations.find(
                        evaluation => evaluation.id == this.$route.params.id
                    );
                return this.evaluation
            }
        },
        created(){
            this.loadBeneficiary();
        }
    }
</script>

<style lang="scss" scoped>

</style>