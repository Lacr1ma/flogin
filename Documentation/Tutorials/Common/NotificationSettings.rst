.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _common-notification-settings:

Global Notification Settings
----------------------------

    There are a list of settings applied to every notification that **EXT:login** sends.
    This section shows this settings.

Logo
===========

    Represents the company logo. By default TYPO3 logo is rendered.

    .. note::

        :ts:`plugin.tx_login.settings.email.logoPath = EXT:theme/Resources/Public/Icons/Logo.svg`

Portal Link
===============

    Usually points to domain from where the notification was sent.

    .. note::

        :ts:`plugin.tx_login.settings.email.site = https://example.com`

Sender
=========

    .. code-block:: php

        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'no-reply@example.com'
