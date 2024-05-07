<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

// Project implemented by the "Recovery, Transformation and Resilience Plan.
// Funded by the European Union - Next GenerationEU".
//
// Produced by the UNIMOODLE University Group: Universities of
// Valladolid, Complutense de Madrid, UPV/EHU, León, Salamanca,
// Illes Balears, Valencia, Rey Juan Carlos, La Laguna, Zaragoza, Málaga,
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos..

/**
 * Galician language strings
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Kuet';
$string['pluginadministration'] = 'Kuet Administración';
$string['modulename'] = 'Kuet';
$string['modulenameplural'] = 'Kuets';
$string['kuet:addinstance'] = 'Engade un novo paquete Kuet';
$string['kuet:view'] = 'Ver Kuet';
$string['kuet:managesessions'] = 'Xestionar sesións';
$string['kuet:startsession'] = 'Inicializar sesións';
$string['kuet:viewanonymousanswers'] = 'Ver respostas anónimas';
$string['name'] = 'Nome';
$string['introduction'] = 'Descrición';
$string['questiontime'] = 'Tempo de preguntas';
$string['questiontime_desc'] = 'Tiempo para cada pregunta en segundos.';
$string['questiontime_help'] = 'AXUDA! Tempo para cada pregunta en segundos.';
$string['completiondetail:answerall'] = 'Participa nunha sesión respondendo preguntas';
$string['completionansweralllabel'] = 'Participa nunha sesión.';
$string['completionansweralldesc'] = 'Participa nunha sesión respondendo preguntas.';
$string['configtitle'] = 'Kuet';
$string['generalsettings'] = 'Configuración xeral';
$string['socket'] = 'Socket';
$string['sockettype'] = 'Tipo de Socket';
$string['sockettype_desc'] = 'Necesítase un servidor socket para iniciar sesións manuais. Este socket pode ser local ou externo: <ul><li><b>Sen socket: </b>Non se utilizarán os modos de sesión manuais</li><li><b>Socket local: </b>O socket iniciarase no mesmo servidor que esta plataforma (necesita ter certificados).</li><li><b>Externo: </b>Podes iniciar o socket nun servidor externo, proporcionando o URL e o porto ao plataforma de conexión.</li></ul>';
$string['nosocket'] = 'Non use socket';
$string['local'] = 'Local';
$string['external'] = 'Externo';
$string['externalurl'] = 'URL Externa';
$string['externalurl_desc'] = 'URL onde está aloxado o socket. Pode ser unha IP, pero debe ter protocolo HTTPS.';
$string['downloadsocket'] = 'Descargar script para executalo nun servidor externo';
$string['downloadsocket_desc'] = 'Descarga desde aquí o script para executalo nun servidor externo.<br>O administrador da máquina onde se executa este script debe proporcionarlle un porto e certificados.<br>É responsabilidade deste administrador asegurarse de que o socket está funcionando en todo momento.<br>';
$string['scriptphp'] = 'Descargar Script PHP';
$string['certificate'] = 'Certificado';
$string['certificate_desc'] = 'Ficheiro .crt ou .pem dun certificado SSL válido para o servidor. É posible que este ficheiro xa se xere no servidor ou podes crear outros únicos para este mod usando ferramentas como <a href="https://zerossl.com" target="_blank">zerossl.com</a>.';
$string['privatekey'] = 'Chave privada';
$string['privatekey_desc'] = 'Ficheiro .pem ou .key dunha chave privada SSL válida para o servidor. É posible que este ficheiro xa se xere no servidor ou podes crear outros únicos para este mod usando ferramentas como <a href="https://zerossl.com" target="_blank">zerossl.com</a>.';
$string['testssl'] = 'Proba de conexión';
$string['testssl_desc'] = 'Proba de conexión de socket con certificados SSL';
$string['validcertificates'] = 'Certificados SSL e porto válidos';
$string['invalidcertificates'] = 'Certificados ou porto non válidos';
$string['connectionclosed'] = 'Conexión pechada';
$string['port'] = 'Porto';
$string['port_desc'] = 'Porto para facer a conexión. Este porto debe estar aberto, polo que terás que consultar co administrador do teu sistema.';
$string['warningtest'] = 'Isto tentará unha conexión ao socket coa configuración actual. <b>Garda a configuración antes de probar.</b>';
$string['session_name'] = 'Nome da sesión';
$string['session_name_placeholder'] = 'Nome da sesión';
$string['session_name_help'] = 'Escribe o nome da sesión';
$string['anonymousanswer'] = 'Respostas anónimas';
$string['anonymousanswer_help'] = 'Escolle unha opción.';
$string['countdown'] = 'Mostrar a conta atrás das preguntas';
$string['randomquestions'] = 'Preguntas aleatorias';
$string['randomanswers'] = 'Respostas aleatorias';
$string['showfeedback'] = 'Mostrar comentarios';
$string['showfinalgrade'] = 'Mostrar a nota final';
$string['timesettings'] = 'Axustes de tempo';
$string['startdate'] = 'Data de finalización da sesión';
$string['enddate'] = 'Data de finalización da sesión';
$string['automaticstart'] = 'Arranque automático';
$string['timelimit'] = 'Límite de tempo';
$string['accessrestrictions'] = 'Restricións de acceso';
$string['next'] = 'seguindo';
$string['sessions'] = 'Sesións';
$string['sessions_info'] = 'Mostraranse todas as sesións';
$string['reports'] = 'Informes';
$string['reports_info'] = 'Todas as sesións completadas móstranse para acceder ao informe.';
$string['sessionreport'] = 'Informe da sesión';
$string['sessionreport_info'] = 'Móstrase o informe da sesión.';
$string['report'] = 'Informe';
$string['active_sessions'] = 'Sesións activas';
$string['completed_sessions'] = 'Sesións completedas';
$string['create_session'] = 'Crear sesión';
$string['questions_number'] = 'Número de preguntas';
$string['question_number'] = 'Número de preguntas';
$string['session_date'] = 'Data';
$string['session_finishingdate'] = 'Data de finalización';
$string['session_actions'] = 'Accións';
$string['init_session'] = 'Iniciar sesión';
$string['init_session_desc'] = 'Se inicia unha sesión manualmente, pode bloquear as sesións programadas cun inicio automático. Asegúrate de que non haxa sesións próximas antes de comezar esta sesión.<br>¿Estás seguro de que queres iniciar a sesión?';
$string['end_session'] = 'Finalizar sesión';
$string['end_session_error'] = 'Non se puido finalizar a sesión debido a un erro na comunicación co servidor. Téntao de novo.';
$string['end_session_desc'] = '¿Estás seguro de que queres finalizar a sesión?';
$string['end_session_manual_desc'] = 'Se finalizas a sesión, pecharás a conexión de todos os estudantes e xa non poderán responder a este cuestionario.<br><b>¿Estás seguro de que queres finalizar a sesión?</b>';
$string['viewreport_session'] = 'Ver informe';
$string['edit_session'] = 'Editar sesión';
$string['copy_session'] = 'Copiar sesión';
$string['delete_session'] = 'Eliminar sesión';
$string['copysession'] = 'Copiar Sesión';
$string['copysession_desc'] = '¿Estás seguro de que queres copiar esta sesión? Se a sesión ten datas automáticas de inicio ou inicio e finalización, estas deberán restablecerse.';
$string['copysessionerror'] = 'Produciuse un erro ao copiar a sesión. Comproba que tes a capacidade "mod/kuet:managesessions" ou téntao de novo máis tarde.';
$string['deletesession'] = 'Eliminar Sesión';
$string['deletesession_desc'] = '¿Estás seguro de que queres eliminar esta sesión?';
$string['deletesessionerror'] = 'Produciuse un erro ao eliminar a sesión. Comproba que tes a capacidade "mod/kuet:managesessions" ou téntao de novo máis tarde.';
$string['confirm'] = 'Confirmar';
$string['copy'] = 'Copiar';
$string['groupings'] = 'Agrupacións';
$string['anonymiseresponses'] = 'Anonimizar as respostas dos estudantes';
$string['noanonymiseresponses'] = 'Non anonimice as respostas dos estudantes';
$string['sessionconfiguration'] = 'Configuración da sesión';
$string['sessionconfiguration_info'] = 'Configura a túa propia sesión';
$string['questionsconfiguration'] = 'Configuración de preguntas';
$string['questionsconfiguration_info'] = 'Engade as preguntas á sesión';
$string['summarysession'] = 'Resumo da sesión';
$string['summarysession_info'] = 'Revisa a sesión';
$string['sessionstarted'] = 'A sesión comezou';
$string['multiplesessionerror'] = 'Esta sesión non está activa ou non existe.';
$string['notactivesession'] = 'Vaia, parece que o teu profesor aínda non iniciou ningunha sesión...';
$string['notactivesessionawait'] = 'Agarda a que o inicie ou mira os teus últimos informes.';
$string['nextsession'] = 'Próxima sesión:';
$string['nosession'] = 'Non hai sesión inicializada polo profesor';
$string['questions_list'] = 'Preguntas seleccionadas';
$string['questions_bank'] = 'Banco de preguntas';
$string['question_position'] = 'Posición';
$string['question_name'] = 'Nome';
$string['question_type'] = 'Tipo';
$string['question_version'] = 'Versión';
$string['question_isvalid'] = 'É válido';
$string['question_actions'] = 'Accións';
$string['improvise_cloudtags'] = 'Improvisar etiquetas de nube';
$string['select_category'] = 'Seleccione unha categoría';
$string['go_questionbank'] = 'Vaia ao banco de preguntas';
$string['selectall'] = 'Seleccionar/deseleccionar todo';
$string['selectvisibles'] = 'Selecciona/desmarca visibles';
$string['add_questions'] = 'Engadir preguntas';
$string['number_select'] = 'Preguntas seleccionadas: ';
$string['changecategory'] = 'Cambio de categoría';
$string['changecategory_desc'] = 'Seleccionaches preguntas que non se engadiron á sesión. Se cambias de categoría perderás esta selección ¿Queres continuar?';
$string['selectone'] = 'Selecciona preguntas';
$string['selectone_desc'] = 'Selecciona polo menos unha pregunta para engadir á sesión.';
$string['addquestions'] = 'Engadir preguntas';
$string['addquestions_desc'] = '¿Estás seguro de engadir {$a} preguntas á sesión?';
$string['deletequestion'] = 'Eliminar unha pregunta da sesión';
$string['deletequestion_desc'] = '¿Estás seguro de eliminar esta pregunta da sesión?';
$string['gradesheader'] = 'Cualificación de pregunta';
$string['nograding'] = 'Ignora a resposta correcta e a cualificación';
$string['sessionalreadyexists'] = 'O nome da sesión xa existe';
$string['showgraderanking'] = 'Mostrar clasificación entre preguntas';
$string['question_nosuitable'] = 'Non é adecuado co complemento kuet.';
$string['configuration'] = 'Configuración';
$string['end'] = 'Fin';
$string['questionidnotsent'] = 'cuestionado non enviado';
$string['question_index_string'] = '{$a->num} de {$a->total}';
$string['question'] = 'Pregunta';
$string['feedback'] = 'Comentarios';
$string['session_info'] = 'Información da sesión';
$string['results'] = 'Resultados';
$string['students'] = 'Estudantes';
$string['corrects'] = 'Corrixe';
$string['incorrects'] = 'Incorrecto';
$string['notanswers'] = 'Sen resposta';
$string['points'] = 'Puntos';
$string['inactive_manual'] = 'Manual inactivo';
$string['inactive_programmed'] = 'Programado inactivo';
$string['podium_manual'] = 'Podio manual';
$string['podium_programmed'] = 'Podio programado';
$string['race_manual'] = 'Carreira manual';
$string['race_programmed'] = 'Carreira programada';
$string['sessionmode'] = 'Modo sesión';
$string['sessionmode_help'] = 'Os modos de sesión mostran diferentes formas de usar as sesións de kuet.';
$string['countdown_help'] = 'Activa esta opción para que os estudantes poidan ver a conta atrás en cada pregunta. (Só se a pregunta ten tempo)';
$string['showgraderanking_help'] = 'O profesor non verá a clasificación durante unha sesión en directo. Só dispoñible nos modos de sesión de podios.';
$string['showgraderankinghelp'] = 'SIN _O profesor non verá a clasificación durante unha sesión en directo. Só dispoñible nos modos de sesión de podios.';
$string['randomquestions_help'] = 'As preguntas aparecerán nunha orde aleatoria para cada alumno. Só válido para o modo de sesión programado.';
$string['randomanswers_help'] = 'As respostas aparecerán nunha orde aleatoria para cada alumno.';
$string['showfeedback_help'] = 'Despois de responder a cada pregunta, aparecerán comentarios. No modo manual, o profesor pode mostrar ou ocultar os comentarios de cada pregunta (só se a pregunta contén comentarios).';
$string['showfinalgrade_help'] = 'A nota final aparecerá ao rematar a sesión.';
$string['startdate_help'] = 'A sesión comezará automaticamente nesta data. Só estará dispoñible a data de inicio coas sesións programadas.';
$string['enddate_help'] = 'A sesión rematará automaticamente nesta data. Só estará dispoñible a data de finalización nas sesións programadas.';
$string['automaticstart_help'] = 'A sesión comezará e rematará automaticamente se se establecen datas para ela, para que non teña que iniciarse manualmente.';
$string['timelimit_help'] = 'Tempo total para a sesión';
$string['waitingroom'] = 'Sala de espera';
$string['waitingroom_info'] = 'Comproba que todo está correcto antes de comezar a sesión.';
$string['sessionstarted_info'] = 'Comezaches a sesión, tes que facer un seguimento das preguntas.';
$string['participants'] = 'Participantes';
$string['waitingroom_message'] = 'Espera, marchamos en pouco tempo...';
$string['ready_users'] = 'Participantes listos';
$string['ready_groups'] = 'Grupos preparados';
$string['session_closed'] = 'Pechouse a conexión: ';
$string['session_closed_info'] = 'Isto pode deberse a que a sesión rematou, a que o profesor rematou a sesión ou a un problema técnico coa conexión. Volve iniciar sesión na sesión para volver conectar ou ponte en contacto co teu profesor.';
$string['system_error'] = 'Produciuse un erro e pechouse a conexión.<br>Non é posible continuar coa sesión.';
$string['connection_closed'] = 'Conexión pechada {$a->reason} - {$a->code}';
$string['backtopanelfromsession'] = '¿Volver ao panel de sesións?';
$string['backtopanelfromsession_desc'] = 'Se volves, a sesión non se inicializará e poderás comezala de novo en calquera momento ¿Queres volver ao panel da sesión?';
$string['lowspeed'] = 'A túa conexión a Internet parece lenta ou inestable ({$a->link descendente} Mbps, {$a->effectiveType}). Isto pode provocar un comportamento inesperado ou o peche repentino da sesión.<br>Recomendámosche que non inicies a sesión ata que teñas unha boa conexión a Internet.';
$string['alreadyteacher'] = 'Xa hai un profesor impartindo esta sesión, polo que non podes conectarte. Agarda a que remate a sesión actual antes de poder entrar.';
$string['userdisconnected'] = 'O usuario {$a} foi desconectado.';
$string['qtimelimit_help'] = 'É hora de responder á pregunta. Útil cando o tempo da sesión é a suma do tempo de preguntas.';
$string['sessionlimittimebyquestionsenabled'] = 'Esta sesión ten un límite de tempo de {$a}. O tempo total de cada pregunta calcularase dividindo o tempo total polo número de preguntas.<br>Se queres engadir un tempo por pregunta, debes especificar o modo de sesión en "Tempo por pregunta", especificar un tempo predeterminado. , e despois podes establecer unha hora para cada pregunta mediante este formulario.';
$string['notimelimitenabled'] = 'A sesión está definida sen límite de tempo.<br>Se queres engadir un tempo por pregunta, debes especificar o modo de sesión en "Tempo por pregunta", especificar un tempo predeterminado e, a continuación, podes definir un tempo para cada pregunta usando esta forma.';
$string['incompatible_question'] = 'Pregunta non compatible';
$string['controlpanel'] = 'Panel de control';
$string['control'] = 'Control';
$string['pause'] = 'Pausa';
$string['play'] = 'Continuar';
$string['resend'] = 'Reenviar';
$string['jump'] = 'Saltar';
$string['finishquestion'] = 'Remata a pregunta';
$string['showhide'] = 'Mostrar/ocultar';
$string['responses'] = 'Respostas';
$string['statistics'] = 'Estatísticas';
$string['questions'] = 'Preguntas';
$string['improvise'] = 'Improvisar';
$string['vote'] = 'Votar';
$string['vote_tags'] = 'Votar etiquetas';
$string['incorrect_sessionmode'] = 'Modo de sesión incorrecto';
$string['endsession'] = 'Rematou a sesión';
$string['endsession_info'] = 'Chegaches ao final da sesión e agora podes ver o informe cos teus resultados ou continuar co curso.';
$string['timemode'] = 'Modo de tempo';
$string['no_time'] = 'Sen tempo';
$string['session_time'] = 'Tempo total da sesión';
$string['session_time_resume'] = 'Tempo total da sesión: {$a}';
$string['sessiontime'] = 'Tempo sesión';
$string['timeperquestion'] = 'Tempo por pregunta';
$string['sessiontime_help'] = 'O tempo fixado dividirase entre o número de preguntas e repartirase o mesmo tempo para todas as preguntas.';
$string['question_time'] = 'Tempo por pregunta';
$string['question_time_help'] = 'Establecerase un tempo establecido para cada pregunta (pode facelo despois de engadir a pregunta á sesión). Establecerase un tempo predeterminado para asignar a aquelas preguntas que non teñan un tempo definido.';
$string['timemode_help'] = 'Cómpre ter en conta que o tempo de cada pregunta corresponde ao tempo permitido para "responder", xa que responder a cada pregunta parará o tempo ata que o usuario pase á seguinte.<br><br><b>Sen tempo: </b> Non hai tempo para rematar a sesión. Pódese establecer o tempo para cada pregunta, algunha ou ningunha (no panel de preguntas).<br><b>Tempo total da sesión:</b> O tempo fixado dividirase polo número de preguntas e asignarase o mesmo tempo. a todas as preguntas.<br><b>Tempo por pregunta:</b> establecerase un tempo establecido para cada pregunta (podes facelo despois de engadir a pregunta á sesión). Establecerase un tempo predeterminado para asignar a aquelas preguntas que non teñan un tempo definido.<br><br><b>Importante:</b> se nunha pregunta programada o usuario pecha o navegador ou actualiza a páxina, iso a pregunta considerarase non entregada, xa que se entenderá como un intento de gañar tempo para responder.';
$string['erroreditsessionactive'] = 'Non é posible editar unha sesión activa.';
$string['activesessionmanagement'] = 'Xestión activa de sesións';
$string['sessionnoquestions'] = 'Non se engadiron preguntas á sesión.';
$string['sessioncreating'] = 'Non remataches de editar esta sesión. Debes chegar ao paso 3 de edición e facer clic en finalizar.';
$string['sessionconflict'] = 'Esta sesión ten un conflito de data con outras sesións máis próximas a ela e non comezará automaticamente ata que se resolva o conflito.';
$string['sessionwarning'] = 'Esta sesión debería comezar, pero actualmente hai unha sesión activa que o impide. Iniciarase automaticamente en canto remate a sesión activa.';
$string['sessionerror'] = 'Produciuse un erro nesta sesión e non se pode continuar (eliminación de grupos ou agrupacións activos, eliminación de preguntas, modificación da configuración do mod, etc.). Duplícao e/ou elimínao, pero comproba toda a configuración implicada.';
$string['startminorend'] = 'A data de finalización da sesión non pode ser igual ou inferior á data de inicio.';
$string['previousstarterror'] = 'A data de inicio non pode ser inferior á data actual.';
$string['sessionmanualactivated'] = 'A sesión {$a->sessionid} está activa en kuetid -> {$a->kuetid}. O resto da sesión omítese ata o final desta.';
$string['sessionactivated'] = 'Sesión {$a->sessionid} activada para kuetid {$a->kuetid}';
$string['sessionfinished'] = 'Session {$a->sessionid} rematada para kuetid {$a->kuetid}';
$string['sessionfinishedformoreone'] = 'A sesión {$a->sessionid} rematou para kuetid {$a->kuetid} porque hai máis dunha sesión activa.';
$string['error_initsession'] = 'Erro ao inicio da sesión';
$string['error_initsession_desc'] = 'Non se puido iniciar a sesión, xa sexa porque xa se iniciou unha sesión ou por un erro específico. Actualiza a páxina e téntao de novo.';
$string['success'] = 'Éxito';
$string['noresponse'] = 'Sen resposta';
$string['noevaluable'] = 'Non avaliable';
$string['invalid'] = 'Non válido';
$string['ranking'] = 'Clasificación';
$string['participant'] = 'Participante';
$string['score'] = 'Puntuación';
$string['viewreport_user'] = 'Informe de usuario';
$string['viewreport_group'] = 'Informe de grupo';
$string['otheruserreport'] = 'Non podes ver o informe doutro alumno';
$string['userreport'] = 'Informe da sesión do usuario';
$string['userreport_info'] = 'Amósanse os resultados dunha sesión para un usuario.';
$string['groupreport'] = 'Informe da sesión grupal';
$string['groupreport_info'] = 'Amósanse os resultados dunha sesión para un grupo.';
$string['viewquestion_user'] = 'Ver resposta';
$string['questionreport'] = 'Informe de preguntas';
$string['questionreport_info'] = 'Móstrase o informe dunha pregunta nunha sesión.';
$string['preview'] = 'Vista previa';
$string['percent_correct'] = '% éxito';
$string['percent_incorrect'] = '% Incorrectas';
$string['percent_partially'] = '% Parcialmente correctas';
$string['percent_noresponse'] = '% Sen resposta';
$string['student_number'] = 'No. de alumnos';
$string['correct'] = 'Correcta';
$string['incorrect'] = 'Incorrecta';
$string['response'] = 'Resposta';
$string['score_moment'] = 'Puntuación da pregunta';
$string['time'] = 'tempo';
$string['status'] = 'Estado';
$string['anonymousanswers'] = 'As respostas a este cuestionario son anónimas.';
$string['kuetnotexist'] = 'Non foi posíbel atopar kuet con id {$a}';
$string['jumpto_error'] = 'Debe ser un número entre 1 e {$a}';
$string['session'] = 'sesión';
$string['send_response'] = 'Enviar resposta';
$string['partially_correct'] = 'Parcialmente correcto';
$string['partially'] = 'Parcialmente';
$string['scored_answers'] = 'Respostas puntuadas';
$string['provisional_ranking'] = 'Clasificación provisional';
$string['final_ranking'] = 'Clasificación final';
$string['score_obtained'] = 'Puntuación obtida';
$string['total_score'] = 'Puntuación total';
$string['grademethod'] = 'Método de cualificación';
$string['grademethod_help'] = 'Escolle a forma de cualificar este módulo. A cualificación aparecerá no libro de cualificacións de Moodle';
$string['nograde'] = 'Non cualifiques';
$string['gradehighest'] = 'Sesión con maior nota';
$string['gradeaverage'] = 'Media das sesións de notas';
$string['firstsession'] = 'Grao da primeira sesión';
$string['lastsession'] = 'Nota da última sesión';
$string['sessionended'] = 'Rematou a sesión';
$string['sessionended_desc'] = 'Cando un usuario finaliza unha sesión, desenvólvese un evento para calcular a cualificación da sesión.';
$string['sgrade'] = 'Califica a sesión';
$string['sgrade_desc'] = 'Se se marca esta configuración, a nota obtida formará parte da cualificación da actividade no caderno de cualificacións.';
$string['sgrade_help'] = 'Marque esta configuración se quere que a cualificación obtida nesta sesión forme parte da actividade de cualificación.';
$string['cachedef_grades'] = 'Esta é a descrición das cualificacións da caché de kuet';
$string['qstatus_0'] = 'Incorrecto';
$string['qstatus_1'] = 'Éxito';
$string['qstatus_2'] = 'Parcialmente';
$string['qstatus_3'] = 'Sen resposta';
$string['qstatus_4'] = 'Non avaliable';
$string['qstatus_5'] = 'Non válido';
$string['error_delete_instance'] = 'Produciuse un erro ao eliminar a Kuet.';
$string['session_groupings_error'] = 'Esta actividade está configurada como modo de grupo. Cada sesión debe ter un grupo seleccionado.';
$string['session_groupings_no_members'] = 'A agrupación está baleira. Seleccione unha agrupación con participantes.';
$string['session_groupings_same_user_in_groups'] = 'Os participantes deben formar parte dun só grupo. Consulta estes participantes: {$a}';
$string['groupmode'] = 'Modo equipos';
$string['fakegroup'] = 'Equipo Kuet {$a}';
$string['fakegroupdescription'] = 'A actividade de Kuet creou este grupo porque hai participantes neste curso que non
forman parte da agrupación seleccionada.';
$string['groups'] = 'Equipos';
$string['abbreviationquestion'] = 'P';
$string['timemodemustbeset'] = 'Debe establecerse o tempo total da sesión ou o tempo de preguntas';
$string['timecannotbezero'] = 'O tempo non pode ser cero';
$string['nogroupingscreated'] = 'Esta actividade é de tipo grupo pero neste curso non se crean agrupacións.
É necesario que crees primeiro un agrupamento neste curso para poder elixilo nesta actividade.';
$string['notallowedspecialchars'] = 'Non se permiten caracteres especiais: ?!<>\\';
$string['units'] = 'Unidades';
$string['unit'] = 'Unidade';
$string['statement_improvising'] = 'Pregunta de improvisación - Nube de etiquetas';
$string['waitteacher'] = 'Agardando polo profesor';
$string['teacherimprovising'] = 'O profesor está improvisando unha pregunta "Nube de etiquetas", onde tes que responder a unha pregunta cunha palabra.<br>En canto remate o profesor, aparecerá a pregunta e poderás contestala, para ver as respostas. xunto cos de todos os teus compañeiros.';
$string['statement_improvise'] = 'Declaración da nube de etiquetas';
$string['statement_improvise_help'] = 'Lembra que debería ser unha pregunta que preferiblemente se poida responder nunha palabra.';
$string['reply_improvise'] = 'Resposta';
$string['reply_improvise_help'] = 'Sexa o primeiro en engadir unha palabra á nube de palabras. (Opcional)';
$string['reply_improvise_student_help'] = 'Tenta responder a pregunta cunha palabra.';
$string['submit'] = 'Enviar';
$string['sessionrankingreport'] = 'Informe de clasificación da sesión';
$string['groupsessionrankingreport'] = 'Informe de clasificación da sesión grupal';
$string['sessionquestionsreport'] = 'Informe de preguntas da sesión';
$string['reportlink'] = 'Ligazón de informe';
$string['questionid'] = 'Id';
$string['isevaluable'] = '¿É avaliable?';
$string['alreadyanswered'] = '¡Un membro do teu grupo xa respondeu!';
$string['groupdisconnected'] = 'O grupo {$a} foi desconectado';
$string['groupmemberdisconnected'] = 'Este membro do grupo {$a} foi desconectado';
$string['groupingremoved'] = 'Esta agrupación de actividades eliminouse ou non ten membros. Non podes continuar con esta sesión.';
$string['groupremoved'] = 'Eliminouse o teu grupo ou non é membro desta agrupación de actividades. Non podes continuar con esta sesión.';
$string['gocourse'] = 'Volve ao teu curso';
$string['httpsrequired'] = 'É obrigatorio utilizar o protocolo https na plataforma para usar Kuet.';
$string['sessionsnum'] = 'Número de sesións';
