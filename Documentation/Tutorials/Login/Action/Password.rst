.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

Password
===================================

    During the authentication process, **password** is a required brick.

    .. figure:: ../../../Images/login.png
        :class: with-shadow

        Login form view.

Validation Feedback
---------------------

    After credentials were submitted, system checks if provided **username** exists and
    **password** does match.

    .. figure:: ../../../Images/login_field-user_exists.png
        :class: with-shadow

        **password** does not match.

Tweak a validation message
---------------------------

    * Validation text is stored under

        .. tip::

            :ts:`LLL:EXT:theme/Resources/Private/Language/locallang.xlf:password.not_match`
