const googleApiKey = 'YOUR_API_KEY';
const yourDomain = 'YOUR_URL';

export const environment = {

    production: true,

    apiUrl: 'https://' + yourDomain + '/api',
    backOfficeUrl:  'https://' + yourDomain + '/api/backoffice',
    authServerUrl: 'https://' + yourDomain + '/api/backoffice' ,

    fontsUrl: 'https://www.googleapis.com/webfonts/v1/webfonts?key=' + googleApiKey,

    login: '/login',
    logout: '/logout',
    refreshToken: '/refresh-token',

    smart: '/smart-settings',
    imageUploadUrl: '/upload',
    result: '/result',
    clone: '/clone',

    campaignUrl: '/campaigns',
    campaignAllUrl: '/campaigns/all',

    userUrl: '/users',
    userRegisterUrl: '/users/register',

    translationsUrl: '/translations',
    translationsAllUrl: '/translations/all',

    widgetsUrl: '/widgets'
};
