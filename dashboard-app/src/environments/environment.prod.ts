const googleApiKey = 'AIzaSyA9p_o601-50SPOBkXFIkAnAzTx7RRn_UI';

export const environment = {

    production: true,

    apiUrl: 'https://app.crowdfundingtoolbox.news/api',
    backOfficeUrl:  'https://app.crowdfundingtoolbox.news/api/backoffice',
    authServerUrl: 'https://app.crowdfundingtoolbox.news/api/backoffice' ,

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


    widgetsUrl: '/widgets',
    cftSettings: '/crowdfunding-settings'
};

