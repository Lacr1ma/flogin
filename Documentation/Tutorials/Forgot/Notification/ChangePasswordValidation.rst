.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _change-password-validation:

Validation Feedback
---------------------

    When passwords do not match, validation message is rendered.

    .. figure:: ../../../Images/Error/confirmation-does-not-match.png
        :class: with-shadow

Tweak a validation message
---------------------------

    * Validation text is stored under

        .. tip::

            :ts:`LLL:EXT:theme/Resources/Private/Language/validation.xlf:password_confirmation.not_match`

    * You can even overwrite all the validation messages by updating that variable

        .. tip::

            :ts:`plugin.tx_login.settings.validation = LLL:EXT:theme/Resources/Private/Language/LoginValidation.xlf`
