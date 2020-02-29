.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _installation:

Installation
============

#. Get the extension

`composer require lms/login`.

.. warning::

    Currently, extension works *only* in a composer mode!

Latest version from git
-----------------------

You can get the latest version from git by using the git command:

.. code-block:: bash

   git clone https://github.com/Lacr1ma/login.git

Preparation: Include static TypoScript
--------------------------------------

The extension ships some TypoScript code which needs to be included.

#. Switch to the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **LMS: Login (login)** at the field *Include static (from extensions):*
