document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('cft--loginButton').onclick = function(e) {
        e.preventDefault();
        document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
        document.querySelector('.cftLogin--cftLoginWrapper').onclick = function(e) {
            e.preventDefault();
            if (e.target.className === 'cftLogin--cftLoginWrapper active')
            document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
        };

        // SHOW REGISTER
        document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button').onclick = function(e) {
            e.preventDefault();
            document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
        };

        // SHOW LOGIN
        document.querySelector('.cftLogin--cftLoginWrapper--content--register .cftLogin--cftLoginWrapper--content--button').onclick = function(e) {
            e.preventDefault();
            document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
        };

        // SHOW FORGOT PASSWORD
        document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button.forgotPassword').onclick = function(e) {
            e.preventDefault();
            document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'block';
            document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword .cftLogin--cftLoginWrapper--content--button.login').onclick = function(e) {
                document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'none';
                document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
            };
            document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword .cftLogin--cftLoginWrapper--content--button.register').onclick = function(e) {
                document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'none';
                document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
            };
        };
    };
});

