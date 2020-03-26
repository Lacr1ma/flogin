define([
  'TYPO3/CMS/Flogin/Clipboard',
  'TYPO3/CMS/Backend/Notification'
], function (Clipboard, Notification) {
  'use strict';

  /**
   * @constructor
   * @exports TYPO3/CMS/Flogin/Module
   */
  let Module = function () {
    let clipboard = new Clipboard('.btn-copy');

    clipboard.on('success', function() {
      Notification.success('OK', '');

      history.back();
    });

  };

  return new Module;
});
