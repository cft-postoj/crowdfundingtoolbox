import {RouterModule, Routes} from '@angular/router';

import {LoginComponent} from './login';
import {DashboardComponent} from './dashboard/dashboard.component';
import {AboutComponent} from './about/about.component';
import {ContactComponent} from './contact/contact.component';
import {TranslationsComponent} from './translations/translations.component';
import {NewTranslationComponent} from './translations/new-translation/new-translation.component';
import {CampaignsComponent} from './pages/campaigns/list/campaigns.component';
import {ConfigurationComponent} from './pages/configuration/configuration.component';
import {LoginGuard} from './_guard';
import {CampaignDetailComponent} from "./pages/campaigns/detail/campaignDetail.component";
import {Routing} from "./constants/config.constants";
import {CampaignEditComponent} from "./pages/campaigns/edit/campaignEdit.component";
import {WidgetEditComponent} from "./pages/widget/widget-edit/widget-edit.component";
import {GeneralSettingsComponent} from "./components/general-settings/general-settings.component";
import {CtaSettingsComponent} from "./components/cta-settings/cta-settings.component";
import {WidgetSettingsComponent} from "./components/widget-settings/widget-settings.component";

export const appRoutes: Routes = [
    {
        path: 'login', component: LoginComponent
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
                component: TranslationsComponent
            },
            {
                path: 'translations/new',
                component: NewTranslationComponent,
                data: {
                    title: 'Translations'
                },
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
                },{
                    path: Routing.WIDGET,
                    component: WidgetSettingsComponent,
                    outlet: Routing.RIGHT_OUTLET
                }]
            },
            {
                path: Routing.CAMPAIGNS_ALL,
                component: CampaignsComponent,
                data: {
                    title: 'Campaigns'
                },
                children: [
                    {
                        path: Routing.NEW,
                        component: CampaignEditComponent,
                        outlet: Routing.RIGHT_OUTLET,
                        data: {new: true}
                    },
                    {
                        path: Routing.EDIT + '/:id',
                        component: CampaignEditComponent,
                        outlet: Routing.RIGHT_OUTLET
                    },
                ]

            },
            {
                path: Routing.CAMPAIGNS + '/:id',
                component: CampaignDetailComponent,
                data: {parent: null},
                children: [
                    {
                        path: Routing.EDIT + "/:widgetId",
                        component: WidgetEditComponent,
                        outlet: Routing.RIGHT_OUTLET
                    },
                    {
                        path: Routing.EDIT,
                        component: CampaignEditComponent,
                        outlet: Routing.RIGHT_OUTLET
                    }
                ]
            },
        ]
    },
    {
        path: '**',
        redirectTo: '/dashboard/campaigns/all',
        canActivate: [LoginGuard],
    }
];

export const routing = RouterModule.forRoot(appRoutes);

