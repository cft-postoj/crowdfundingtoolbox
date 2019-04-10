// This file can be replaced during build by using the `fileReplacements` array.
// `ng build --prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

const googleApiKey = 'YOUR_API_KEY';

export const environment = {

    production: false,

    apiUrl:  'http://localhost:8000/api',
    backOfficeUrl: 'http://localhost:8000/api/backoffice',
    authServerUrl: 'http://localhost:8000/api/backoffice',

    fontsUrl: 'https://www.googleapis.com/webfonts/v1/webfonts?key=' + googleApiKey,

    login:'/login',
    logout:'/logout',
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

/*
 * For easier debugging in development mode, you can import the following file
 * to ignore zone related error stack frames such as `zone.run`, `zoneDelegate.invokeTask`.
 *
 * This import should be commented out in production mode because it will have a negative impact
 * on performance if an error is thrown.
 */
// import 'zone.js/dist/zone-error';  // Included with Angular CLI.
