/**
 * jQuery Form Validator
 * ------------------------------------------
 *
 * Spanish language package
 *
 * @website http://formvalidator.net/
 * @license Dual licensed under the MIT or GPL Version 2 licenses
 * @version 2.2.83
 */
(function($, window) {

  "use strict";

  $(window).bind('validatorsLoaded', function() {

    $.formUtils.LANG = {
      errorTitle: 'El formulario no se ha podido enviar!',
      requiredFields: 'No ha respondido a todas las preguntas',
      badTime: 'No ha introducido la hora correcta',
      badEmail: 'No ha entrado en una dirección de e-mail válida',
      badTelephone: 'Usted no ha entrado en el número de teléfono correcto',
      badSecurityAnswer: 'Ha introducido la respuesta incorrecta a la pregunta de seguridad',
      badDate: 'Re-escribiendo una fecha incorrecta',
      lengthBadStart: 'Su respuesta debe incluir entre',
      lengthBadEnd: ' signo',
      lengthTooLongStart: 'Ha introducido una respuesta que es más largo que',
      lengthTooShortStart: 'Ha introducido una respuesta que es más corta que',
      notConfirmed: 'Las 