import {Component, ElementRef, Input, KeyValueDiffer, KeyValueDiffers, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {Campaign} from "../../models";
import {DropdownItem, RadioButton, paymentTypes} from "../../../core/models";
import {CampaignService} from "../../services";

@Component({
    selector: 'app-campaign-settings',
    templateUrl: './campaign-settings.component.html',
    styleUrls: ['../../../core/components/settings/settings.component.scss', './campaign-settings.component.scss']
})

export class CampaignSettingsComponent  implements OnInit {


    @Input()
    public campaign: Campaign;

    public dateFrom: { day: number, year: number, month: number };
    public dateTo: { day: number, year: number, month: number };
    public campaignNameLength: number = 0;

    public opened:number[] = [1,2,3];
    public differ: KeyValueDiffer<string, any>;
    public campaignEndRadioButtons: RadioButton[];
    public paymentTypeRadioButtons: RadioButton[];
    public campaignEndValue;
    public copyPrices;

    public paymentTypes = paymentTypes;

    public newUrl: string;

    @ViewChild("newUrlInput") newUrlInput: ElementRef;

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
        //     this.dateTo = CampaignSettingsComponent.createDateObject(campaign.date_to);
        //     this.dateFrom = CampaignSettingsComponent.createDateObject(campaign.date_from);
        // }, (error) => {
        //     console.error(error);
        // });


        this.campaignEndRadioButtons = [];
        this.campaignEndRadioButtons.push(new RadioButton("Date", false))
        this.campaignEndRadioButtons.push(new RadioButton("Donation goal", true))

        this.paymentTypeRadioButtons = [];
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.monthly.title, this.paymentTypes.monthly.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.once.title, this.paymentTypes.once.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.both.title, this.paymentTypes.both.value))

    }



    public campaignNameChange(event) {
        this.campaignNameLength = event.target.value.length;
    }

    public openTab(tabNumber: number) {
        if (this.isOpened(tabNumber)) {
            this.opened.splice(this.opened.indexOf(tabNumber),1)
        } else {
            this.opened.push(tabNumber);
        }
    }

    public isOpened(tabNumber: number) {
        return this.opened.indexOf(tabNumber)>-1;
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

    splice(array: string[], index: number) {
        array.splice(index, 1)
    }

    addUrl() {
        if (this.campaign.targeting.url.specific) {
            if (this.newUrl) {
                this.campaign.targeting.url.list.push({
                    id:0,
                    path:this.newUrl
                });
                this.newUrl = undefined;
            } else {
                this.newUrlInput.nativeElement.focus();
            }
        }
    }
}
