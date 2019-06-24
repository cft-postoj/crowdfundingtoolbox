import {Component, OnInit} from '@angular/core';
import {CampaignStats} from '../../models/campaign-stats';

@Component({
    selector: 'app-campaigns-stats',
    templateUrl: './campaigns-stats.component.html',
    styleUrls: ['./campaigns-stats.component.scss']
})
export class CampaignsStatsComponent implements OnInit {

    dropdownOptions: any[] = [];

    campaignStats: CampaignStats[] = [];
    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };

    public model: any;
    public sortedCampaignsStats;

    constructor() {
    }

    ngOnInit() {
        let dummyCampaignStats = {
            campaign_name: {title: 'Campaign name', value: 5, type: 'string'},
            users_show: {title: 'Users saw', value: 5, type: 'number'},
            users_detail: {title: 'Users interaction', value: 5, type: 'number'},
            users_new: {title: 'New users', value: 5, type: 'number'},
            users_new_monthly: {title: 'New monthly users', value: 5, type: 'number'},
            users_new_one_time: {title: 'New one time users', value: 5, type: 'number'},
        };

        for (let index of Object.keys(dummyCampaignStats)) {
            this.dropdownOptions.push({
                value_name: index,
                description: dummyCampaignStats[index].title,
                type:  dummyCampaignStats[index].type,
                filter: {
                    min: Number.MIN_SAFE_INTEGER,
                    max: Number.MAX_SAFE_INTEGER,
                    string: ''
                }
            });
        }

        this.model = this.dropdownOptions.slice(0);

        let dummyCampaignStatsNotSelected = {
            donation_collected_all: {title: "Donations", value: 5, type: 'number'},
            donation_collected_monthly: {title: "Monthly donations", value: 5, type: 'number'},
            donation_collected_one_time: {title: "One time donations", value: 5, type: 'number'},
            donation_average: {title: "Avg donation", value: 5, type: 'number'},
            donation_median: {title: "Median donation", value: 5, type: 'number'}
        }

        for (let index of Object.keys(dummyCampaignStatsNotSelected)) {
            this.dropdownOptions.push({
                value_name: index,
                description: dummyCampaignStatsNotSelected[index].title,
                type:  dummyCampaignStatsNotSelected[index].type,
                filter: {
                    min: Number.MIN_SAFE_INTEGER,
                    max: Number.MAX_SAFE_INTEGER,
                    string: ''
                }
            });
        }
        this.campaignStats.push({
            id: 5,
            campaign_name: 'abc',

            users_show: 5,
            users_detail: 5,
            users_new: 5,
            users_new_monthly: 5,
            users_new_one_time: 5,

            donation_collected_all: 5,
            donation_collected_monthly: 5,
            donation_collected_one_time: 5,
            donation_average: 5,
            donation_median: 5,
            donation_goal: 5,

        });

        this.campaignStats.push({
            id: 6,
            campaign_name: 'aabcd',
            users_show: 6,
            users_detail: 64,
            users_new: 6,
            users_new_monthly: 6,
            users_new_one_time: 6,

            donation_collected_all: 6,
            donation_collected_monthly: 6,
            donation_collected_one_time: 6,
            donation_average: 6,
            donation_median: 6,
            donation_goal: 6,
        });

        this.campaignStats.push({
            id: 25,
            campaign_name: 'cde',

            users_show: 12,
            users_detail: 6,
            users_new: 0,
            users_new_monthly: 25,
            users_new_one_time: 25,

            donation_collected_all: 25,
            donation_collected_monthly: 25,
            donation_collected_one_time: 25,
            donation_average: 25,
            donation_median: 25,
            donation_goal: 25,
        });

        this.sortedCampaignsStats = this.campaignStats.slice();
    }

    sortCampaignsStats() {
        let filteredCampaignStats = this.filterByValues(this.model, this.campaignStats);
        this.sortedCampaignsStats = filteredCampaignStats;
        if (!!this.model.sortBy) {
            this.sortedCampaignsStats = filteredCampaignStats.sort((a, b) => {
                return this.compare(a[this.model.sortBy.id], b[this.model.sortBy.id], this.model.asc)
            });
        }
    }

    compare(a: number | string, b: number | string, isAsc: boolean) {
        return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
    }

    private filterByValues(model, campaignStats: CampaignStats[]) {
        return campaignStats.filter(campaignStat => {
            for (let modelEntry of model) {
                if (!!modelEntry.filter.min && modelEntry.filter.min > campaignStat[modelEntry.value_name] ||
                    !!modelEntry.filter.max && modelEntry.filter.max < campaignStat[modelEntry.value_name] ||
                    !!modelEntry.filter.text && campaignStat[modelEntry.value_name].indexOf(modelEntry.filter.text) === -1 ) {
                    return false
                }
            }
            return true;
        })
    }
}
