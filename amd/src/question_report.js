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
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos.

/**
 *
 * @module    mod_jqshow/question_report
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

"use strict";
/* eslint-disable no-unused-vars */

import jQuery from 'jquery';
import Templates from 'core/templates';
import ModalFactory from 'core/modal_factory';
import ModalEvents from 'core/modal_events';
import ModalJqshow from 'mod_jqshow/modal';
import Ajax from 'core/ajax';
import Notification from 'core/notification';
import {get_string as getString} from 'core/str';

let REGION = {
    ROOT: '[data-region="question-report"]', // This root.
    LOADING: '[data-region="overlay-icon-container"]',
};

let ACTION = {
    QUESTIONPREVIEW: '[data-action="question-preview"]',
    SEEANSWER: '[data-action="seeanswer"]',
};

let SERVICES = {
    GETQUESTION: 'mod_jqshow_getquestion',
    USERQUESTIONRESPONSE: 'mod_jqshow_getuserquestionresponse'
};

let TEMPLATES = {
    LOADING: 'core/overlay_loading',
    QUESTION: 'mod_jqshow/questions/encasement'
};

QuestionReport.prototype.root = null;

/**
 * @constructor
 * @param {String} region
 */
function QuestionReport(region) {
    this.root = jQuery(region);
    this.root.find(ACTION.QUESTIONPREVIEW).on('click', this.questionPreview);
    this.root.find(ACTION.SEEANSWER).on('click', this.seeAnswer);
}

QuestionReport.prototype.questionPreview = function(e) {
    e.preventDefault();
    e.stopPropagation();
    let sessionId = jQuery(e.currentTarget).attr('data-sessionid');
    let questionnId = jQuery(e.currentTarget).attr('data-questionnid');
    let cmId = jQuery(e.currentTarget).attr('data-cmid');
    Templates.render(TEMPLATES.LOADING, {visible: true}).done(function(html) {
        let identifier = jQuery(REGION.ROOT);
        identifier.append(html);
        let request = {
            methodname: SERVICES.GETQUESTION,
            args: {
                cmid: cmId,
                sid: sessionId,
                jqid: questionnId
            }
        };
        Ajax.call([request])[0].done(function(question) {
            Templates.render(TEMPLATES.QUESTION, question).then(function(html, js) {
                getString('preview', 'mod_jqshow').done((title) => {
                    ModalFactory.create({
                        classes: 'modal_jqshow',
                        body: html,
                        title: title,
                        footer: '',
                        type: ModalJqshow.TYPE
                    }).then(modal => {
                        modal.getRoot().on(ModalEvents.hidden, function() {
                            modal.destroy();
                        });
                        jQuery(REGION.LOADING).remove();
                        modal.show();
                        Templates.runTemplateJS(js);
                    }).fail(Notification.exception);
                }).fail(Notification.exception);
            });
        });
    });
};

QuestionReport.prototype.seeAnswer = function(e) {
    e.preventDefault();
    e.stopPropagation();
    let userId = jQuery(e.currentTarget).attr('data-userid');
    let sessionId = jQuery(e.currentTarget).attr('data-sessionid');
    let questionnId = jQuery(e.currentTarget).attr('data-questionnid');
    let cmId = jQuery(e.currentTarget).attr('data-cmid');
    Templates.render(TEMPLATES.LOADING, {visible: true}).done(function(html) {
        let identifier = jQuery(REGION.ROOT);
        identifier.append(html);
        let request = {
            methodname: SERVICES.GETQUESTION,
            args: {
                cmid: cmId,
                sid: sessionId,
                jqid: questionnId
            }
        };
        Ajax.call([request])[0].done(function(question) {
            let requestAnswer = {
                methodname: SERVICES.USERQUESTIONRESPONSE,
                args: {
                    jqid: question.jqid,
                    cmid: cmId,
                    sid: sessionId,
                    uid: userId,
                    preview: true
                }
            };
            Ajax.call([requestAnswer])[0].done(function(answer) {
                const questionData = {
                    ...question,
                    ...answer
                };
                getString('viewquestion_user', 'mod_jqshow').done((title) => {
                    Templates.render(TEMPLATES.QUESTION, questionData).then(function(html, js) {
                        ModalFactory.create({
                            classes: 'modal_jqshow',
                            body: html,
                            title: title,
                            footer: '',
                            type: ModalJqshow.TYPE
                        }).then(modal => {
                            modal.getRoot().on(ModalEvents.hidden, function() {
                                modal.destroy();
                            });
                            jQuery(REGION.LOADING).remove();
                            modal.show();
                            Templates.runTemplateJS(js);
                        }).fail(Notification.exception);
                    }).fail(Notification.exception);
                }).fail(Notification.exception);
            });
        });
    });
};

export const questionReport = (region) => {
    return new QuestionReport(region);
};
