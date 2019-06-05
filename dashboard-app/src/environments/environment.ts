// This file can be replaced during build by using the `fileReplacements` array.
// `ng build --prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

import {keys} from '../keys';

export const environment = {

    production: false,

    apiUrl:  'http://localhost:8000/api',
    backOfficeUrl: 'http://localhost:8000/api/backoffice',
    authServerUrl: 'http://localhost:8000/api/backoffice',

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

    portalUsersUrl: '/portal-users',
    portalUsersAllUrl: '/portal-users/all'

};
