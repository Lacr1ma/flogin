.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _login:

Login Workflow
---------------

.. rst-class:: bignums-xxl

#. Add Login form on a expected page.

    .. image:: ../../Images/plugin-login.png
        :class: with-shadow

#. Don't forget setup the login page TypoScript variable.

    :ts:`plugin.tx_login.settings.page.login = X`

   .. tip::

        Features like **reset password**, **magic link** and **unlock** depend on
        *login* page. That's why don't forget to set it correctly.

#. Set the page that user will be redirected to after the successful login attempt.

    .. image:: ../../Images/authenticated.png
        :class: with-shadow

    :ts:`plugin.tx_login.settings.redirect.afterLoginPage = X`

#. Set the page that user will be redirected to after logoff.

    .. image:: ../../Images/logoff.png
        :class: with-shadow

    :ts:`plugin.tx_login.settings.redirect.afterLogoutPage = X`

.. toctree::
    :maxdepth: 5
    :hidden:

    Action/Username
    Action/Password
    Action/Throttle

    Notification/Index
