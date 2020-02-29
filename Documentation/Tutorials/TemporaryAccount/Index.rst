.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _temporary-account:

Create Temporary Account
-------------------------

.. rst-class:: bignums-xxl

#. Go to backend area.

#. Open **Login** module and click on *Generate temporary account* button.

    .. image:: ../../Images/temp_account-step-1.png
        :class: with-shadow

#. Copy the generated link.

    .. image:: ../../Images/temp_account-step-2.png
        :class: with-shadow

    .. notice::
        Link expires just after usage. Do not open the link yourself unless you need
        to check anything special.

    When link clicked, user gets logged in and redirected to :file:`afterLoginPage`.

    .. tip::
        You can change the lifetime of temporary accounts by changing

        :ts:`plugin.tx_login.settings.oneTimeAccount.lifetimeInMinutes = 60`

        By default it's 1 hour.

    .. tip::
        Also you can set default user groups that will be assigned after creation

        :ts:`plugin.tx_login.settings.oneTimeAccount.properties.usergroup = 1,2,3`

        By default no groups will be assigned.

#. Pass the link to the end user...

    By clicking the link, user gets logged in. Account will automatically disabled
    when lifetime has passed (1 hour).

    You can check if user opened the link by checking **Login** module.

    .. image:: ../../Images/temp_account-step-3.png
        :class: with-shadow

    .. tip::
        All temporary accounts have same password as username.

        That means, there's a possibility to reauthenticate again using simple login form.

.. toctree::
	:maxdepth: 5
	:hidden:

	Errors/Hash
