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

    // key words
    smart: '/smart-settings',
    imageUploadUrl: '/upload',
    result: '/result',
    clone: '/clone',
    group: '/group',
    total: '/total',
    all: '/all',

    // domain specific paths
    campaignUrl: '/campaigns',
    campaignAllUrl: '/campaigns/all',

    userUrl: '/users',
    userRegisterUrl: '/users/register',

    translationsUrl: '/translations',
    translationsAllUrl: '/translations/all',

    widgetsUrl: '/widgets',
    cftSettings: '/crowdfunding-settings',

    portalUsersUrl: '/portal-users',
    portalUsersAllUrl: '/portal-users/all',

    donationUrl: '/statistics/donations',
    donorUrl: '/statistics/donors',

    statisticsUrl: '/statistics/donation-and-donor-total',

    campaignTargeting: '/campaign-targeting',

    userDetail: '/user-detail'
};

