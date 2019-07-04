import {PreloadAllModules, RouterModule, Routes} from '@angular/router';
import {Routing} from './constants/config.constants';
import {
    CtaSettingsComponent,
    DashboardComponent,
    GeneralSettingsComponent,
    WidgetSettingsComponent
} from './modules/core/components';
import {LoginGuard} from './modules/user-management/services';
import {AboutComponent, ContactComponent} from './components';
import {ConfigurationComponent} from './modules/core/pages/configuration/configuration.component';
import {TranslationCreateComponent, TranslationListComponent} from './modules/translations/components';
import {UserSettingsComponent} from './modules/user-management/components/user-settings/user-settings.component';
import {CreateUserComponent} from './modules/user-management/components/create-user/create-user.component';

export const appRoutes: Routes = [
    {
        path: 'login',
        loadChildren: './modules/user-management/user-management.module#UserManagementModule'
    },
    {
        path: 'dashboard',
        component: DashboardComponent,
        canActivate: [LoginGuard],
        canActivateChild: [LoginGuard],
        children: [
            {
                path: 'about',
                component: AboutComponent,
            }, {
                path: 'contact',
                component: ContactComponent
            }, {
                path: 'translations',
                component: TranslationListComponent
            },
            {
                path: 'translations/new',
                component: TranslationCreateComponent,
                data: {
                    title: 'Translations'
                },
            },
            {
                path: 'user-settings',
                component: UserSettingsComponent
            },
            {
                path: 'user-settings/create-user',
                component: CreateUserComponent
            },
            {
                path: Routing.CONFIGURATION,
                component: ConfigurationComponent,
                children: [{
                    path: Routing.GENERAL,
                    component: GeneralSettingsComponent,
                    outlet: Routing.RIGHT_OUTLET
                }, {
                    path: Routing.CTA,
                    component: CtaSettingsComponent,
                    outlet: Routing.RIGHT_OUTLET
                }, {
                    path: Routing.WIDGET,
                    component: WidgetSettingsComponent,
                    outlet: Routing.RIGHT_OUTLET
                }]
            },
            {
                path: Routing.CAMPAIGNS,
                loadChildren: './modules/campaigns/campaigns.module#CampaignsModule'
            },
            {
                path: Routing.PORTAL_USERS,
                loadChildren: './modules/portal-users/portal-users.module#PortalUsersModule'
            },
            {
                path: Routing.STATS,
                loadChildren: './modules/statistics/statistics.module#StatisticsModule'
            },
            {
                path: Routing.PAYMENT_OPTIONS,
                loadChildren: './modules/payment/payment.module#PaymentModule'
            }
        ]
    },
    {
        path: '**',
        redirectTo: '/dashboard/campaigns/all',
        canActivate: [LoginGuard],
    }
];

export const routing = RouterModule.forRoot(appRoutes, {
    preloadingStrategy: PreloadAllModules
});

