<template lang="html">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <router-link to="/home">Grupos</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="`/group/${$route.params.group}`">{{ $route.params.group }}</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="`/group/${$route.params.group}/${$route.params.user}`">{{ $route.params.user }}</router-link>
              </li>
              <li class="breadcrumb-item active">Nueva toma</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center font-weight-bolder text-uppercase">
          Nueva toma
        </h2>
      </div>
      <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Grupo</label>
                <input class="form-control" disabled v-model="group_selected.name" type="text">
              </div>
              <div class="form-group">
                <label for="">Herramienta</label>
                <input class="form-control" type="text" :value="group_selected.evaluation" disabled>
              </div>
              <div class="form-group">
                <label for="">Persona beneficiaria</label>
                <input class="form-control" disabled v-model="beneficiary_selected.name + ' ' + beneficiary_selected.lastname_one" type="text">
              </div>
              <div class="form-group">
                <label for="">Edad actual</label>
                <input class="form-control" disabled v-model="beneficiary_age" type="text">
              </div>
              <div class="form-group" v-if="beneficiary_selected != null">
                <label for="">Número de toma</label>
                <input class="form-control" type="number" :value="beneficiary_selected.ytt1_evaluations.length +1" v-if="group_selected.evaluation == 'yttv1'" disabled>
                <input class="form-control" type="number" :value="beneficiary_selected.ytt2_evaluations.length +1" v-if="group_selected.evaluation == 'yttv2'" disabled>
              </div>
            </div>
          </div>
          <div class="row" v-if="group_selected.evaluation == 'yttv1'">
            <form @submit.prevent="draftmode ?  createYtt1Draft() : createYtt1Evaluation()">
            <div class="col-md-12">
              <div class="card" v-for="(item, index) in yttv1_questionnarie">
                <div class="card-header">
                  {{ item.question_title }}
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="card" style="height:100%;">
                        <div class="card-body">
                          <p class="font-weight-bold">Preguntas guía</p>
                          <ul style="padding:0;">
                            <li v-for="guide_question in item.guide_questions" class="mb-0" style="list-style-type: none;">{{ guide_question }}</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card bg-secondary" style="height:100%;">
                        <div class="card-body">
                          <ul style="padding:0;">
                            <li v-for="explanation_risk_level in item.explanation_risk_levels" class="mb-0" style="list-style-type: none;"><i class="fas fa-dot-circle fa-xs"></i> {{ explanation_risk_level }}</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Respuestas / Información</label>
                        <textarea class="form-control" v-model="formYTTv1[item.information_slug]"></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Nivel de riesgo</label><br>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio1'+item.answer_slug" value="0" v-model="formYTTv1[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio1'+item.answer_slug">Bajo</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio2'+item.answer_slug" value="1" v-model="formYTTv1[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio2'+item.answer_slug">Medio</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio3'+item.answer_slug" value="2" v-model="formYTTv1[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio3'+item.answer_slug">Alto</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio4'+item.answer_slug" value="3" v-model="formYTTv1[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio4'+item.answer_slug">Crítico</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <button v-show="group" type="submit" class="btn btn-secondary mb-4" @click="saveAsDraft">
                Guardar borrador
              </button>
              <button v-show="group" type="submit" class="btn btn-primary mb-4" @click="saveEvaluation">
                Guardar evaluación
              </button>
            </div>
            </form>
          </div>
          <div class="row" v-if="group_selected.evaluation == 'yttv2'">
            <form @submit.prevent="draftmode ?  createYtt2Draft() : createYtt2Evaluation()">
            <div class="col-md-12">
              <div class="card" v-for="(item, index) in yttv2_questionnarie">
                <div class="card-header">
                  {{ item.question_title }}
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="card" style="height:100%;">
                        <div class="card-body">
                          <p class="font-weight-bold">Preguntas guía</p>
                          <ul style="padding:0;">
                            <li v-for="guide_question in item.guide_questions" class="mb-0" style="list-style-type: none;">{{ guide_question }}</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card bg-secondary" style="height:100%;">
                        <div class="card-body">
                          <ul style="padding:0;">
                            <li v-for="explanation_risk_level in item.explanation_risk_levels" class="mb-0" style="list-style-type: none;"><i class="fas fa-dot-circle fa-xs"></i> {{ explanation_risk_level }}</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Respuestas / Información</label>
                        <textarea class="form-control" v-model="formYTTv2[item.information_slug]"></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Nivel de riesgo</label><br>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio1'+item.answer_slug" value="0" v-model="formYTTv2[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio1'+item.answer_slug">Bajo</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio2'+item.answer_slug" value="1" v-model="formYTTv2[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio2'+item.answer_slug">Medio</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio3'+item.answer_slug" value="2" v-model="formYTTv2[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio3'+item.answer_slug">Alto</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" :name="'inlineRadioOptions'+item.answer_slug" :id="'inlineRadio4'+item.answer_slug" value="3" v-model="formYTTv2[item.answer_slug]">
                          <label class="form-check-label" :for="'inlineRadio4'+item.answer_slug">Crítico</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <button v-show="group" type="submit" class="btn btn-secondary mb-4" @click="saveAsDraft">
                Guardar borrador
              </button>
              <button v-show="group" type="submit" class="btn btn-primary mb-4" @click="saveEvaluation">Guardar evaluación</button>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['age'],
  data(){
    return {
      draftmode: false,
      yttv1_questionnarie:[
        {
          question_title:'Bajo rendimiento escolar',
          answer_slug: 'answer1',
          information_slug: 'information1',
          guide_questions: [
            '¿Sigues estudiando actualmente?',
            '¿En qué año escolar te quedaste?',
            '¿En tu último grado escolar cuantas materias reprobaste?',
            '¿Cuál era tu promedio el año anterior antes de dejar la escuela?',
            '¿Cuántas veces citaron a tus padres a la escuela por algún problema relacionado con tu comportamiento?',
            '¿Cuántas veces te han suspendido y/o expulsado?',
          ],
          explanation_risk_levels: [
            'Bajo si no tuvo o ha tenido dificultades significativas de rendimiento escolar.',
            'Moderado si ha experimentado algunas dificultades educativas por ejemplo bajas calificaciones, pero no reprobó algún grado escolar.',
            'Alto si tiene un historial de haber reprobado y repetido algún grado escolar.',
            'Crítico si además de haber repetido algunos grados fueron expulsados por “mal comportamiento”.'
          ]
        },
        {
          question_title:'Ausencia de una figura parental',
          answer_slug: 'answer2',
          information_slug: 'information2',
          guide_questions: [
            'Durante tu niñez, ¿vivieron juntos tus padres?',
            'Si no vivieron juntos, ¿sabes porque motivos se separaron?',
            '¿Cuántos años tenías cuando se separaron?',
            '¿Con quién viviste al momento de la separación?',
            '¿Cuánto tiempo viviste con ellos?',
          ],
          explanation_risk_levels: [
            'Bajo  si no hubo interrupción en la atención de los padres durante toda la infancia.',
            'Moderado si no hubo interrupción en la atención de alguno de los padres durante toda la infancia.',
            'Alto si existió discontinuidad en la atención de los padres por algunos periodos cortos de tiempo.',
            'Crítico si pasaron un tiempo significativo (es decir, 1 año o más) Bajo los cuidados de otras personas durante la infancia.'
          ]
        },
        {
          question_title:'Escasa habilidad de educar de los padres',
          answer_slug: 'answer3',
          information_slug: 'information3',
          guide_questions: [
            'Cuándo tus padres te piden que hagas algo, ¿qué haces?',
            'Si no haces lo que te piden, ¿qué sucede?',
            'En tu casa, ¿existen reglas claras que tus padres han puesto?',
            '¿Con qué frecuencia comparten la mesa para comer o celebrar?',
            '¿Con qué frecuencia te comunicas con tus padres?',
            'Cuando quieres salir con tus amigos, ¿a quién le pides permiso?',
            '¿Hasta qué hora tienes permiso de llegar en la noche a tu hogar?',
            'Si no llegas en la hora permitida, ¿qué sucede?',
          ],
          explanation_risk_levels: [
            'Bajo cuando el joven está siendo educado por sus padres o tutores en una disciplina consistente, con supervisión e implicación adecuada.',
            'Moderado si la disciplina a veces es inconsistente y la supervisión poco fiable.',
            'Alto si la disciplina es altamente inconsistente, siendo o muy permisiva o muy estricta.',
            'Crítico si la supervisión de los padres o tutores en todo momento está siendo basada en el castigo, incluso físico, y/o ausencia total de supervisión.'
          ]
        },
        {
          question_title:'Rechazo de grupo de iguales',
          answer_slug: 'answer4',
          information_slug: 'information4',
          guide_questions: [
            '¿Recuerdas si cuando eras niño tus amigos te molestaban?',
            '¿Qué hacías cuando esto sucedía?',
            'Actualmente, ¿con cuántos amigos te juntas?',
            '¿En ocasiones te sientes rechazado por ellos?',
            '¿En algún momento sientes que ellos te hacen demasiadas bromas?',
            '¿Te sientes agredido con sus bromas?',
            '¿Les comentas que sus bromas no son de tu agrado?'
          ],
          explanation_risk_levels: [
            'Bajo si no tuvo experiencia y no está experimentando actualmente rechazo de parte de sus amigos ni emite comentarios negativos acerca de las bromas de sus amigos.',
            'Moderado si está experimentando algún tipo de rechazo de parte de sus amigos o comenta que actualmente recibe bromas molestas de sus amigos.',
            'Alto si está experimentando actualmente importante rechazo de parte de sus amigos y ha experimentado un rechazo significativo de sus amigos la mayor parte de su infancia y adolescencia, o comenta que actualmente y durante su infancia ha recibido bromas molestas de sus amigos.',
            'Crítico si el rechazo que recibe de parte de sus amigos y/o las bromas que recibe son graves o crónicas al grado de no querer encontrarse con ellos.'
          ]
        },
        {
          question_title:'Desorganización comunitaria',
          answer_slug: 'answer5',
          information_slug: 'information5',
          guide_questions: [
            'La comunidad donde vives, ¿qué tan peligrosa es?',
            '¿Qué tipo de delitos se cometen?',
            '¿Existen peleas o riñas en las calles?',
            '¿Qué tan seguido suceden estas cosas?',
            '¿Qué tan a menudo eres testigo de esos hechos?',
            '¿Te sientes seguro en tu colonia?',
            '¿Te gustaría irte a vivir a otro lado?'
          ],
          explanation_risk_levels: [
            'Bajo si vive en una comunidad con bajos índices de delincuencia y violencia.',
            'Moderado si vive en una comunidad con algunos problemas relacionados a mayores tasas de delincuencia y/o violencia.',
            'Alto si vive en una comunidad con problemas significativos relativos a los altos índices de delincuencia y/o violencia.',
            'Crítico si la comunidad donde vive está considerada como de muy altos índices delictivos y violentos.'
          ]
        },
        {
          question_title:'Falta de Apoyo Personal / Social de otros adultos',
          answer_slug: 'answer6',
          information_slug: 'information6',
          guide_questions: [
            'Cuándo te sientes mal, triste, enfermo, emocionado, ¿tienes a quién acudir para pedir su apoyo?',
            'Cuando acudes a esa persona, ¿tiene tiempo para platicar contigo?',
            '¿Te aconseja y te sugiere qué puedes hacer?',
            '¿Cada cuánto tiempo visitas a esa persona para platicar?',
            '¿Siempre que la visitas te atiende?',
            '¿A qué se dedica esa persona?',
          ],
          explanation_risk_levels: [
            'Bajo si familia, cuidadores y/u otros adultos están disponibles y dispuestos a ofrecer apoyo emocional y orientación',
            'Moderado en ocasiones cuenta con familiares, cuidadores y/u otros adultos dispuestos a ofrecer apoyo emocional y orientación.',
            'Alto si el poco apoyo con el que cuenta, es incoherente y, a veces, poco fiable.',
            'Crítico si no cuenta con personas o algún familiar disponible y/o dispuesto a ofrecer apoyo emocional y orientación.'
          ]
        },
        {
          question_title:'Exposición a la violencia en el hogar',
          answer_slug: 'answer7',
          information_slug: 'information7',
          guide_questions: [
            '¿En alguna ocasión fuiste testigo de gritos, empujones, golpes, lanzamiento de objetos dónde vives?',
            '¿Entre quiénes ocurrió?',
            '¿Cuántas veces has sido testigo de estas situaciones?',
            '¿En esa ocasión hubo agresión física que requirió atención médica?',
          ],
          explanation_risk_levels: [
            'Bajo si no ha sido testigo de violencia en el hogar.',
            'Moderado si ha sido testigo de la agresión física ocasional y/o un solo acto de violencia en el hogar.',
            'Alto si ha sido testigo de la agresión física crónica o grave en el hogar.',
            'Crítico si es testigo de manera reiterada de violencia física en el hogar.'
          ]
        },
        {
          question_title:'Historia de Maltrato en la niñez',
          answer_slug: 'answer8',
          information_slug: 'information8',
          guide_questions: [
            'Donde vivías cuando eras niño, ¿Alguien te pegaba?',
            '¿Alguien te gritaba, insultaba, humillaba?',
            '¿Se identifican algunos indicios de que hubo abuso sexual?',
            '¿Quién estaba a cargo de tu cuidado?',
          ],
          explanation_risk_levels: [
            'Bajo si no fue golpeado o descuidado físicamente durante la niñez.',
            'Moderado si de manera poco frecuente fue físicamente maltratado o descuidado durante la niñez (no hubo daño físico).',
            'Alto si fue maltratado físicamente (daño físico sufrido de manera reiterativa).',
            'Crítico si fue maltratado físicamente causando daños físicos graves y de forma recurrente.'
          ]
        },
        {
          question_title:'Bajo cumplimiento de metas o acuerdos',
          answer_slug: 'answer9',
          information_slug: 'information9',
          guide_questions: [
            'Cuando tienes algunas tareas específicas, ¿sientes que terminarlas es importante?',
            '¿Te motiva el hecho de tener metas claras y la importancia de cumplirlas?',
          ],
          explanation_risk_levels: [
            'Bajo  si se observa una actitud colaborativa del joven.',
            'Moderado si no aprecia mucho el valor de la necesidad de cumplir algunas metas sin embargo las lleva a cabo.',
            'Alto si la actitud hacia el cumplimiento de metas y acuerdos es negativa totalmente y no las lleva a cabo.',
            'Crítico si su comportamiento es desafiante ante el cumplimiento de metas y acuerdos.'
          ]
        },
        {
          question_title:'Los déficits de atención / hiperactividad',
          answer_slug: 'answer10',
          information_slug: 'information10',
          guide_questions: [
            'Cuando estás en algún tipo de reunión, ¿logras poner atención a los temas que se tratan?',
            '¿Consideras que puedes participar en reuniones por periodos largos?',
            'Cuando estás en casa, ¿logras poner atención a las pláticas familiares?',
          ],
          explanation_risk_levels: [
            'Bajo si no hay dificultades observadas con inquietud extrema, hiperactividad, o problemas de concentración.',
            'Moderado si se observa una inquietud, ciertos niveles de hiperactividad o problemas de concentración.',
            'Alto si muestra graves dificultades de inquietud extrema, hiperactividad o problemas de concentración.',
            'Crítico si la hiperactividad ha generado actos violentos de su parte.'
          ]
        },
        {
          question_title:'Estrés/ incapacidad para enfrentar dificultades',
          answer_slug: 'answer11',
          information_slug: 'information11',
          guide_questions: [
            '¿Has tenido alguna experiencia estresante recientemente?',
            '¿Has perdido algo o alguien que querías mucho?',
            '¿Qué fue lo que paso?',
            '¿Qué te hizo sentir en ese momento?',
            '¿Cómo reaccionaste?',
            '¿Con tu reacción causaste algún tipo de daño?',
          ],
          explanation_risk_levels: [
            'Bajo  si no ha presentado estrés debido a que no ha sufrido pérdidas importantes y su capacidad para hacer frente a las dificultades es buena.',
            'Moderado si ha manifestado alguna pérdida quien le haya generado estrés hace poco, pero se observa que es capaz de hacer frente a las dificultades correctamente.',
            'Alto si la pérdida ha sido muy importante, la fuente de estrés es considerable y se observa que el menor no es capaz de gestionar correctamente esa pérdida.',
            'Crítico si manifiesta vivir todo el tiempo bajo un estrés considerable y no es capaz de sobre llevar correctamente la pérdida.'
          ]
        },
        {
          question_title:'Actitudes negativas',
          answer_slug: 'answer12',
          information_slug: 'information12',
          guide_questions: [
            'Si sientes que alguien te faltó al respeto, ¿cómo reaccionas?',
            '¿Qué haces si sientes que alguien te reta con la mirada?',
          ],
          explanation_risk_levels: [
            'Bajo si no muestra actitudes que apoyen o legitimen la delincuencia o la violencia y/o el joven tiene la capacidad de generar soluciones no agresivas a problemas.',
            'Moderado si estas situaciones de legitimización se producen solamente en algunos casos y situaciones específicas.',
            'Alto en caso de que la justificación sea de manera constante y lo asimile como algo “normal”.',
            'Crítico si además de justificar la violencia muestra graves dificultades para generar soluciones no agresivas a sus problemas, terminando en peleas, debido a que tiende a malinterpretar las intenciones de los demás.'
          ]
        },
        {
          question_title:'Baja empatía / remordimiento',
          answer_slug: 'answer13',
          information_slug: 'information13',
          guide_questions: [
            'Cuando ves que alguien realiza un robo, ¿qué piensas? ¿Qué sientes? ¿Cómo reaccionas?',
            '¿Has visto a una persona golpear a alguien? ¿Qué sientes? ¿Cómo reaccionas?',
            'Si ves a una persona necesitar ayuda, ¿qué haces?',
          ],
          explanation_risk_levels: [
            'Bajo si manifiesta empatía con las víctimas ante un acto violento o delictivo.',
            'Moderado en algunas ocasiones si manifiesta empatía y otras veces no de los efectos de un acto delictivo o violento.',
            'Alto si manifiesta poca empatía tras un acto delictivo o violento.',
            'Crítico si no le afecta la desgracia de los demás y es indiferente ante la víctima, incluso justifica el acto.'
          ]
        },
        {
          question_title:'Comportamiento impulsivo',
          answer_slug: 'answer14',
          information_slug: 'information14',
          guide_questions: [
            'Cuando tienes un conflicto con otra persona, ¿cuál es tu reacción inmediata?',
            '¿Qué piensas cuando una persona responde de forma violenta a algún tipo de agresión?',
            'Si te das cuenta que una persona se te queda viendo, ¿qué haces?',
          ],
          explanation_risk_levels: [
            'Bajo si no presenta ningún problema con la asunción de riesgos o la impulsividad.',
            'Moderado si cuando está expuesto a situaciones de riesgo en algunas ocasiones actúa de manera impulsiva.',
            'Alto si constantemente actúa de manera impulsiva sin importarle las implicaciones que pudieran generarle.',
            'Crítico si no tiene la capacidad de reflexionar sobre las situaciones de riesgo a las que se enfrenta y siempre reacciona de una manera impulsiva.'
          ]
        },
        {
          question_title:'Problemas con el manejo del enfado',
          answer_slug: 'answer15',
          information_slug: 'information15',
          guide_questions: [
            '¿Qué haces cuando te enojas?',
            '¿Alguna vez has arrojado o golpeado cosas cuando te enojas?',
            '¿Lo haces frente a todos al momento en el que te enojaste o lo haces cuando ya estás solo?',
            '¿Has golpeado a alguna persona cuando te has enojado?',
          ],
          explanation_risk_levels: [
            'Bajo si sabe manejar sus sentimientos de enfado.',
            'si ha tenido alguna dificultad en manejar el enfado y de manera esporádica reacciona por ejemplo con gritos, portazos o puñetazos en la mesa, etc.',
            'Alto si no logra controlar su enfado en ningún momento, llegando a agredir a otra persona.',
            'Crítico si estas reacciones han generado algún tipo de lesión física a otra persona con el apoyo de algún objeto.'
          ]
        },
        {
          question_title:'Delincuencia en grupo de iguales',
          answer_slug: 'answer16',
          information_slug: 'information16',
          guide_questions: [
            '¿Algunos de tus amigos han tenido problemas con la policía?',
            '¿Han estado presos?',
            '¿Por qué delitos?',
            'Aproximadamente, ¿cuántas veces estos amigos han estado en problemas con la policía?',
            '¿Cuánto tiempo pasa con ellos al día?',
            '¿Te han obligado a cometer algún delito?',
          ],
          explanation_risk_levels: [
            'Bajo si los amigos con los que se junta habitualmente, no cometen actos delictivos.',
            'Moderado si los amigos con los que se junta habitualmente, no cometen actos delictivos.',
            'Alto si sus amigos con los que habitualmente se junta han participado de manera conjunta en actos delictivos.',
            'Crítico si los amigos con los que se junta frecuentemente están involucrados en actividades de alguna banda delictiva.'
          ]
        },
        {
          question_title:'Iniciación temprana en la violencia',
          answer_slug: 'answer17',
          information_slug: 'information17',
          guide_questions: [
            'Antes de los 12 años de edad, ¿participaste en algún tipo de pelea?',
            '¿Cuántas veces?',
            '¿En alguno de estos casos se requirió de atención médica?',
            '¿Con quién la tuviste y por qué sucedió?',
            '¿En alguno de esos casos han estado de por medio algún tipo de arma de tu parte o de la otra persona?',
          ],
          explanation_risk_levels: [
            'Se considerará Bajo si no se conocen actos previos de violencia.',
            'Se considerará Moderado si el primer acto violento tuvo lugar entre los 11 y los 13 años.',
            'Alto si el acto violento conocido tuvo lugar antes de los 11 años de edad.',
            'Crítico si existen diferentes actos violentos antes de los 11 años de edad.'
          ]
        },
        {
          question_title:'Violencia Previa',
          answer_slug: 'answer18',
          information_slug: 'information18',
          guide_questions: [
            'En el último año, ¿has participado en algún tipo de pelea?',
            '¿Cuántas veces?',
            '¿En alguno de esos casos han estado de por medio algún tipo de arma de tu parte o de la otra persona?',
            '¿En alguno de estos casos se ha requerido de atención médica?',
          ],
          explanation_risk_levels: [
            'Se considerará Bajo si el joven no ha cometido actos violentos previos.',
            'Moderado si ha cometido uno o dos actos violentos previos.',
            'Alto si ha cometido tres o más actos violentos previos.',
            'Crítico si uno o más actos violentos se han ejecutado con el uso de un arma y/o se requirió de atención médica.'
          ]
        },
        {
          question_title:'Historia de actos delictivos no violentos',
          answer_slug: 'answer19',
          information_slug: 'information19',
          guide_questions: [
            '¿En algún momento has cometido algún tipo de delito en el que no hayas tenido que confrontar físicamente a otra persona?',
            '¿Qué tipo de delito cometiste?',
            '¿Hace cuánto tiempo lo hiciste por última vez?',
            '¿Cuántas veces lo has hecho?',
          ],
          explanation_risk_levels: [
            'Se considerará Bajo si el joven no ha cometido delitos no violentos con anterioridad.',
            'Moderado si ha cometido menos de tres delitos no violentos con anterioridad.',
            'Alto si ha cometido delitos no violentos en más de tres ocasiones.',
            'Crítico si es una práctica reiterada.'
          ]
        },
        {
          question_title:'Antecedentes de medidas judiciales',
          answer_slug: 'answer20',
          information_slug: 'information20',
          guide_questions: [
            '¿Te han arrestado o has estado en algún tipo de conflicto con la ley?',
            '¿Cuántas veces?',
            '¿Has recibido una medida judicial?',
            '¿Qué tipo de medida?',
            'Cuando te dictaron esa orden, ¿de qué manera cumpliste con lo que te solicitaron?',
            '¿Cuál es el status actual de esa orden judicial?',
          ],
          explanation_risk_levels: [
            'Se considerará Bajo si no ha tenido ningún tipo medida judicial.',
            'Moderado si ha tenido solo una medida judicial (de cualquier tipo).',
            'Alto si ha tenido 2 o más medidas judiciales (de cualquier tipo).',
            'Crítico si ha tenido alguna sentencia que haya incumplido.'
          ]
        },
        {
          question_title:'Dificultades por el uso de sustancias',
          answer_slug: 'answer21',
          information_slug: 'information21',
          guide_questions: [
            '¿Alguna vez has consumido algún tipo de sustancia?',
            '¿Qué tipo de sustancias?',
            '¿Cuántas veces la/s consumiste?',
            '¿Actualmente sigues consumiendo algún tipo de sustancia?',
            '¿Con qué frecuencia lo haces? ',
            'Cuando consumes ese tipo de sustancia, ¿cómo te sientes?',
          ],
          explanation_risk_levels: [
            'Bajo si nunca ha tenido problemas con el consumo de sustancias tóxicas.',
            'Moderado si de manera esporádica ha consumido, pero sin problemas de adicción.',
            'Alto si ha tenido problemas de adicción en el pasado, aunque actualmente no los tenga.',
            'Crítico si consume de manera constante, existe desadaptación en el entorno y/o han existido episodios violentos bajo el influjo de algunas sustancias.'
          ]
        },
        {
          question_title:'Historia de las autolesiones o intentos de suicidio',
          answer_slug: 'answer22',
          information_slug: 'information22',
          guide_questions: [
            '¿Alguna vez te has generado algún tipo de lesión?',
            '¿Alguna vez necesitaste atención médica por estas situaciones?',
            '¿En alguna ocasión has pensado en suicidarte?',
            '¿Has intentado suicidarte?',
          ],
          explanation_risk_levels: [
            'Únicamente se valora la intencionalidad de dañarse a sí mismo. Será Bajo si no ha intentado hacerse daño físicamente.',
            'Moderado si las autolesiones son moderadas, como pequeñas quemaduras o cortes en la piel, que no requirieron atención médica.',
            'Alto si las autolesiones han requerido de atención médica.',
            'Crítico si ha requerido de hospitalización por las autolesiones.'
          ]
        },
        {
          question_title:'Criminalidad de los padres / cuidador',
          answer_slug: 'answer23',
          information_slug: 'information23',
          guide_questions: [
            '¿Alguno de tus padres o tutores han cometido algún delito?',
            '¿A qué edad?',
            '¿Han sido detenidos por la policía?',
            '¿Han estado presos?',
            '¿Cuántas veces recuerdas que hayan estado involucrados en problemas con la policía?',
            '¿Conoces los delitos en los que estuvieron involucrados? ¿Cuáles son?',
          ],
          explanation_risk_levels: [
            'Bajo si ninguno de los padres/cuidador tiene una historia de comportamiento criminal en la edad adulta.',
            'Moderado si alguno de los padres/cuidador tiene una historia criminal en la edad adulta.',
            'Alto si uno de los padres/cuidador tiene unas historias criminales frecuentes.',
            'Crítico si alguno de los padres/cuidador tiene una historia criminal grave como homicidio, robo a mano armada, intentos de homicidio, etc.'
          ]
        }
      ],
      yttv2_questionnarie:[
        {
          question_title:'Contexto escolar',
          answer_slug: 'answer1',
          information_slug: 'information1',
          guide_questions: [
            '¿Estudias actualmente? O ¿sigues estudiando?',
            '¿En qué año escolar te quedaste? ¿En qué año vas? O ¿Cuál fue el último año escolar que cursaste?',
            '¿Cuántas materias reprobaste?',
            '¿Cuál fue tu promedio?',
            '¿Repetiste algún grado escolar?',
            '¿Cuántas veces citaron a tus padres por algún problema de conducta [indisciplina, peleas, etc.]?',
            '¿Cuántas veces te han suspendido y/o expulsado?',
            '¿Crees que tienes alguna limitación para seguir avanzando en tus estudios?',
            '¿Tu familia te apoya en las exigencias académicas?'
          ],
          explanation_risk_levels: [
            'Bajo si no tuvo o ha tenido dificultades significativas de rendimiento escolar.',
            'Moderado si ha experimentado algunas dificultades educativas por ejemplo bajas calificaciones, pero no reprobó algún grado escolar.',
            'Alto si tiene un historial de haber reprobado y repetido algún grado escolar.',
            'Crítico si además de haber repetido algunos grados fueron expulsados por “mal comportamiento”.'
          ]
        },
        {
          question_title:'Ausencia de una figura parental',
          answer_slug: 'answer2',
          information_slug: 'information2',
          guide_questions: [
            '¿Con quién vives en la actualidad?',
            '¿Tus padres están separados o divorciados?',
            '¿Desde hace cuánto tiempo están separados? O ¿Cuántos años tenías cuando se separaron?',
            'Cuando se separaron ¿fuiste o tuviste que ir a vivir con alguien diferente a alguno de tus padres?',
            '¿Cuánto tiempo viviste con ellos?',
          ],
          explanation_risk_levels: [
            'Bajo  si no hubo interrupción en la atención de los padres durante toda la infancia.',
            'Moderado si no hubo interrupción en la atención de alguno de los padres durante toda la infancia.',
            'Alto si existió discontinuidad en la atención de los padres por algunos periodos cortos de tiempo.',
            'Crítico si pasaron un tiempo significativo (es decir, 1 año o más) Bajo los cuidados de otras personas durante la infancia.'
          ]
        },
        {
          question_title:'Estilos de crianza',
          answer_slug: 'answer3',
          information_slug: 'information3',
          guide_questions: [
            'En tu casa, ¿tienes claro cuáles son las reglas que han puesto tus padres, por ejemplo, en horario para llegar, los quehaceres de la casa?, ¿podrías mencionar alguna(s) de ellas?',
            'Cuando quieres salir con tus amigos, ¿pides permiso para salir?, ¿a quién?',
            '¿Hasta qué hora tienes permiso de llegar en la noche a tu hogar?',
            'Si no llegas en la hora permitida, ¿qué sucede?',
            '¿Tus padres saben realmente lo que estás haciendo en tu tiempo libre (cuando no estas estudiando o trabajando)?',
            '¿Tus padres entienden tus necesidades, problemas y/o preocupaciones?',
            '¿Has sentido que tus padres no te ayudan, no conviven contigo o no te ponen atención?',
          ],
          explanation_risk_levels: [
            'Bajo cuando el joven está siendo educado por sus padres o tutores en una disciplina consistente, con supervisión e implicación adecuada.',
            'Moderado si la disciplina a veces es inconsistente y la supervisión poco fiable.',
            'Alto si la disciplina es altamente inconsistente, siendo o muy permisiva o muy estricta.',
            'Crítico si la supervisión de los padres o tutores en todo momento está siendo basada en el castigo, incluso físico, y/o ausencia total de supervisión.'
          ]
        },
        {
          question_title:'Exposición de violencia en el hogar',
          answer_slug: 'answer4',
          information_slug: 'information4',
          guide_questions: [
            '¿En alguna ocasión hubo gritos, empujones, golpes, lanzamiento de objetos en tu casa?',
            '¿Sigue pasando eso actualmente?',
            '¿Entre quiénes ocurrió?',
            '¿Cuántas veces has sido testigo de estas situaciones? ¿En esa ocasión hubo agresión física que requirió atención médica?',
            'En el último mes ¿con qué frecuencia ocurrió que fueras testigo de gritos, empujones, golpes, etc.?',
          ],
          explanation_risk_levels: [
            'Bajo si no ha sido testigo de violencia en el hogar.',
            'Moderado si ha sido testigo de la agresión física ocasional y/o un solo acto de violencia en el hogar.',
            'Alto si ha sido testigo de la agresión física crónica o grave en el hogar.',
            'Crítico si es testigo de manera reiterada de violencia física en el hogar.'
          ]
        },
        {
          question_title:'Criminalidad de los padres/cuidador',
          answer_slug: 'answer5',
          information_slug: 'information5',
          guide_questions: [
            '¿Alguno de tus padres o tutores ha cometido algún delito?',
            '¿Conoces los delitos en los que estuvieron involucrados?, ¿podrías mencionar alguno(s)?',
            '¿Sabes a qué edad cometieron esos delitos?, ¿alguno de manera reciente? La policía ¿ha detenido a alguno de tus padres o tutores?',
            '¿Cuántas veces recuerdas que alguno de tus padres o tutores haya estado involucrado en problemas con la policía?',
            '¿Alguno de tus padres o tutores ha estado preso, “en la cárcel” o “en el reclusorio”?'
          ],
          explanation_risk_levels: [
            'Bajo si ninguno de los padres/cuidador tiene una historia de comportamiento criminal en la edad adulta.',
            'Moderado si alguno de los padres/cuidador tiene una historia criminal en la edad adulta.',
            'Alto si uno de los padres/cuidador tiene unas historias criminales frecuentes.',
            'Crítico si alguno de los padres/cuidador tiene una historia criminal grave como homicidio, robo a mano armada, intentos de homicidio, etc.'
          ]
        },
        {
          question_title:'Inseguridad comunitaria',
          answer_slug: 'answer6',
          information_slug: 'information6',
          guide_questions: [
            '¿Te sientes seguro en tu comunidad, colonia, barrio o pueblo?',
            '¿Se cometen delitos en tu comunidad, colonia, barrio o pueblo?, ¿qué tipo/formas de delito?',
            '¿Qué tan seguido suceden estas cosas?',
            '¿Qué tan a menudo eres testigo de esos hechos?',
            '¿Has sido víctima de alguno de estos delitos?, ¿algún familiar, persona cercana o conocido ha sido víctima de alguno de estos delitos?',
            '¿Te gustaría irte a vivir a otro lado?',
          ],
          explanation_risk_levels: [
            'Bajo si vive en una comunidad con bajos índices de delincuencia y violencia.',
            'Moderado si vive en una comunidad con algunos problemas relacionados a mayores tasas de delincuencia y/o violencia.',
            'Alto si vive en una comunidad con problemas significativos relativos a los altos índices de delincuencia y/o violencia.',
            'Crítico si la comunidad donde vive está considerada como de muy altos índices delictivos y violentos.'
          ]
        },
        {
          question_title:'Apoyo social percibido',
          answer_slug: 'answer7',
          information_slug: 'information7',
          guide_questions: [
            'Cuando tienes algún problema (te sientes mal, triste o enfermo) ¿tienes a quién acudir para pedirle apoyo/ayuda?, ¿a quién(es) acudes?',
            'Cuando acudes a esa(s) persona(s), ¿qué tipo de apoyo/ayuda te proporcionan/recibes (emocional/instrumental/etc.)?',
            '¿Cada cuánto tiempo visitas a esa persona para platicar?',
            'Cuando visitas o buscas a esa(s) persona(s), ¿está(n) disponibles para apoyarte/ayudarte?',
            '¿Te sientes satisfecho (“bien” o “mejor”) con el apoyo/ayuda que recibes?',
            '¿A qué se dedica esa persona?',
            '¿Con cuántas personas más cuentas para enfrentar tus problemas?',
          ],
          explanation_risk_levels: [
            'Bajo si su familia, cuidadores y/u otros adultos están disponibles y dispuestos a ofrecer apoyo emocional y orientación.',
            'Moderado si en ocasiones cuenta con familiares, cuidadores y/u otros adultos dispuestos a ofrecer apoyo emocional y orientación.',
            'Alto si el poco apoyo con el que cuenta, es incoherente y, a veces, poco fiable.',
            'Crítico si no cuenta con personas o algún familiar disponible y/o dispuesto a ofrecer apoyo emocional y orientación.'
          ]
        },
        {
          question_title:'Historia de Maltrato en la niñez',
          answer_slug: 'answer8',
          information_slug: 'information8',
          guide_questions: [
            'Mientras ibas creciendo, ¿Quién estaba a cargo de tu cuidado?',
            '¿Consideras que te cuidaban “bien”? ¿Por qué?',
            '¿Te sentías protegido con esa(s) personas (s)?',
            '¿Alguien te pegaba?',
            '¿Alguien te gritaba, insultaba, humillaba?',
            '¿Con qué frecuencia pasaba eso?',
            '¿Se identifican algunos indicios de que hubo abuso sexual?',
          ],
          explanation_risk_levels: [
            'Bajo si no fue golpeado o descuidado físicamente durante la niñez.',
            'Moderado si de manera poco frecuente fue físicamente maltratado o descuidado durante la niñez (no hubo daño físico).',
            'Alto si fue maltratado físicamente (daño físico sufrido de manera reiterativa).',
            'Crítico si fue maltratado físicamente causando daños físicos graves y de forma recurrente.'
          ]
        },
        {
          question_title:'Cumplimiento de metas o acuerdos',
          answer_slug: 'answer9',
          information_slug: 'information9',
          guide_questions: [
            'Cuando tienes algunas tareas específicas, ¿sientes que terminarlas es importante?',
            '¿Te motiva el hecho de tener metas claras y la importancia de cumplirlas?',
            '¿Puedes terminar lo que empiezas?',
          ],
          explanation_risk_levels: [
            'Bajo  si se observa una actitud colaborativa del joven.',
            'Moderado si no aprecia mucho el valor de la necesidad de cumplir algunas metas sin embargo las lleva a cabo.',
            'Alto si la actitud hacia el cumplimiento de metas y acuerdos es negativa totalmente y no las lleva a cabo.',
            'Crítico si su comportamiento es desafiante ante el cumplimiento de metas y acuerdos.'
          ]
        },
        {
          question_title:'Inatención / hiperactividad',
          answer_slug: 'answer10',
          information_slug: 'information10',
          guide_questions: [
            'Cuando estás en algún tipo de reunión, ¿logras poner atención a los temas que se tratan?',
            '¿Consideras que puedes participar en reuniones por periodos largos?',
            'Cuando estás en casa, ¿logras poner atención a las pláticas familiares?',
            '¿Tienes dificultad para concentrarte o prestar atención por mucho tiempo? (por ejemplo, mantener el hilo o seguir una conversación durante una fiesta o reunión con amigos)',
            '¿Te han dicho que “parece que no puedes estarte quieto”?',
            '¿Actúas sin pensar?',
            '¿Te distraes fácilmente?',
            '¿Te han dicho o se han quejado de que “hablas demasiado o hablas hasta por los codos”?'
          ],
          explanation_risk_levels: [
            'Bajo si no hay dificultades observadas con inquietud extrema, hiperactividad, o problemas de concentración.',
            'Moderado si se observa una inquietud, ciertos niveles de hiperactividad o problemas de concentración.',
            'Alto si muestra graves dificultades de inquietud extrema, hiperactividad o problemas de concentración.',
            'Crítico si la hiperactividad ha generado actos violentos de su parte.'
          ]
        },
        {
          question_title:'Actitudes hacia la violencia.',
          answer_slug: 'answer11',
          information_slug: 'information11',
          guide_questions: [
            'Si sientes que alguien te faltó al respeto, ¿cómo reaccionas?',
            '¿Qué haces si sientes que alguien te reta con la mirada?',
            '¿Qué sueles pensar cuando presencias una situación de violencia?',
            '¿Crees que es válida la violencia para hacer justicia?',
            '¿Piensas que en ocasiones solo la violencia ayuda a resolver los conflictos?',
            '¿Crees que la violencia o los malos tratos se deben denunciar?',
          ],
          explanation_risk_levels: [
            'Bajo si no muestra actitudes que apoyen o legitimen la delincuencia o la violencia y/o el joven tiene la capacidad de generar soluciones no agresivas a problemas.',
            'Moderado si estas situaciones de legitimización se producen solamente en algunos casos y situaciones específicas.',
            'Alto en caso de que la justificación sea de manera constante y lo asimile como algo “normal”.',
            'Crítico si además de justificar la violencia muestra graves dificultades para generar soluciones no agresivas a sus problemas, terminando en peleas, debido a que tiende a malinterpretar las intenciones de los demás.'
          ]
        },
        {
          question_title:'Empatía / remordimiento',
          answer_slug: 'answer12',
          information_slug: 'information12',
          guide_questions: [
            'Cuando ves que alguien realiza un robo, ¿qué piensas? ¿Qué sientes? ¿Cómo reaccionas?',
            '¿Has visto a una persona golpear a alguien? ¿Qué sientes? ¿Cómo reaccionas?',
            'Si ves a una persona necesitar ayuda, ¿qué haces?',
            '¿Te has arrepentido por no ayudar a alguien que pasa por violencia?',
          ],
          explanation_risk_levels: [
            'Bajo si manifiesta empatía con las victimas ante un acto violento o delictivo.',
            'Moderado en algunas ocasiones si manifiesta empatía y otras veces no de los efectos de un acto delictivo o violento.',
            'Alto si manifiesta poca empatía tras un acto delictivo o violento.',
            'Crítico si no le afecta la desgracia de los demás y es indiferente ante la víctima, incluso justifica el acto.'
          ]
        },
        {
          question_title:'Comportamiento impulsivo.',
          answer_slug: 'answer13',
          information_slug: 'information13',
          guide_questions: [
            'Cuando tienes un conflicto/problema con otra persona, ¿cuál es tu reacción inmediata?',
            'Si te das cuenta de que una persona se te queda viendo de manera insistente, ¿qué haces? O ¿cómo reaccionas?',
            '¿Has hecho cosas de manera impulsiva?, ¿cómo cuáles?',
            '¿Sueles decir cosas sin pensarlas?',
            '¿Te gusta más el placer rápido que tener que esperar por él?',
            '¿Te gusta sentir la adrenalina, aunque te ponga o ponga a alguien en peligro?',
          ],
          explanation_risk_levels: [
            'Bajo si no presenta ningún problema con la asunción de riesgos o la impulsividad.',
            'Moderado si cuando está expuesto a situaciones de riesgo en algunas ocasiones actúa de manera impulsiva.',
            'Alto si constantemente actúa de manera impulsiva sin importarle las implicaciones que pudieran generarle.',
            'Crítico si no tiene la capacidad de reflexionar sobre las situaciones de riesgo a las que se enfrenta y siempre reacciona de una manera impulsiva.'
          ]
        },
        {
          question_title:'Manejo del enojo',
          answer_slug: 'answer14',
          information_slug: 'information14',
          guide_questions: [
            '¿Consideras que te enojas fácilmente?',
            '¿Cuándo las cosas no salen como las planeas te enojas?',
            '¿Qué haces cuando te enojas?',
            '¿Alguna vez has arrojado o golpeado cosas cuando te enojas?',
            '¿Has golpeado a alguna persona cuando te has enojado?',
            '¿Lo haces frente a todos al momento en el que te enojaste o lo haces cuando ya estás solo?',
            '¿Te han dicho que “te enojas con facilidad”, “te prendes o enciendes muy rápido”?',
          ],
          explanation_risk_levels: [
            'Bajo si sabe manejar sus sentimientos de enfado.',
            'Moderado si ha tenido alguna dificultad en manejar el enfado y de manera esporádica reacciona por ejemplo con gritos, portazos o puñetazos en la mesa, etc.',
            'Alto si no logra controlar su enfado en ningún momento, llegando a agredir a otra persona.',
            'Crítico si estas reacciones han generado algún tipo de lesión física a otra persona con el apoyo de algún objeto.'
          ]
        },
        {
          question_title:'Delincuencia en grupo de iguales',
          answer_slug: 'answer15',
          information_slug: 'information15',
          guide_questions: [
            '¿Alguno de tus amigos(as) ha tenido algún problema con la policía?',
            '¿Alguno de tus amigos(as) ha estado preso/detenido o en el “tutelar”?',
            '¿Sabes o conoces por qué delitos los han detenido o han estado presos “en el tutelar”?',
            'Aproximadamente, ¿cuántas veces han tenido problemas con la policía tus amigos?',
            '¿Cuánto tiempo al día, convives con estos amigos(as)?',
            '¿Tus amigos te han invitado o te han obligado a cometer algún delito?, ¿qué delito?',
            '¿Perteneces o has pertenecido a una banda o pandilla?',
          ],
          explanation_risk_levels: [
            'Bajo si los amigos con los que se junta habitualmente no cometen actos delictivos.',
            'Moderado si dos o más de sus amigos han cometido actos delictivos.',
            'Alto si sus amigos con los que habitualmente se junta han participado de manera conjunta en actos delictivos.',
            'Crítico si los amigos con los que se junta frecuentemente están involucrados en actividades de alguna banda delictiva.'
          ]
        },
        {
          question_title:'Iniciación temprana en la violencia',
          answer_slug: 'answer16',
          information_slug: 'information16',
          guide_questions: [
            'Durante tu niñez y adolescencia, ¿participaste en alguna riña o pelea?',
            '¿Cuántas veces te peleaste?',
            '¿En alguno de estos casos hubo consecuencias con alguna autoridad (padres, maestros, policías) y/o se requirió de atención médica?',
            'En esa ocasión, ¿con quién(es) te peleaste y por qué sucedió esa pelea?',
            'En alguna de las peleas en las que participaste durante tu niñez y adolescencia, ¿estuvo de por medio o hubo algún tipo de arma (palo, navaja, cuchillo, pistola...)?',
          ],
          explanation_risk_levels: [
            'Bajo si no se conocen actos previos de violencia.',
            'Moderado si el primer acto violento tuvo lugar entre los 11 y los 13 años.',
            'Alto si el acto violento conocido tuvo lugar antes de los 11 años de edad.',
            'Crítico si existen diferentes actos violentos antes de los 11 años de edad.'
          ]
        },
        {
          question_title:'Violencia física interpersonal',
          answer_slug: 'answer17',
          information_slug: 'information17',
          guide_questions: [
            'En el último año ¿participaste en algún tipo de pelea?, ¿Cuántas veces o en cuántas ocasiones?',
            '¿Se requirió o fue necesaria la participación de alguna autoridad o atención médica por alguna de las peleas en las que participaste en el último año?',
            'En alguna de las peleas en las que participaste en el último año, ¿alguien utilizó algún tipo de arma (palo, navaja, cuchillo, pistola...)?',
          ],
          explanation_risk_levels: [
            'Bajo si el joven no ha cometido actos violentos previos.',
            'Moderado si ha cometido uno o dos actos violentos previos.',
            'Alto si ha cometido tres o más actos violentos previos.',
            'Crítico si uno o más actos violentos se han ejecutado con el uso de un arma y/o se requirió de atención médica.'
          ]
        },
        {
          question_title:'Historia de actos delictivos no violentos',
          answer_slug: 'answer18',
          information_slug: 'information18',
          guide_questions: [
            '¿En algún momento has realizado alguna actividad ilícita sin recurrir a la violencia física?',
            '¿A qué tipo de actividad te refieres?',
            '¿Cuántas veces lo has hecho?',
            '¿Hace cuánto tiempo sucedió la última vez?',
          ],
          explanation_risk_levels: [
            'Bajo si el joven no ha cometido delitos no violentos con anterioridad.',
            'Moderado si ha cometido menos de tres delitos no violentos con anterioridad.',
            'Alto si ha cometido delitos no violentos en más de tres ocasiones.',
            'Crítico si es una práctica reiterada.'
          ]
        },
        {
          question_title:'Problemas con la ley',
          answer_slug: 'answer19',
          information_slug: 'information19',
          guide_questions: [
            '¿Te han arrestado o has tenido algún tipo de conflicto con la ley? ¿Cuántas veces ha sucedido?',
            '¿Qué tipo de castigo has recibido?',
            '¿Has recibido alguna medida judicial? ¿Qué tipo de medida judicial recibiste?',
            'Cuando te dictaron esa orden o medida judicial, ¿de qué manera cumpliste con lo que te solicitaron?',
            '¿Cuál es el estado actual de esa orden judicial?',
            '¿Actualmente estás en un proceso legal?',
          ],
          explanation_risk_levels: [
            'Bajo si no ha tenido ningún tipo medida judicial.',
            'Moderado si ha tenido solo una medida judicial (de cualquier tipo).',
            'Alto si ha tenido 2 o más medidas judiciales (de cualquier tipo).',
            'Crítico si ha tenido alguna sentencia que haya incumplido.'
          ]
        },
        {
          question_title:'Dificultades por el uso de sustancias',
          answer_slug: 'answer20',
          information_slug: 'information20',
          guide_questions: [
            '¿Alguna vez has consumido alcohol, tabaco, o algún tipo de droga?',
            '¿Qué tipo de sustancias?',
            '¿Cuántas veces la/s consumiste?',
            '¿Actualmente sigues consumiendo sustancia(s)?',
            '¿Con qué frecuencia lo haces?',
            'Cuando consumes esa sustancia, ¿cómo te sientes?',
            '¿Qué tipo de problemas te ha traído consumir esta(s) sustancias (s)?',
          ],
          explanation_risk_levels: [
            'Bajo si nunca ha tenido problemas con el consumo de sustancias tóxicas.',
            'Moderado si de manera esporádica ha consumido, pero sin problemas de adicción.',
            'Alto si ha tenido problemas de adicción en el pasado, aunque actualmente no los tenga.',
            'Crítico si consume de manera constante, existe desadaptación en el entorno y/o han existido episodios violentos bajo el influjo de algunas sustancias.'
          ]
        },
      ],
      loading:false,
      beneficiary_selected: {},
      milliseconds_in_a_year: '',
      group: '',
      group_selected: '',
      beneficiary_election: '',
      beneficiary_age: '',
      user:[],
      formYTTv1: new Form({
        id: '',
        folio: '',
        age: '',
        beneficiary_id: '',
        answer1: '',
        answer2: '',
        answer3: '',
        answer4: '',
        answer5: '',
        answer6: '',
        answer7: '',
        answer8: '',
        answer9: '',
        answer10: '',
        answer11: '',
        answer12: '',
        answer13: '',
        answer14: '',
        answer15: '',
        answer16: '',
        answer17: '',
        answer18: '',
        answer19: '',
        answer20: '',
        answer21: '',
        answer22: '',
        answer23: '',
        information1: '',
        information2: '',
        information3: '',
        information4: '',
        information5: '',
        information6: '',
        information7: '',
        information8: '',
        information9: '',
        information10: '',
        information11: '',
        information12: '',
        information13: '',
        information14: '',
        information15: '',
        information16: '',
        information17: '',
        information18: '',
        information19: '',
        information20: '',
        information21: '',
        information22: '',
        information23: '',
        id_post: 0,
        take_num: '',
      }),
      formYTTv2: new Form({
        id: '',
        folio: '',
        age: '',
        beneficiary_id: '',
        answer1: '',
        answer2: '',
        answer3: '',
        answer4: '',
        answer5: '',
        answer6: '',
        answer7: '',
        answer8: '',
        answer9: '',
        answer10: '',
        answer11: '',
        answer12: '',
        answer13: '',
        answer14: '',
        answer15: '',
        answer16: '',
        answer17: '',
        answer18: '',
        answer19: '',
        answer20: '',
        information1: '',
        information2: '',
        information3: '',
        information4: '',
        information5: '',
        information6: '',
        information7: '',
        information8: '',
        information9: '',
        information10: '',
        information11: '',
        information12: '',
        information13: '',
        information14: '',
        information15: '',
        information16: '',
        information17: '',
        information18: '',
        information19: '',
        information20: '',
        risk_level: '',
        take_num: '',
      })
    }
  },
  methods:{
    saveAsDraft(){
      this.$data.draftmode = true;
    },
    saveEvaluation(){
      this.$data.draftmode = false;
    },
    clearBeneficiarySelection(tool){
      this.beneficiary_election = null;
    },
    loadData(){
      this.loading = true;
      this.formYTTv1.reset();
      this.formYTTv2.reset();
      axios.get(`/api/beneficiary_by_folio/${this.$route.params.user}`)
      .then(({data}) => {
        if (data.ytt1_draft) this.formYTTv1.fill(data.ytt1_draft);
        if (data.ytt2_draft) this.formYTTv2.fill(data.ytt2_draft);
        this.beneficiary_selected = data;
        this.group = data.group_id;
        this.group_selected = data.group;
        this.beneficiary_election = data.id;
        this.loading = false;
      }).catch(()=>{
        toast({
          type: 'error',
          title: 'Error al cargar datos'
        })
        this.loading = false;
      })
      this.beneficiary_age = this.$props.age;
      this.formYTTv1.age = this.$props.age;
      this.formYTTv2.age = this.$props.age;
    },
    createYtt1Draft() {
      this.$Progress.start();

      if(this.beneficiary_selected.ytt1_draft){
        this.formYTTv1.put('/api/ytt1draft/'+this.formYTTv1.id)
        .then(() => {
          // success
          swal(
            'Actualizado',
            'La información se ha actualizado.',
            'success'
          )
          this.$Progress.finish();
          Fire.$emit('AfterCreate');
          this.formYTTv1.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
        })
      } else {
        this.formYTTv1.beneficiary_id = this.beneficiary_election;

        this.formYTTv1.post('/api/ytt1draft').then(()=>{
          Fire.$emit('AfterCreate');
          this.formYTTv1.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
          toast({
            type: 'success',
            title: 'Borrador YTT v1 creado con éxito.'
          })
          this.$Progress.finish();
        })
        .catch(()=>{
          this.$Progress.fail();
        })
      }
    },
    createYtt1Evaluation(){
      this.$Progress.start();
      this.formYTTv1.beneficiary_id = this.beneficiary_election;
      this.formYTTv1.take_num = this.beneficiary_selected.ytt1_evaluations.length +1;

      if(this.beneficiary_selected.ytt1_draft){
        axios.delete(`/api/ytt1draft/${this.beneficiary_selected.ytt1_draft.id}`, {data: { id: this.beneficiary_selected.ytt1_draft.id}})
        .then(()=>{
          swal(
            'Borrador eliminado!',
            '',
            'success'
          )
        }).catch(()=> {
          swal("Error", "No se pudo eliminar el borrador.", "warning");
        });

        this.formYTTv1.post('/api/ytt1evaluation').then(()=>{
          Fire.$emit('AfterCreate');
          this.formYTTv1.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
          toast({
            type: 'success',
            title: 'Evaluación YTT v1 creada con éxito.'
          })
          this.$Progress.finish();
        }).catch(()=>{
          swal("Error", "Completa todos los campos.", "warning");
          this.$Progress.fail();
        })
      } else {
        this.formYTTv1.post('/api/ytt1evaluation').then(()=>{
          Fire.$emit('AfterCreate');
          this.formYTTv1.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
          toast({
            type: 'success',
            title: 'Evaluación YTT v1 creada con éxito.'
          })
          this.$Progress.finish();
        })
        .catch(()=>{
          swal("Error", "Completa todos los campos.", "warning");
          this.$Progress.fail();
        })
      }
    },
    createYtt2Evaluation(){
      this.$Progress.start();
      this.formYTTv2.beneficiary_id = this.beneficiary_election;
      this.formYTTv2.take_num = this.beneficiary_selected.ytt2_evaluations.length +1;

      if(this.beneficiary_selected.ytt2_draft){
        axios.delete(`/api/ytt2draft/${this.beneficiary_selected.ytt2_draft.id}`, {data: { id: this.beneficiary_selected.ytt2_draft.id}})
        .then(()=>{
          swal(
            'Borrador eliminado!',
            '',
            'success'
          )
        }).catch(()=> {
          swal("Error", "Algo salió mal.", "warning");
        });

        this.formYTTv2.post('/api/ytt2evaluation').then(()=>{
          Fire.$emit('AfterCreate');
          this.formYTTv1.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
          toast({
            type: 'success',
            title: 'Evaluación YTT v2 creada con éxito.'
          })
          this.$Progress.finish();
        })
        .catch(()=>{
          swal("Error", "Completa todos los campos.", "warning");
          this.$Progress.fail();
        })
      }else{
        this.formYTTv2.post('/api/ytt2evaluation').then(()=>{
          Fire.$emit('AfterCreate');
          this.formYTTv1.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
          toast({
            type: 'success',
            title: 'Evaluación YTT v2 creada con éxito.'
          })
          this.$Progress.finish();
        })
        .catch(()=>{
          swal("Error", "Completa todos los campos.", "warning");
          this.$Progress.fail();
        })
      }
    },
    createYtt2Draft() {
      this.$Progress.start();

      if(this.beneficiary_selected.ytt2_draft){
        this.formYTTv2.put('/api/ytt2draft/'+this.formYTTv2.id)
        .then(() => {
          // success
          swal(
            'Actualizado',
            'La información se ha actualizado.',
            'success'
          )
          this.$Progress.finish();
          Fire.$emit('AfterCreate');
          this.formYTTv2.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
        })
        .catch(() => {
          this.$Progress.fail();
          toast({
            type: 'error',
            title: 'Algo salió mal..'
          })
        });
      } else {
        this.formYTTv2.beneficiary_id = this.beneficiary_election;

        this.formYTTv2.post('/api/ytt2draft').then(()=>{
          Fire.$emit('AfterCreate');
          this.formYTTv2.reset();
          this.$router.push(`/group/${this.$route.params.group}/${this.$route.params.user}`)
          toast({
            type: 'success',
            title: 'Borrador YTT v2 creado con éxito.'
          })
          this.$Progress.finish();
        })
        .catch(()=>{
          this.$Progress.fail();
          toast({
            type: 'error',
            title: 'Algo salió mal..'
          })
        })
      }
    },
  },
  created(){
    this.loadData();
    this.beneficiary_age = this.$props.age;
    this.formYTTv1.age = this.$props.age;
    this.formYTTv2.age = this.$props.age;
  }
}
</script>

<style lang="css">
</style>
