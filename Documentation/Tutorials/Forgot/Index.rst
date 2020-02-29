.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _forgot:

Forgot Workflow
---------------

.. rst-class:: bignums-xxl

#. Add Login plugin on an expected page.

    .. image:: ../../Images/plugin-login.png
        :class: with-shadow

#. Click on <Forgot Password ?> link.

    .. image:: ../../Images/forgot-step-1.png
        :class: with-shadow

#. Provide email address.

    .. figure:: ../../Images/forgot-step-2.png
        :class: with-shadow

        :ref:`Validation message <reset-password-validation>`

#. Set proper page redirect.

    When form from previous step is submitted, user is redirected to certain page.

    .. image:: ../../Images/forgot-step-3.png
        :class: with-shadow

    * Redirect page

        .. tip::
            :ts:`plugin.tx_login.settings.redirect.afterForgotPasswordNotificationSentPage = 3`

#. Check the email :ref:`notification <forgot-password-notification>`.

    * :ref:`Common email settings <common-notification-settings>`

#. Update password.

    .. figure:: ../../Images/forgot-step-5.png
        :class: with-shadow

        :ref:`Validation messages <change-password-validation>`

#. Here we go

    .. figure:: ../../Images/forgot-step-6.png
        :class: with-shadow

        :ref:`Error redirects <common-error-redirects>`

    * Success redirect target

        .. tip::

            :ts:`plugin.tx_login.settings.redirect.afterResetPasswordFormSubmittedPage = 15`

.. toctree::
    :hidden:

    Notification/Index
