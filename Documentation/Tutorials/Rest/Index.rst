.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _rest-api:

REST API
-------------------

    :file:`EXT:login` depends on a :file:`EXT:routes` which is a yaml routes provider.

    That way we ship a couple of useful routes out of the box.

Fetch currently logged in user information
=============================================

    .. code-block:: console

        curl --location --request GET 'api/login/users/current' \
            --header 'Content-Type: application/json' \
            --header 'Accept: application/json' \
            --header 'Cookie: fe_typo_user=bb9c335567f3330d668d2fbe394606ec' \
            --header 'X-CSRF-TOKEN: bb9c335567f3330d668d2fbe394606ec'

    .. note::

        Guarded by :file:`auth` middleware.

    .. code-block:: json

        [
            {
                "address": "",
                "city": "",
                "company": "",
                "country": "",
                "crdate": 0,
                "email": "user@example.com",
                "endtime": 0,
                "fax": "",
                "firstName": "Serhii",
                "forgotPasswordFormUrl": "",
                "image": null,
                "lastName": "Borulko",
                "lockMinutesInterval": 10,
                "locked": false,
                "loggedIn": true,
                "middleName": "",
                "name": "",
                "notLocked": true,
                "online": true,
                "telephone": "",
                "timeToUnlock": true,
                "title": "",
                "tstamp": 1582719491,
                "uid": 1,
                "unlockActionUrl": "",
                "username": "user",
                "www": "",
                "zip": ""
            }
        ]

Gives us an answer if the session is authenticated
===================================================

    .. code-block:: console

        curl --location --request GET 'api/login/users/authenticated' \
            --header 'Content-Type: application/json' \
            --header 'Accept: application/json'

    .. code-block:: json

        {
            "authenticated": true
        }

Terminates the existing session for the user. (Force logout)
=============================================================

    .. code-block:: console

        curl --location --request GET 'api/login/logins/logout' \
            --header 'Content-Type: application/json' \
            --header 'Accept: application/json' \
            --header 'Cookie: fe_typo_user=bb9c335567f3330d668d2fbe394606ec' \
            --header 'X-CSRF-TOKEN: bb9c335567f3330d668d2fbe394606ec'

    .. note::

        Guarded by :file:`auth` middleware.

Plain authentication attempt
==============================

    .. code-block:: console

        curl --location --request POST 'http://login.ddev.site/api/login/logins/auth' \
            --header 'Content-Type: application/json' \
            --header 'Accept: application/json' \
            --data-raw '{"username":"user", "password":"passs", "remember":true}'

    .. note::

        Guarded by :file:`Throttle` middleware with limited to 50 failed attempts.
