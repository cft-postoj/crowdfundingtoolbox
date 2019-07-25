let prod = false;
if (process.env['APP_ENV'] === 'prod') {
    prod = true;
}
let apiUrlLocal, viewsUrlLocal, portalUrlLocal, myAccountUrlLocal, domainLocal;

if (prod) {
    apiUrlLocal = process.env['CFT_API_PROD_URL'];
    viewsUrlLocal = process.env['CFT_VIEW_PROD_URL'];
    portalUrlLocal = process.env['CFT_PORTAL_PROD_URL'];
    myAccountUrlLocal = portalUrlLocal + process.env['CFT_PORTAL_MY_ACCOUNT_URL'];
    domainLocal = process.env['CFT_DOMAIN_PROD_URL'];
} else {
    apiUrlLocal = process.env['CFT_API_URL'];
    viewsUrlLocal = process.env['CFT_VIEW_URL'];
    portalUrlLocal = process.env['CFT_PORTAL_URL'];
    myAccountUrlLocal = portalUrlLocal + process.env['CFT_PORTAL_MY_ACCOUNT_URL'];
    domainLocal = process.env['CFT_DOMAIN_URL'];
}


export const apiUrl = apiUrlLocal;
export const viewsUrl = viewsUrlLocal;
export const portalUrl = portalUrlLocal;
export const myAccountUrl = myAccountUrlLocal;
export const domain = domainLocal;
