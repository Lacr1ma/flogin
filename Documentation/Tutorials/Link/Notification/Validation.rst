.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _request-magic-link-email-validation:

Validation Feedback
---------------------

    When wrong email address is provided, validation message gets displayed.

    .. figure:: ../../../Images/Error/email-not-found.png
        :class: with-shadow

Tweak a validation message
---------------------------

    * Validation text is stored under

        .. tip::

            :ts:`LLL:EXT:theme/Resources/Private/Language/validation.xlf:email.not_found`

    * You can even overwrite all the validation messages by updating that variable

        .. tip::

            :ts:`plugin.tx_login.settings.validation = LLL:EXT:theme/Resources/Private/Language/LoginValidation.xlf`
