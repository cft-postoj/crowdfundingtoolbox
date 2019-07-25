import {keys} from '../keys';

export const environment = {

    production: true,

    apiUrl: 'https://backend.crowdfundingtoolbox.news/api',
    backOfficeUrl: keys.hostUrl + '/api/backoffice',
    authServerUrl: keys.hostUrl + '/api/backoffice',

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
    list: '/list',
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
    articlesStatistics: '/statistics/articles',
    campagignsStatistics: '/statistics/campaigns',
    campaignStats: '/statistics/campaign',

    campaignTargeting: '/campaign-targeting',

    userDetail: '/user-detail',

    checkGeneratedResetToken: '/check-generated-reset-token',

    isMonthlyDonor: '/is-monthly-donor',

    editPortalUser: '/edit-portal-user',

    excludeFromTargeting: '/exclude-from-campaigns-targeting',


    payment: '/payment',
    importPayments: '/payment/import',
    paymentMethods: '/payment-methods',

    bankTransferMethod: '/payment/bank-transfer-details',
    payBySquareMethod: '/payment/pay-by-square-details',

    bankButton: '/payment/bank-button',

    donations: '/donations',
    unpairedPayments: '/unpaired-payments',

    exportCsv: '/export-csv'

};
