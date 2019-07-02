// This file can be replaced during build by using the `fileReplacements` array.
// `ng build --prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

import {keys} from '../keys';

export const environment = {

    production: false,

    apiUrl: 'http://localhost:8001/api',
    backOfficeUrl: 'http://localhost:8001/api/backoffice',
    authServerUrl: 'http://localhost:8001/api/backoffice',

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

    userDetail: '/user-detail',

    checkGeneratedResetToken: '/check-generated-reset-token',

    isMonthlyDonor: '/is-monthly-donor',

    editPortalUser: '/edit-portal-user',

    excludeFromTargeting: '/exclude-from-campaigns-targeting'

};
