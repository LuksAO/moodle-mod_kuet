"use strict";

import jQuery from 'jquery';
import Ajax from 'core/ajax';
import Notification from 'core/notification';
import Templates from 'core/templates';

let ACTION = {
    REPLY: '[data-action="multichoice-answer"]',
    MULTIANSWER: '[data-action="multichoice-multianswer"]',
    SENDMULTIANSWER: '[data-action="send-multianswer"]'
};

let REGION = {
    ROOT: '[data-region="question-content"]',
    MULTICHOICE: '[data-region="multichoice"]',
    LOADING: '[data-region="overlay-icon-container"]',
    CONTENTFEEDBACKS: '[data-region="containt-feedbacks"]',
    FEEDBACK: '[data-region="statement-feedback"]',
    FEEDBACKANSWER: '[data-region="answer-feedback"]',
    FEEDBACKBACGROUND: '[data-region="feedback-background"]',
    STATEMENTTEXT: '[data-region="statement-text"]',
    TIMER: '[data-region="question-timer"]',
    SECONDS: '[data-region="seconds"]',
    NEXT: '[data-action="next-question"]',
    ANSWERCHECKED: '.answer-checked'
};

let SERVICES = {
    REPLY: 'mod_jqshow_multichoice'
};

let TEMPLATES = {
    LOADING: 'core/overlay_loading'
};

let cmId;
let sId;
let questionid;
let jqshowId;
let jqid;
let questionEnd = false;
let correctAnswers = null;
let showQuestionFeedback = false;
let manualMode = false;

/**
 * @constructor
 * @param {String} selector
 * @param {Boolean} showquestionfeedback
 * @param {Boolean} manualmode
 * @param {String} jsonresponse
 */
function MultiChoice(selector, showquestionfeedback = false, manualmode = false, jsonresponse = '') {
    this.node = jQuery(selector);
    sId = this.node.attr('data-sid');
    cmId = this.node.attr('data-cmid');
    questionid = this.node.attr('data-questionid');
    jqshowId = this.node.attr('data-jqshowid');
    jqid = this.node.attr('data-jqid');
    showQuestionFeedback = showquestionfeedback;
    manualMode = manualmode;
    questionEnd = false;
    if (jsonresponse !== '') {
        this.answered(JSON.parse(jsonresponse));
        if (manualMode === false || jQuery('.modal-body').length) {
            this.showAnswers();
            if (showQuestionFeedback === true) {
                this.showFeedback();
            }
        }
    }
    this.initMultichoice();
}

/** @type {jQuery} The jQuery node for the page region. */
MultiChoice.prototype.node = null;
MultiChoice.prototype.endTimer = new Event('endTimer');
MultiChoice.prototype.studentQuestionEnd = new Event('studentQuestionEnd');

MultiChoice.prototype.initMultichoice = function() {
    this.node.find(ACTION.REPLY).on('click', this.reply.bind(this));
    this.node.find(ACTION.MULTIANSWER).on('click', this.markAnswer.bind(this));
    this.node.find(ACTION.SENDMULTIANSWER).on('click', this.reply.bind(this));
    let that = this;
    addEventListener('timeFinish', () => {
        this.reply();
    }, {once: true});
    addEventListener('teacherQuestionEnd_' + jqid, (e) => {
        if (questionEnd !== true) {
            this.reply();
        }
        e.detail.statistics.forEach((statistic) => {
            jQuery('[data-answerid="' + statistic.answerid + '"] .numberofreplies').html(statistic.numberofreplies);
        });
    }, {once: true});
    addEventListener('pauseQuestion_' + jqid, () => {
        this.pauseQuestion();
    }, false);
    addEventListener('playQuestion_' + jqid, () => {
        this.playQuestion();
    }, false);
    addEventListener('showAnswers_' + jqid, () => {
        this.showAnswers();
    }, false);
    addEventListener('hideAnswers_' + jqid, () => {
        this.hideAnswers();
    }, false);
    addEventListener('showStatistics_' + jqid, () => {
        this.showStatistics();
    }, false);
    addEventListener('hideStatistics_' + jqid, () => {
        this.hideStatistics();
    }, false);
    addEventListener('showFeedback_' + jqid, () => {
        this.showFeedback();
    }, false);
    addEventListener('hideFeedback_' + jqid, () => {
        this.hideFeedback();
    }, false);
    window.onbeforeunload = function() {
        if (jQuery(REGION.SECONDS).length > 0 && questionEnd === false) {
            that.reply();
            return 'Because the question is overdue and an attempt has been made to reload the page,' +
                ' the question has remained unanswered.';
        }
    };
};

