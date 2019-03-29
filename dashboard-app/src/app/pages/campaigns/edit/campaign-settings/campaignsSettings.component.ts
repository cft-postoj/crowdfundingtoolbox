import {Component, Input, KeyValueDiffer, KeyValueDiffers, OnInit} from '@angular/core';
import {CampaignService} from '../../../../_services/campaign.service';
import {Campaign} from '../../../../_models/campaign';
import {ActivatedRoute} from "@angular/router";
import {RadioButton} from "../../../../_parts/atoms/radio-button/radio-button";
import {DropdownItem} from "../../../../_models/dropdown-item";
import {paymentTypes} from "../../../../_models/enums"

@Component({
    selector: 'app-campaign-settings',
    templateUrl: './campaignSettings.component.html',
    styleUrls: ['../../../../../sass/classes.scss', './campaignSettings.component.scss']
})

export class CampaignsSettingsComponent implements OnInit {


    @Input()
    public campaign: Campaign;

    public dateFrom: { day: number, year: number, month: number };
    public dateTo: { day: number, year: number, month: number };
    public campaignNameLength: number = 0;

    public opened = 1;
    public differ: KeyValueDiffer<string, any>;
    public campaignEndRadioButtons: RadioButton[];
    public paymentTypeRadioButtons: RadioButton[];
    public campaignEndValue;
    public copyPrices;

    public paymentTypes = paymentTypes ;

    constructor(private differs: KeyValueDiffers, private route: ActivatedRoute, private campaignService: CampaignService) {
        this.differ = this.differs.find({}).create();

    }

    private static isEqualsDateObjects(first, second): boolean {
        return first.day === second.day && first.year === second.year && first.month === second.month;
    }

    ngOnInit(): void {

        //
        // this.id = this.route.snapshot.paramMap.get("id");
        // this.campaignService.getCampaignById(this.id).subscribe((campaign: Campaign) => {
        //     this.campaignData = campaign;
        //     this.isActive = new Date(campaign.date_to) >= new Date();
        //     this.dateTo = CampaignsSettingsComponent.createDateObject(campaign.date_to);
        //     this.dateFrom = CampaignsSettingsComponent.createDateObject(campaign.date_from);
        // }, (error) => {
        //     console.error(error);
        // });

        this.campaignEndRadioButtons = [];
        this.campaignEndRadioButtons.push(new RadioButton("With selected date", false))
        this.campaignEndRadioButtons.push(new RadioButton("When donation goal is reached", true))

        this.paymentTypeRadioButtons = [];
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.monthly.title, this.paymentTypes.monthly.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.once.title, this.paymentTypes.once.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.both.title, this.paymentTypes.both.value))

    }



    public campaignNameChange(event) {
        this.campaignNameLength = event.target.value.length;
    }

    public isOpened(tabNumber: number) {
        return this.opened === tabNumber;
    }

    public openTab(tabNumber: number) {
        this.opened = this.opened == tabNumber ? 0 : tabNumber;
    }


    private createDateObject(formattedDate: Date) {
        const date = new Date(formattedDate);
        return {day: date.getUTCDate(), year: date.getUTCFullYear(), month: date.getUTCMonth() + 1};
    }

    //add or remove items in monthly_prices to match with value from monthly_prices
    updateNumberOfMonthlyPrices(event) {
        while(this.campaign.payment_settings.monthly_prices.count_of_options != event && (!!event || event==0) ) {
            if (this.campaign.payment_settings.monthly_prices.count_of_options > event) {
                this.campaign.payment_settings.monthly_prices.count_of_options--;
                this.campaign.payment_settings.monthly_prices.options.pop();
            }
            if (this.campaign.payment_settings.monthly_prices.count_of_options < event) {
                this.campaign.payment_settings.monthly_prices.count_of_options++;
                this.campaign.payment_settings.monthly_prices.options.push(
                    {value: this.campaign.payment_settings.monthly_prices.count_of_options * 5});
            }
        }
    }

    //add or remove items in once_prices to match with value from monthly_prices
    updateNumberOfOnOfPrices(event) {
        while(this.campaign.payment_settings.once_prices.count_of_options != event && (!!event || event==0) ) {
            if (this.campaign.payment_settings.once_prices.count_of_options > event) {
                this.campaign.payment_settings.once_prices.count_of_options--;
                this.campaign.payment_settings.once_prices.options.pop();
            }
            if (this.campaign.payment_settings.once_prices.count_of_options < event) {
                this.campaign.payment_settings.once_prices.count_of_options++;
                this.campaign.payment_settings.once_prices.options.push(
                    { value: this.campaign.payment_settings.once_prices.count_of_options * 5}
                    );
            }
        }
    }

    createActivePriceOptions():DropdownItem[]{
        let result : DropdownItem[] = [];
        this.campaign.payment_settings.monthly_prices.options.forEach( (option,i) => {
            result.push({
                title: 'Price No.'+(i+1),
                value: option.value
            })
        })
        return result;
    }
}
