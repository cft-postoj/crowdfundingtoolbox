import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {Routing} from '../../constants/config.constants';
import {CommonModule} from '@angular/common';
import {CampaignEditComponent, WidgetEditComponent} from './components';
import {CampaignListComponent} from './pages/campaign-list/campaign-list.component';
import {CampaignDetailComponent} from './pages/campaign-detail/campaign-detail.component';
import {CampaignNotFoundComponent} from './pages/campaign-not-found/campaign-not-found.component';
import {CampaignsStatsComponent} from './pages/campaigns-stats/campaigns-stats.component';

const routes: Routes = [
    {
        path: 'all',
        component: CampaignListComponent,
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
        path: Routing.STATS,
        component: CampaignsStatsComponent
    },
    {
        path: ':' + Routing.ID,
        component: CampaignDetailComponent,
        data: {parent: null},
        children: [
            {
                path: Routing.EDIT + '/:widgetId',
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
    {path: '404', component: CampaignNotFoundComponent},
    {
        path: '**', redirectTo: 'all'
    }
];

@NgModule({
  imports: [CommonModule, RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CampaignsRoutingModule {
}
