/**
 * Just hook into the form submit process
 *
 * @return {void}
 */
 $(function () {
    initializeLoginForm();
    initializeMagicLinkForm();
    initializeResetPasswordForm();
});

/**
 * @return {void}
 */
const initializeLoginForm = async () => {
    $("#login_form_ajax").submit(function (event) {
        event.preventDefault();

        loginFormIsLoading();

        const username = $(this).find('#username-field').val();
        const password = $(this).find('#password-field').val();

        loginAttempt('/api/login/logins/auth', username, password, true).then(function (data) {
            if (data.redirect) {
                performLoginRedirect(data.redirect);
                return;
            }

            validateUsername(data.errors['username'] || '');
            validatePassword(data.errors['password'] || '');

            setTimeout(function () {
                $('#login_form_ajax fieldset').removeAttr('disabled');
                $('#login-button').html(TYPO3.lang['form_login.submit']);
            }, 200);
        });
    });
};

/**
 * @return {void}
 */
const initializeMagicLinkForm = async () => {
    $("#magic_form_ajax").submit(function (event) {
        event.preventDefault();

        magicLinkFormIsLoading();

        const email = $(this).find('#email-field').val();

        requestMagicLinkAttempt('/api/login/magic-link', email).then(function (data) {
            if (data.redirect) {
                $('#login_form_ajax').remove();
                $('#magic-request-form').remove();
                $('#forgot-request-form').remove();
                $('#notification-sent').removeClass('d-none');
                return;
            }

            placeError(
                $('#email-field'),
                $('.email-is-invalid'),
                data.errors['email'] || ''
            );

            setTimeout(function () {
                $('#magic_form_ajax fieldset').removeAttr('disabled');
                $('#send-magic-link').html(TYPO3.lang['form_magic.submit']);
            }, 200);
        });
    });
};

/**
 * @return {void}
 */
const initializeResetPasswordForm = async () => {
    $("#forgot_form_ajax").submit(function (event) {
        event.preventDefault();

        forgotPasswordFormIsLoading();

        const email = $(this).find('#forgot-email-field').val();

        requestMagicLinkAttempt('/api/login/reset-password-link', email).then(function (data) {
            if (data.redirect) {
                $('#login_form_ajax').remove();
                $('#magic-request-form').remove();
                $('#forgot-request-form').remove();
                $('#notification-sent').removeClass('d-none');
                return;
            }

            placeError($('#forgot-email-field'), $('.forgot-email-is-invalid'), data.errors['email'] || '');

            setTimeout(function () {
                $('#forgot-request-form fieldset').removeAttr('disabled');
                $('#send-forgot-link').html(TYPO3.lang['form_forgot.submit']);
            }, 200);
        });
    });
};

/**
 * Show the user that we are currently going to redirect him to after logout page
 *
 * @return {void}
 */
const performLogoutRedirect = async () => {
    $('#logout-link').remove();
    $('#login_success_block').removeClass('d-none');

    const redirectUrl = logout();

    window.location.replace(redirectUrl);
};

/**
 * Show the user that we are currently going to redirect him to after login page
 *
 * @param {string}   url
 * @return {void}
 */
const performLoginRedirect = async (url) => {
    $('#login_form_ajax').remove();

    $('#login_success_block').removeClass('d-none');

    setTimeout(function () {
        window.location.replace(url);
    }, 300);
};

/**
 * Basically add loading indicator to login form and block it while preforming the request
 *
 * @return {void}
 */
const loginFormIsLoading = async () => {
    const label = TYPO3.lang['ajax.loading'];

    $('#login_form_ajax fieldset').attr('disabled', 'disabled');

    $('#login-button').html(`
        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
        <span>${label}</span>
    `);
};

/**
 * Basically add loading indicator to magic link form and block it while preforming the request
 *
 * @return {void}
 */
const magicLinkFormIsLoading = async () => {
    const label = TYPO3.lang['ajax.loading'];

    $('#magic_form_ajax fieldset').attr('disabled', 'disabled');

    $('#send-magic-link').html(`
        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
        <span>${label}</span>
    `);
};

/**
 * Basically add loading indicator to forgot password form and block it while preforming the request
 *
 * @return {void}
 */
const forgotPasswordFormIsLoading = async () => {
    const label = TYPO3.lang['ajax.loading'];

    $('#forgot_form_ajax fieldset').attr('disabled', 'disabled');

    $('#send-forgot-link').html(`
        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
        <span>${label}</span>
    `);
};

/**
 * Set validation errors for username
 *
 * @param {string}   errorMessage
 * @return {void}
 */
const validateUsername = async (errorMessage) => {
    let field = $('#username-field');

    let notice = $('.username-block > .validation');

    placeError(field, notice, errorMessage);
};

/**
 * Set validation errors for password
 *
 * @param {string}   errorMessage
 * @return {void}
 */
const validatePassword = async (errorMessage) => {
    let field = $('#password-field');

    let notice = $('.password-block > .validation');

    placeError(field, notice, errorMessage);
};

/**
 * Add error to the requested field
 *
 * @param {jQuery}   field
 * @param {jQuery}   notice
 * @param {string}   message
 * @return {void}
 */
const placeError = async (field, notice, message) => {
    if (message.length === 0) {
        $(notice).addClass('d-none');
        $(field).removeClass('is-valid is-invalid');
        return;
    }

    $(field).removeClass('is-valid').addClass('is-invalid');

    $(notice).text(message).removeClass('d-none').addClass('invalid-feedback');
};

/**
 * Perform the authentication request to the BE and give back the validation response
 *
 * @param {string}   url             Auth endpoint
 * @param {string}   email           User's email address
 * @return {Object}
 */
const requestMagicLinkAttempt = async (url, email) => {
    const response = await fetch(url, {
        body: JSON.stringify({email}),
        headers: getRequestHeaders(),
        method: 'POST'
    });

    return await response.json();
};

/**
 * Perform the authentication request to the BE and give back the validation response
 *
 * @param {string}   url             Auth endpoint
 * @param {string}   username        Username which used for login process...
 * @param {string}   password        User password in plain form
 * @param {boolean}  remember        Set or no remember cookie.
 * @return {Object}
 */
const loginAttempt = async (url, username, password, remember) => {
    const response = await fetch(url, {
        body: JSON.stringify({username, password, remember}),
        headers: getRequestHeaders(),
        method: 'POST'
    });

    return await response.json();
};

/**
 * Log off the current user and give back the redirect url...
 *
 * @return {string}
 */
const logout = async () => {
    const response = await fetch('/api/login/logins/logout', {
        headers: getRequestHeaders(),
        method: 'GET'
    });

    const result = await response.json();

    return result.redirect;
};

const getRequestHeaders = () => {
    const csrf = document.head.querySelector('meta[name="x-csrf-token"]');

    return {
        'Accept': 'application/json',
        'ContentType': 'application/json',
        'X-CSRF-TOKEN': csrf ? csrf.content : ''
    }
};