MultiChoice.prototype.reply = function(e) {
    let answerIds = '0';
    let that = this;
    let multiAnswer = e === undefined || jQuery(e.currentTarget).attr('data-action') === 'send-multianswer';
    if (!multiAnswer) {
        e.preventDefault();
        e.stopPropagation();
        answerIds = jQuery(e.currentTarget).attr('data-answerid');
    } else { // MultiAnswer or empty.
        let responses = [];
        jQuery(REGION.ANSWERCHECKED).each(function(index, response) {
            responses.push(jQuery(response).attr('data-answerid'));
        });
        answerIds = responses.toString();
    }
    Templates.render(TEMPLATES.LOADING, {visible: true}).done(function(html) {
        that.node.append(html);
        dispatchEvent(that.endTimer);
        let timeLeft = parseInt(jQuery(REGION.SECONDS).text());
        let request = {
            methodname: SERVICES.REPLY,
            args: {
                answerids: answerIds,
                sessionid: sId,
                jqshowid: jqshowId,
                cmid: cmId,
                questionid: questionid,
                jqid: jqid,
                timeleft: timeLeft || 0,
                preview: false
            }
        };
        Ajax.call([request])[0].done(function(response) {
            if (response.reply_status === true) {
                if (!multiAnswer) {
                    jQuery(e.currentTarget).css({'z-index': 3, 'pointer-events': 'none'});
                } else {
                    let responses = answerIds.split(',');
                    responses.forEach((rId) => {
                        jQuery('[data-answerid="' + rId + '"]')
                            .css({'z-index': 3, 'pointer-events': 'none'})
                            .removeClass('answer-checked');
                    });
                    jQuery(ACTION.SENDMULTIANSWER).addClass('d-none');
                }
                that.answered(response);
                questionEnd = true;
                dispatchEvent(that.studentQuestionEnd);
                if (jQuery('.modal-body').length) { // Preview.
                    that.showAnswers();
                    if (showQuestionFeedback === true) {
                        that.showFeedback();
                    }
                } else {
                    if (manualMode === false) {
                        that.showAnswers();
                        if (showQuestionFeedback === true) {
                            that.showFeedback();
                        }
                    }
                }
            } else {
                alert('error');
            }
            jQuery(REGION.LOADING).remove();
        }).fail(Notification.exception);
    });
};

MultiChoice.prototype.markAnswer = function(e) {
    if (jQuery(e.currentTarget).hasClass('answer-checked')) {
        jQuery(e.currentTarget).removeClass('answer-checked');
    } else {
        jQuery(e.currentTarget).addClass('answer-checked');
    }
};

MultiChoice.prototype.answered = function(response) {
    questionEnd = true;
    if (response.hasfeedbacks) {
        jQuery(REGION.FEEDBACK).html(response.statment_feedback);
        jQuery(REGION.FEEDBACKANSWER).html(response.answer_feedback);
    }
    jQuery(REGION.FEEDBACKBACGROUND).css('display', 'block');
    jQuery(REGION.STATEMENTTEXT).css({'z-index': 3, 'padding': '15px'});
    jQuery(REGION.TIMER).css('z-index', 3);
    jQuery(REGION.NEXT).removeClass('d-none');
    if (response.answerids && response.answerids !== '') {
        let responses = response.answerids.split(',');
        responses.forEach((rId) => {
            jQuery('[data-answerid="' + rId + '"]').css({'z-index': 3, 'pointer-events': 'none'});
        });
        jQuery(ACTION.SENDMULTIANSWER).addClass('d-none');
    }
    if (response.correct_answers) {
        correctAnswers = response.correct_answers;
        jQuery(REGION.FEEDBACKBACGROUND).css('height', '100%');
    }
    if (response.statistics) {
        response.statistics.forEach((statistic) => {
            jQuery('[data-answerid="' + statistic.answerids + '"] .numberofreplies').html(statistic.numberofreplies);
        });
    }
};

MultiChoice.prototype.pauseQuestion = function() {
    dispatchEvent(new Event('pauseQuestion'));
    jQuery(REGION.TIMER).css('z-index', 3);
    jQuery(REGION.FEEDBACKBACGROUND).css('display', 'block');
    jQuery(ACTION.REPLY).css('pointer-events', 'none');
};

MultiChoice.prototype.playQuestion = function() {
    dispatchEvent(new Event('playQuestion'));
    jQuery(REGION.TIMER).css('z-index', 1);
    jQuery(REGION.FEEDBACKBACGROUND).css('display', 'none');
    jQuery(ACTION.REPLY).css('pointer-events', 'auto');
};

MultiChoice.prototype.showAnswers = function() {
    if (correctAnswers !== null && questionEnd === true) {
        jQuery('.feedback-icon').css('display', 'flex');
        let correctAnswersSplit = correctAnswers.split(',');
        correctAnswersSplit.forEach((answ) => {
            jQuery('[data-answerid="' + answ + '"] .incorrect').css('display', 'none');
        });
    }
};

MultiChoice.prototype.hideAnswers = function() {
    if (questionEnd === true) {
        jQuery('.feedback-icon').css('display', 'none');
    }
};

MultiChoice.prototype.showStatistics = function() {
    if (questionEnd === true) {
        jQuery('.statistics-icon').css('display', 'flex');
    }
};

MultiChoice.prototype.hideStatistics = function() {
    if (questionEnd === true) {
        jQuery('.statistics-icon').css('display', 'none');
    }
};

MultiChoice.prototype.showFeedback = function() {
    if (questionEnd === true) {
        jQuery(REGION.CONTENTFEEDBACKS).css({'display': 'block', 'z-index': 3});
    }
};

MultiChoice.prototype.hideFeedback = function() {
    if (questionEnd === true) {
        jQuery(REGION.CONTENTFEEDBACKS).css({'display': 'none', 'z-index': 0});
    }
};

export const initMultiChoice = (selector, showquestionfeedback, manualmode, jsonresponse) => {
    return new MultiChoice(selector, showquestionfeedback, manualmode, jsonresponse);
};
