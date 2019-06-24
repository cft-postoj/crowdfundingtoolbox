import {keys} from '../keys';

export const environment = {

    production: true,

    apiUrl: '/api',
    backOfficeUrl:  '/api/backoffice',
    authServerUrl: '/api/backoffice' ,

    fontsUrl: 'https://www.googleapis.com/webfonts/v1/webfonts?key=' + keys.googleApiKey,

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
    cftSettings: '/crowdfunding-settings',

    donorUrl: '/portal-users',
    donorAllUrl: '/portal-users/all',

    portalUsersUrl: '/portal-users',
    portalUsersAllUrl: '/portal-users/all'
};

