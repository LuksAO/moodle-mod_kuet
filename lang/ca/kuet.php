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
 * Catalan language strings
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Kuet';
$string['pluginadministration'] = 'Administració de Kuet';
$string['modulename'] = 'Kuet';
$string['modulenameplural'] = 'Kuets';
$string['kuet:addinstance'] = 'Afegeix un nou paquet Kuet';
$string['kuet:view'] = 'Veure Kuet';
$string['kuet:managesessions'] = 'Gestiona les sessions';
$string['kuet:startsession'] = 'Sessions d\'inicialització';
$string['kuet:viewanonymousanswers'] = 'Veure respostes anònimes';
$string['name'] = 'Nom';
$string['introduction'] = 'Descripció';
$string['questiontime'] = 'Hora de preguntes';
$string['questiontime_desc'] = 'Temps per a cada pregunta en segons.';
$string['questiontime_help'] = 'AJUDA! Temps per a cada pregunta en segons.';
$string['completiondetail:answerall'] = 'Participar en una sessió responent preguntes';
$string['completionansweralllabel'] = 'Participar en una sessió.';
$string['completionansweralldesc'] = 'Participar en una sessió responent preguntes.';
$string['configtitle'] = 'Kuet';
$string['generalsettings'] = 'Configuració general';
$string['socket'] = 'Endoll';
$string['sockettype'] = 'Tipus de sòcol';
$string['sockettype_desc'] = 'Es necessita un servidor de socket per iniciar sessions manuals. Aquest sòcol pot ser local o extern: <ul><li><b>Sense sòcol: </b>No s\'utilitzaran els modes de sessió manuals</li><li><b>Socket local: </b>El sòcol s\'iniciarà al mateix servidor que aquesta plataforma (cal tenir certificats).</li><li><b>Extern: </b>Podeu iniciar el sòcol en un servidor extern, proporcionant l\'URL i el port al plataforma de connexió.</li></ul>';
$string['nosocket'] = 'No utilitzeu endoll';
$string['local'] = 'Local';
$string['external'] = 'Extern';
$string['externalurl'] = 'URL extern';
$string['externalurl_desc'] = 'URL on està allotjat el sòcol. Pot ser una IP, però ha de tenir el protocol HTTPS.';
$string['downloadsocket'] = 'Baixeu l\'script per executar-lo en un servidor extern';
$string['downloadsocket_desc'] = 'Baixeu des d\'aquí l\'script per executar-lo en un servidor extern.<br>l\'administrador de la màquina on s\'executa aquest script ha de proporcionar un port i certificats a l\'script.<br>És responsabilitat d\'aquest administrador assegurar-se que el el sòcol funciona en tot moment.<br>';
$string['scriptphp'] = 'Descarrega Script PHP';
$string['certificate'] = 'Certificat';
$string['certificate_desc'] = 'Fitxer .crt o .pem d\'un certificat SSL vàlid per al servidor. És possible que aquest fitxer ja s\'hagi generat al servidor, o bé podeu crear-ne d\'únics per a aquest mod mitjançant eines com ara <a href="https://zerossl.com" target="_blank">zerossl.com</a>.';
$string['privatekey'] = 'Clau privada';
$string['privatekey_desc'] = 'Fitxer .pem o .key d\'una clau privada SSL vàlida per al servidor. És possible que aquest fitxer ja s\'hagi generat al servidor, o bé podeu crear-ne d\'únics per a aquest mod mitjançant eines com ara <a href="https://zerossl.com" target="_blank">zerossl.com</a>.';
$string['testssl'] = 'Prova de connexió';
$string['testssl_desc'] = 'Prova de connexió de socket amb certificats SSl';
$string['validcertificates'] = 'Certificats SSL i port vàlids';
$string['invalidcertificates'] = 'Certificats o port no vàlids';
$string['connectionclosed'] = 'Connexió tancada';
$string['port'] = 'Port';
$string['port_desc'] = 'Port per fer la connexió. Aquest port ha d\'estar obert, de manera que haureu de consultar-ho amb l\'administrador del vostre sistema.';
$string['warningtest'] = 'Això intentarà una connexió al sòcol amb la configuració actual. <b>Deseu la configuració abans de provar.</b>';
$string['session_name'] = 'Nom de la sessió';
$string['session_name_placeholder'] = 'Nom de la sessió';
$string['session_name_help'] = 'Escriu el nom de la sessió';
$string['anonymousanswer'] = 'Respostes anònimes';
$string['anonymousanswer_help'] = 'El professor no sabrà qui respon a les proves en directe';
$string['countdown'] = 'Mostra el compte enrere de preguntes';
$string['randomquestions'] = 'Preguntes aleatòries';
$string['randomanswers'] = 'Respostes aleatòries';
$string['showfeedback'] = 'Mostra comentaris';
$string['showfinalgrade'] = 'Mostra la nota final';
$string['timesettings'] = 'Configuració de l\'hora';
$string['startdate'] = 'Data d\'inici de la sessió';
$string['enddate'] = 'Data de finalització de la sessió';
$string['automaticstart'] = 'Engegada automàtica';
$string['timelimit'] = 'Termini';
$string['accessrestrictions'] = 'Restriccions d\'accés';
$string['next'] = 'Pròxim';
$string['sessions'] = 'Sessions';
$string['sessions_info'] = 'Es mostren totes les sessions';
$string['reports'] = 'Informes';
$string['reports_info'] = 'Es mostren totes les sessions finalitzades per accedir a l\'informe.';
$string['sessionreport'] = 'Informe de sessió';
$string['sessionreport_info'] = 'Es mostra l\'informe de la sessió.';
$string['report'] = 'Informeu';
$string['active_sessions'] = 'Sessions actives';
$string['completed_sessions'] = 'Sessions acabades';
$string['create_session'] = 'Crear sessió';
$string['questions_number'] = 'Nombre de preguntes';
$string['question_number'] = 'No de pregunta';
$string['session_date'] = 'Data';
$string['session_finishingdate'] = 'Data de finalització';
$string['session_actions'] = 'Accions';
$string['init_session'] = 'Sessió inicial';
$string['init_session_desc'] = 'Si inicieu una sessió manualment, podeu bloquejar les sessions programades amb l\'inici automàtic. Assegureu-vos que no hi hagi sessions properes abans d\'iniciar aquesta sessió.<br>Esteu segur que voleu iniciar la sessió?';
$string['end_session'] = 'Sessió final';
$string['end_session_error'] = 'La sessió no s\'ha pogut finalitzar a causa d\'un error en la comunicació amb el servidor. Torneu-ho a provar.';
$string['end_session_desc'] = 'Esteu segur que voleu acabar la sessió?';
$string['end_session_manual_desc'] = 'Si acabes la sessió, tancaràs la connexió de tots els estudiants i ja no podran respondre aquest qüestionari.<br><b>Estàs segur que vols finalitzar la sessió?</b>';
$string['viewreport_session'] = 'Veure informe';
$string['edit_session'] = 'Edita sessió';
$string['copy_session'] = 'Sessió de còpia';
$string['delete_session'] = 'Suprimeix la sessió';
$string['copysession'] = 'Sessió de còpia';
$string['copysession_desc'] = 'Esteu segur que voleu copiar aquesta sessió? Si la sessió té dates d\'inici o d\'inici i finalització automàtiques, caldrà restablir-les.';
$string['copysessionerror'] = 's\'ha produït un error en copiar la sessió. Comproveu que teniu la capacitat "mod/kuet:managesessions" o torneu-ho a provar més tard.';
$string['deletesession'] = 'Suprimeix la sessió';
$string['deletesession_desc'] = 'Esteu segur que voleu suprimir aquesta sessió?';
$string['deletesessionerror'] = 's\'ha produït un error en suprimir la sessió. Comproveu que teniu la capacitat "mod/kuet:managesessions" o torneu-ho a provar més tard.';
$string['confirm'] = 'Confirmeu';
$string['copy'] = 'Còpia';
$string['groupings'] = 'Agrupacions';
$string['anonymiseresponses'] = 'Anònim les respostes dels estudiants';
$string['noanonymiseresponses'] = 'No anonimitzeu les respostes dels estudiants';
$string['sessionconfiguration'] = 'Configuració de la sessió';
$string['sessionconfiguration_info'] = 'Configura la teva pròpia sessió';
$string['questionsconfiguration'] = 'Configuració de preguntes';
$string['questionsconfiguration_info'] = 'Afegiu les preguntes a la sessió';
$string['summarysession'] = 'Resum de la sessió';
$string['summarysession_info'] = 'Revisa la sessió';
$string['sessionstarted'] = 'La sessió ha començat';
$string['multiplesessionerror'] = 'Aquesta sessió no està activa o no existeix.';
$string['notactivesession'] = 'Vaja, sembla que el teu professor encara no ha inicialitzat cap sessió...';
$string['notactivesessionawait'] = 'Espereu que el iniciï o consulteu els vostres darrers informes.';
$string['nextsession'] = 'Pròxima sessió:';
$string['nosession'] = 'Cap sessió inicialitzada pel professor';
$string['questions_list'] = 'Preguntes seleccionades';
$string['questions_bank'] = 'Banc de preguntes';
$string['question_position'] = 'Posició';
$string['question_name'] = 'Nom';
$string['question_type'] = 'Tipus';
$string['question_version'] = 'Versió';
$string['question_isvalid'] = 'És vàlid';
$string['question_actions'] = 'Accions';
$string['improvise_cloudtags'] = 'Improvisar etiquetes de núvol';
$string['select_category'] = 'Selecciona una categoria';
$string['go_questionbank'] = 'Aneu al banc de preguntes';
$string['selectall'] = 'Seleccioneu/desseleccioneu-ho tot';
$string['selectvisibles'] = 'Seleccioneu/desseleccioneu visibles';
$string['add_questions'] = 'Afegeix preguntes';
$string['number_select'] = 'Preguntes seleccionades:';
$string['changecategory'] = 'Canvi de categoria';
$string['changecategory_desc'] = 'Heu seleccionat preguntes que no s\'han afegit a la sessió. Si canvies de categoria, perdràs aquesta selecció. Vols continuar?';
$string['selectone'] = 'Seleccioneu preguntes';
$string['selectone_desc'] = 'Seleccioneu almenys una pregunta per afegir a la sessió.';
$string['addquestions'] = 'Afegeix preguntes';
$string['addquestions_desc'] = 'Esteu segur d\'afegir {$a} preguntes a la sessió?';
$string['deletequestion'] = 'Elimina una pregunta de la sessió';
$string['deletequestion_desc'] = 'Esteu segur d\'eliminar aquesta pregunta de la sessió?';
$string['gradesheader'] = 'Classificació de preguntes';
$string['nograding'] = 'Ignora la resposta correcta i la qualificació';
$string['sessionalreadyexists'] = 'El nom de la sessió ja existeix';
$string['showgraderanking'] = 'Mostra la classificació entre preguntes';
$string['question_nosuitable'] = 'No és adequat amb el connector kuet.';
$string['configuration'] = 'Configuració';
$string['end'] = 'Final';
$string['questionidnotsent'] = 'qüestionat no enviat';
$string['question_index_string'] = '{$a->num} de {$a->total}';
$string['question'] = 'Pregunta';
$string['feedback'] = 'Feedback';
$string['session_info'] = 'Informació de la sessió';
$string['results'] = 'Resultats';
$string['students'] = 'Estudiants';
$string['corrects'] = 'Corregeix';
$string['incorrects'] = 'Incorrectes';
$string['notanswers'] = 'Sense resposta';
$string['points'] = 'Punts';
$string['inactive_manual'] = 'Manual inactiu';
$string['inactive_programmed'] = 'Programat inactiu';
$string['podium_manual'] = 'Podium manual';
$string['podium_programmed'] = 'Podium programat';
$string['race_manual'] = 'Carrera manual';
$string['race_programmed'] = 'Cursa programada';
$string['sessionmode'] = 'Mode sessió';
$string['sessionmode_help'] = 'Els modes de sessió mostren diferents maneres d\'utilitzar les sessions de kuet.';
$string['countdown_help'] = 'Activeu aquesta opció perquè els estudiants puguin veure el compte enrere a cada pregunta. (Només si la pregunta té temps)';
$string['showgraderanking_help'] = 'El professor no veurà la classificació durant una sessió en directe. Només disponible en els modes de sessió de podis.';
$string['showgraderankinghelp'] = 'SIN _El professor no veurà la classificació durant una sessió en directe. Només disponible en els modes de sessió de podis.';
$string['randomquestions_help'] = 'Les preguntes apareixeran en un ordre aleatori per a cada alumne. Només vàlid per al mode de sessió programada.';
$string['randomanswers_help'] = 'Les respostes apareixeran en un ordre aleatori per a cada alumne.';
$string['showfeedback_help'] = 'Després de respondre cada pregunta, apareixerà un comentari. En el mode manual, el professor pot mostrar o amagar els comentaris per a cada pregunta (només si la pregunta conté comentaris).';
$string['showfinalgrade_help'] = 'La nota final apareixerà un cop finalitzada la sessió.';
$string['startdate_help'] = 'La sessió començarà automàticament en aquesta data. La data d\'inici només estarà disponible amb les sessions programades.';
$string['enddate_help'] = 'La sessió finalitzarà automàticament en aquesta data. La data de finalització només estarà disponible amb les sessions programades.';
$string['automaticstart_help'] = 'La sessió començarà i finalitzarà automàticament si s\'estableixen dates, de manera que no s\'hagi d\'iniciar manualment.';
$string['timelimit_help'] = 'Temps total de la sessió';
$string['waitingroom'] = 'Sala d\'espera';
$string['waitingroom_info'] = 'Comprova que tot sigui correcte abans de començar la sessió.';
$string['sessionstarted_info'] = 'Heu començat la sessió, heu de fer un seguiment de les preguntes.';
$string['participants'] = 'Participants';
$string['waitingroom_message'] = '';
$string['ready_users'] = 'Participants preparats';
$string['ready_groups'] = 'Grups preparats';
$string['session_closed'] = 'La connexió s\'ha tancat:';
$string['session_closed_info'] = 'Això pot ser perquè la sessió ha finalitzat, perquè el professor ha finalitzat la sessió o per un problema tècnic amb la connexió. Si us plau, torneu a iniciar sessió a la sessió per tornar a connectar-vos o poseu-vos en contacte amb el vostre professor.';
$string['system_error'] = 's\'ha produït un error i la connexió s\'ha tancat.<br>No és possible continuar amb la sessió.';
$string['connection_closed'] = 'Connexió tancada {$a->reason} - {$a->code}';
$string['backtopanelfromsession'] = 'Tornar al tauler de sessions?';
$string['backtopanelfromsession_desc'] = 'Si torneu, la sessió no s\'inicialitzarà i la podreu tornar a iniciar en qualsevol moment. Voleu tornar al tauler de sessió?';
$string['lowspeed'] = 'La vostra connexió a Internet sembla lenta o inestable ({$a->downlink} Mbps, {$a->effectiveType}). Això pot provocar un comportament inesperat o un tancament sobtat de la sessió.<br>Us recomanem que no inicieu la sessió fins que no tingueu una bona connexió a Internet.';
$string['alreadyteacher'] = 'Ja hi ha un professor que imparteix aquesta sessió, així que no us podeu connectar. Espereu que finalitzi la sessió actual abans de poder entrar.';
$string['userdisconnected'] = 'l\'usuari {$a} ha estat desconnectat.';
$string['qtimelimit_help'] = 'Hora de respondre la pregunta. Útil quan el temps de sessió és la suma del temps de preguntes.';
$string['sessionlimittimebyquestionsenabled'] = 'Aquesta sessió té un límit de temps de {$a}. El temps total de cada pregunta es calcularà dividint el temps total pel nombre de preguntes.<br>Si voleu afegir un temps per pregunta, heu d\'especificar el mode de sessió a "Temps per pregunta", especificar un temps predeterminat. , i després podeu establir un temps per a cada pregunta mitjançant aquest formulari.';
$string['notimelimitenabled'] = 'La sessió s\'estableix sense límit de temps.<br>Si voleu afegir un temps per pregunta, heu d\'especificar el mode de sessió a "Temps per pregunta", especificar un temps predeterminat i, a continuació, podeu definir un temps per a cada pregunta mitjançant aquesta forma.';
$string['incompatible_question'] = 'Pregunta no compatible';
$string['controlpanel'] = 'Panell de control';
$string['control'] = 'Control';
$string['pause'] = 'Pausa';
$string['play'] = 'Jugar';
$string['resend'] = 'Reenviar';
$string['jump'] = 'Saltar';
$string['finishquestion'] = 'Acaba la pregunta';
$string['showhide'] = 'Mostra/amaga';
$string['responses'] = 'Respostes';
$string['statistics'] = 'Estadístiques';
$string['questions'] = 'Preguntes';
$string['improvise'] = 'Improvisar';
$string['vote'] = 'Vota';
$string['vote_tags'] = 'Etiquetes de vot';
$string['incorrect_sessionmode'] = 'Mode de sessió incorrecte';
$string['endsession'] = 'Sessió acabada';
$string['endsession_info'] = 'Heu arribat al final de la sessió i ara podeu veure l\'informe amb els vostres resultats o continuar amb el curs.';
$string['timemode'] = 'Mode horari';
$string['no_time'] = 'No hi ha temps';
$string['session_time'] = 'Temps total de la sessió';
$string['session_time_resume'] = 'Temps total de la sessió: {$a}';
$string['sessiontime'] = 'Temps de sessió';
$string['timeperquestion'] = 'Temps per pregunta';
$string['sessiontime_help'] = 'El temps establert s\'ha de dividir pel nombre de preguntes i s\'ha d\'assignar el mateix temps a totes les preguntes.';
$string['question_time'] = 'Temps per pregunta';
$string['question_time_help'] = 's\'establirà un temps definit per a cada pregunta (pots fer-ho després d\'afegir la pregunta a la sessió). s\'establirà un temps predeterminat per assignar a aquelles preguntes que no tinguin un temps definit.';
$string['timemode_help'] = 'Cal tenir en compte que el temps per a cada pregunta correspon al temps permès per "contestar", ja que respondre cada pregunta aturarà el temps fins que l\'usuari passi a la següent.<br><br><b>Sense temps: </b> No hi ha temps per acabar la sessió. Es pot establir temps per a cada pregunta, alguna o cap (al tauler de preguntes).<br><b>Temps total de la sessió:</b> el temps establert es dividirà pel nombre de preguntes i s\'assignarà el mateix temps. a totes les preguntes.<br><b>Temps per pregunta:</b> s\'establirà un temps definit per a cada pregunta (pots fer-ho després d\'afegir la pregunta a la sessió). s\'establirà un temps predeterminat per assignar a aquelles preguntes que no tinguin un temps definit.<br><br><b>Important:</b> si en una pregunta cronometrada l\'usuari tanca el navegador o actualitza la pàgina, això La pregunta es considerarà no lliurada, ja que s\'entendrà com un intent de guanyar temps per respondre.';
$string['erroreditsessionactive'] = 'No és possible editar una sessió activa.';
$string['activesessionmanagement'] = 'Gestió activa de sessions';
$string['sessionnoquestions'] = 'No s\'ha afegit cap pregunta a la sessió.';
$string['sessioncreating'] = 'No heu acabat d\'editar aquesta sessió. Heu d\'arribar al pas 3 d\'edició i fer clic a Finalitzar.';
$string['sessionconflict'] = 'Aquesta sessió té un conflicte de data amb altres sessions més properes i no s\'iniciarà automàticament fins que no es resolgui el conflicte.';
$string['sessionwarning'] = 'Aquesta sessió hauria d\'haver començat, però actualment hi ha una sessió activa que ho impedeix. s\'iniciarà automàticament tan bon punt finalitzi la sessió activa.';
$string['sessionerror'] = 'Aquesta sessió no està configurada correctament';
$string['startminorend'] = 'La data de finalització de la sessió no pot ser igual ni inferior a la data d\'inici.';
$string['previousstarterror'] = 'La data d\'inici no pot ser inferior a la data actual.';
$string['sessionmanualactivated'] = 'La sessió {$a->sessionid} està activa a kuetid -> {$a->kuetid}. La resta de la sessió s\'omet fins al final d\'aquesta sessió.';
$string['sessionactivated'] = 'Sessió {$a->sessionid} activada per a kuetid {$a->kuetid}';
$string['sessionfinished'] = 'Sessió {$a->sessionid} acabada per a kuetid {$a->kuetid}';
$string['sessionfinishedformoreone'] = 'La sessió {$a->sessionid} s\'ha acabat per a kuetid {$a->kuetid} perquè hi ha més d\'una sessió activa.';
$string['error_initsession'] = 'Error d\'inici de sessió';
$string['error_initsession_desc'] = 'La sessió no s\'ha pogut iniciar, ja sigui perquè ja s\'ha iniciat una sessió o per un error concret. Actualitzeu la pàgina i torneu-ho a provar.';
$string['success'] = 'Èxit';
$string['noresponse'] = 'Sense resposta';
$string['noevaluable'] = 'No avaluable';
$string['invalid'] = 'Invàlid';
$string['ranking'] = 'Classificació';
$string['participant'] = 'Participant';
$string['score'] = 'Puntuació';
$string['viewreport_user'] = 'Informe d\'usuari';
$string['viewreport_group'] = 'Informe del grup';
$string['otheruserreport'] = '';
$string['userreport'] = 'Informe de sessió d\'usuari';
$string['userreport_info'] = 'Es mostren els resultats d\'una sessió per a un usuari.';
$string['groupreport'] = 'Informe de sessió grupal';
$string['groupreport_info'] = 'Es mostren els resultats d\'una sessió per a un grup.';
$string['viewquestion_user'] = 'Veure resposta';
$string['questionreport'] = 'Informe de preguntes';
$string['questionreport_info'] = 'Es mostra l\'informe d\'una pregunta en una sessió.';
$string['preview'] = 'Vista prèvia';
$string['percent_correct'] = '% d\'èxit';
$string['percent_incorrect'] = '% d\'incorrectes';
$string['percent_partially'] = '% Corregeix parcialment';
$string['percent_noresponse'] = '% Sense resposta';
$string['student_number'] = 'Nº d\'alumnes';
$string['correct'] = 'Correcte';
$string['incorrect'] = 'Incorrecte';
$string['response'] = 'Resposta';
$string['score_moment'] = 'Puntuació de la pregunta';
$string['time'] = 'Temps';
$string['status'] = 'Estat';
$string['anonymousanswers'] = 'Les respostes a aquest qüestionari són anònimes.';
$string['kuetnotexist'] = 'No s\'ha pogut trobar kuet amb l\'identificador {$a}';
$string['jumpto_error'] = 'Ha de ser un número entre 1 i {$a}';
$string['session'] = 'Sessió';
$string['send_response'] = 'Enviar resposta';
$string['partially_correct'] = 'Parcialment correcte';
$string['partially'] = 'Parcialment';
$string['scored_answers'] = 'Respostes puntuades';
$string['provisional_ranking'] = 'Classificació provisional';
$string['final_ranking'] = 'Classificació final';
$string['score_obtained'] = 'Puntuació obtinguda';
$string['total_score'] = 'Puntuació total';
$string['grademethod'] = 'Mètode de qualificació';
$string['grademethod_help'] = '';
$string['nograde'] = 'Sense qualificacions';
$string['gradehighest'] = 'Sessió amb la nota més alta';
$string['gradeaverage'] = 'Mitjana de les sessions de notes';
$string['firstsession'] = 'Grau de la primera sessió';
$string['lastsession'] = 'Nota de l\'última sessió';
$string['sessionended'] = 'Sessió acabada';
$string['sessionended_desc'] = 'Quan un usuari acaba una sessió, s\'activa un esdeveniment per calcular la qualificació de la sessió.';
$string['sgrade'] = 'Avalua la sessió';
$string['sgrade_desc'] = 'Si aquesta configuració està marcada, la nota obtinguda formarà part de la nota de l\'activitat del llibre de qualificacions.';
$string['sgrade_help'] = 'Marqueu aquesta configuració si voleu que la nota obtinguda en aquesta sessió formi part de la nota de l\'activitat.';
$string['cachedef_grades'] = 'Aquesta és la descripció de les qualificacions de la memòria cau de kuet';
$string['qstatus_0'] = 'Incorrecte';
$string['qstatus_1'] = 'Èxit';
$string['qstatus_2'] = 'Parcialment';
$string['qstatus_3'] = 'Sense resposta';
$string['qstatus_4'] = 'No avaluable';
$string['qstatus_5'] = 'Invàlid';
$string['error_delete_instance'] = 's\'ha produït un error en suprimir el mod Kuet.';
$string['session_groupings_error'] = 'Aquesta activitat s\'estableix com a mode de grup. Cada sessió ha de tenir un grup seleccionat.';
$string['session_groupings_no_members'] = 'l\'agrupació és buida. Si us plau, seleccioneu una agrupació amb participants.';
$string['session_groupings_same_user_in_groups'] = 'Els participants han de formar part d\'un sol grup. Comproveu aquests participants: {$a}';
$string['groupmode'] = 'Mode equips';
$string['fakegroup'] = 'Equip de Kuet {$a}';
$string['fakegroupdescription'] = 'que no formen part de l\'agrupació seleccionada.';
$string['groups'] = 'Equips';
$string['abbreviationquestion'] = 'Q';
$string['timemodemustbeset'] = 's\'ha d\'establir el temps total de la sessió o el temps de preguntes';
$string['timecannotbezero'] = 'El temps no pot ser zero';
$string['nogroupingscreated'] = 'Cal que en primer lloc creeu un agrupament en aquest curs per poder escollir-lo en
aquesta activitat.';
$string['notallowedspecialchars'] = 'No es permeten caràcters especials: ?!<>\\';
$string['units'] = 'Unitats';
$string['unit'] = 'Unitat';
$string['statement_improvising'] = 'Núvol d\'etiquetes de la pregunta d\'improvisació';
$string['waitteacher'] = 'Esperant el professor';
$string['teacherimprovising'] = 'El professor està improvisant una pregunta "Núvol d\'etiquetes", on has de respondre una
pregunta amb una paraula.<br>Tan aviat com acabi el professor, apareixerà la pregunta i podràs respondre-la, per veure les respostes. juntament amb els de tots els teus companys.';
$string['statement_improvise'] = 'Declaració del núvol d\'etiquetes';
$string['statement_improvise_help'] = 'Recordeu que hauria de ser una pregunta que preferiblement es pugui respondre amb una paraula.';
$string['reply_improvise'] = 'Resposta';
$string['reply_improvise_help'] = 'Sigues el primer a afegir una paraula al núvol de paraules. (Opcional)';
$string['reply_improvise_student_help'] = 'Intenta respondre la pregunta amb una paraula.';
$string['submit'] = 'Presentar';
$string['sessionrankingreport'] = 'Informe de classificació de la sessió';
$string['groupsessionrankingreport'] = 'Informe de classificació de la sessió de grup';
$string['sessionquestionsreport'] = 'Informe de preguntes de la sessió';
$string['reportlink'] = 'Enllaç de l\'informe';
$string['questionid'] = 'Id';
$string['isevaluable'] = 'És avaluable?';
$string['alreadyanswered'] = 'Un membre del teu grup ja ha contestat!';
$string['groupdisconnected'] = 'El grup {$a} s\'ha desconnectat';
$string['groupmemberdisconnected'] = 'Aquest membre del grup {$a} s\'ha desconnectat';
$string['groupingremoved'] = 'Aquesta agrupació d\'activitats s\'ha eliminat o no té membres. No podeu continuar amb aquesta sessió.';
$string['groupremoved'] = 'El vostre grup s\'ha eliminat o no és membre d\'aquesta agrupació d\'activitats. No podeu continuar amb aquesta sessió.';
$string['gocourse'] = 'Torna al teu curs';
$string['httpsrequired'] = 'És obligatori utilitzar el protocol https a la plataforma per utilitzar Kuet.';
$string['sessionsnum'] = 'Nombre de sessions';
