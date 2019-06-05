// routing inside app
export class Routing {

    // main
    static readonly DASHBOARD = 'dashboard';

    // after changing this property, please alert all usages in html in router-outlet (property name)
    // (angular 7 yet don't support dynamic routing name)
    static readonly RIGHT_OUTLET = 'right';

    // functional keywords
    static readonly ALL = 'all';
    static readonly EDIT = 'edit';
    static readonly NEW = 'new';
    static readonly ID = 'id';
    static readonly STATS = 'stats';


    // specific paths for components
    static readonly CAMPAIGNS = 'campaigns';
    static readonly CAMPAIGNS_ALL = `${Routing.CAMPAIGNS}/${Routing.ALL}`;
    static readonly CAMPAIGNS_FULL_PATH = `/${Routing.DASHBOARD}/${Routing.CAMPAIGNS}`;
    static readonly CAMPAIGNS_ALL_FULL_PATH = `${Routing.CAMPAIGNS_FULL_PATH}/${Routing.ALL}`;

    // configurations paths
    static readonly CONFIGURATION = 'configuration';
    static readonly CONFIGURATION_FULL_PATH = `${Routing.DASHBOARD}/${Routing.CONFIGURATION}`;
    static readonly GENERAL = 'general';
    static readonly CTA = 'cta';
    static readonly WIDGET = 'widget';
    // user routing
    static readonly PORTAL_USERS = 'portal-users';
    static readonly  PORTAL_USER_LIST = `${Routing.PORTAL_USERS}/${Routing.ALL}`;
    static readonly PORTAL_USERS_FULL_PATH = `${Routing.DASHBOARD}/${Routing.PORTAL_USERS}`;
    static readonly PORTAL_USER_LIST_FULL_PATH = `${Routing.DASHBOARD}/${Routing.PORTAL_USER_LIST}`;
}
