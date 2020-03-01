/**
 * Just hook into the form submit process
 *
 * @return {void}
 */
$(function () {

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

});


/**
 * Show the user that we are currently going to redirect him to after logout page
 *
 * @return {void}
 */
const performLogoutRedirect = async () => {
    $('#logout-link').remove();
    $('#login_success_block').removeClass('d-none');

    const redirectUrl = await logout();

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
        <span class="sr-only">${label}</span>
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
 * @param {string}   username        Username which used for login process...
 * @param {string}   password        User password in plain form
 * @param {boolean}  remember        Set or no remember cookie.
 * @return {Object}
 */
const loginAttempt = async (url, username, password, remember) => {
    const result = await axios.post(url, {username, password, remember});

    return result.data;
};

/**
 * Log off the current user and give back the redirect url...
 *
 * @return {string}
 */
const logout = async () => {
    initializeRequestHeaders();

    const result = await axios.get('/api/login/logins/logout');

    return result.data.redirect;
};
