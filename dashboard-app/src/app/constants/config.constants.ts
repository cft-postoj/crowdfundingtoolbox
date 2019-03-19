// routing inside app
export class Routing {

    //main
    static readonly DASHBOARD = 'dashboard';

    // after changing this property, please alert all usages in html in router-outlet (property name)
    //(angular 7 yet don't support dynamic routing name)
    static readonly RIGHT_OUTLET = 'right';

    //functional keywords
    static readonly ALL = "all";
    static readonly EDIT = "edit";
    static readonly NEW = "new";


    //specific paths for components
    static readonly CAMPAIGNS = 'campaigns';
    static readonly CAMPAIGNS_ALL = `${Routing.CAMPAIGNS}/${Routing.ALL}`;
    static readonly CAMPAIGNS_FULL_PATH = `/${Routing.DASHBOARD}/${Routing.CAMPAIGNS}`;
    static readonly CAMPAIGNS_ALL_FULL_PATH = `${Routing.CAMPAIGNS_FULL_PATH}/${Routing.ALL}`;


}