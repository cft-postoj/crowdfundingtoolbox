import {
    Component,
    ElementRef,
    EventEmitter,
    Input,
    KeyValueDiffer,
    KeyValueDiffers, OnChanges,
    OnInit,
    Output,
    ViewChild
} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {Campaign} from "../../models";
import {DropdownItem, RadioButton, paymentTypes} from "../../../core/models";
import {CampaignService} from "../../services";
import {take} from 'rxjs/operators';
import {Observable, Subscription} from 'rxjs';
import moment from 'moment/src/moment';
import {Moment} from 'moment';

@Component({
    selector: 'app-campaign-settings',
    templateUrl: './campaign-settings.component.html',
    styleUrls: ['../../../core/components/settings/settings.component.scss', './campaign-settings.component.scss']
})

export class CampaignSettingsComponent implements OnInit {
    @ViewChild('authorsList') authorsListRef: any;
    @ViewChild('categoriesList') categoriesListRef: any;

    @Input()
    public campaign: Campaign;
    @Output()
    public campaignEmit = new EventEmitter();

    public dateFrom: { day: number, year: number, month: number };
    public dateTo: { day: number, year: number, month: number };
    public startDate: Moment;
    public endDate: Moment;
    public registrationBeforeDate: Moment;
    public registrationAfterDate: Moment;
    public startDateString: string;
    public endDateString: string;
    public campaignNameLength: number = 0;

    public opened: number[] = [1, 2, 3];
    public differ: KeyValueDiffer<string, any>;
    public campaignEndRadioButtons: RadioButton[];
    public paymentTypeRadioButtons: RadioButton[];
    public howOftenRadioButtons: RadioButton[];
    public closeFixedPopupRadioButtons: RadioButton[];
    public campaignEndValue;
    public copyPrices;

    public paymentTypes = paymentTypes;

    public newUrl: string;
    public newExcludedUrl: string;
    public newAuthor: string;

    public selectedAuthors = [];

    public startDateFormat: any = {
        start: moment(),
        end: moment()
    };
    public endDateFormat: any = {
        start: moment(),
        end: moment()
    };

    public targetingRegistrationBeforeDateFormat: any = {
        start: moment(),
        end: moment()
    }
    public targetingRegistrationAfterDateFormat: any = {
        start: moment(),
        end: moment()
    }

    public authors = [];
    public categories = [];
    public currentValueOftenDisplay = 'page_view';
    public currentValueCloseFixedPopup = 'show';

    private changeUsersCountSubscribtion: Subscription;

    @Output()
    public targetingUsersCountEmit = new EventEmitter();
    @Output()
    public targetingUsersLoadingEmit = new EventEmitter();
    @Output()
    public targetingDataEmit = new EventEmitter();

    @ViewChild('newUrlInput') newUrlInput: ElementRef;
    @ViewChild('newExcludedUrlInput') newExcludedUrlInput: ElementRef;

    constructor(private differs: KeyValueDiffers, private route: ActivatedRoute, private campaignService: CampaignService) {
        this.differ = this.differs.find({}).create();

    }

    private static isEqualsDateObjects(first, second): boolean {
        return first.day === second.day && first.year === second.year && first.month === second.month;
    }

    ngOnInit(): void {


        this.campaignEndRadioButtons = [];
        this.howOftenRadioButtons = [];
        this.closeFixedPopupRadioButtons = [];
        this.campaignEndRadioButtons.push(new RadioButton("Date", false));
        this.campaignEndRadioButtons.push(new RadioButton("Donation goal", true));

        this.howOftenRadioButtons.push(new RadioButton('Show for every page view', 'page_view'));
        this.howOftenRadioButtons.push(new RadioButton('Show for every session', 'session'));
        this.howOftenRadioButtons.push(new RadioButton('Show for nth page view', 'nth_page_view'));
        this.howOftenRadioButtons.push(new RadioButton('Show for every page view with defined pause', 'page_view_pause'));

        this.closeFixedPopupRadioButtons.push(new RadioButton('Show again on every page (if popup, show again after 30min)', 'show'));
        this.closeFixedPopupRadioButtons.push(new RadioButton('Don\'t show again (after click on X)', 'dont_show'));
        this.closeFixedPopupRadioButtons.push(new RadioButton('Show again after nth page views', 'show_after_views'));

        this.paymentTypeRadioButtons = [];
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.monthly.title, this.paymentTypes.monthly.value));
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.once.title, this.paymentTypes.once.value));
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.both.title, this.paymentTypes.both.value));

        this.startDate = (this.campaign.promote_settings.start_date_value === '') ?
            moment() : moment(this.campaign.promote_settings.start_date_value);
        this.endDate = (this.campaign.promote_settings.end_date_value === '') ?
            moment() : moment(this.campaign.promote_settings.end_date_value);
        this.registrationBeforeDate = (this.campaign.targeting.registration.before.date === '') ?
            moment() : moment(this.campaign.targeting.registration.before.date);
        this.registrationBeforeDate = (this.campaign.targeting.registration.after.date === '') ?
            moment() : moment(this.campaign.targeting.registration.after.date);
        this.campaign.promote_settings.start_date_value = this.startDate.format('YYYY-MM-DD');
        this.campaign.promote_settings.end_date_value = this.endDate.format('YYYY-MM-DD');
        // console.log(this.endDate)
        setTimeout(() => {
            this.startDateFormat = {
                start: this.startDate,
                end: this.startDate
            };
            this.endDateFormat = {
                start: this.endDate,
                end: this.endDate
            };
            this.targetingRegistrationBeforeDateFormat = {
                start: this.registrationBeforeDate,
                end: this.registrationBeforeDate
            };
            this.targetingRegistrationAfterDateFormat = {
                start: this.registrationAfterDate,
                end: this.registrationAfterDate
            };

        }, 500);

        console.log(moment(this.campaign.promote_settings.start_date_value));
        console.log(this.startDateFormat)
        this.changeUsersCount();

        // Add excluded urls (when it's not exist)
        if (this.campaign.targeting.excludedPages === undefined) {
            this.campaign.targeting.excludedPages = {
                specific: false,
                homepage: false,
                list: []
            };
        }
        if (this.campaign.targeting.authors === undefined) {
            this.campaign.targeting.authors = {
                specific: false,
                list: []
            };
        }
        if (this.campaign.targeting.categories === undefined) {
            this.campaign.targeting.categories = {
                specific: false,
                list: []
            };
        }
        if (this.campaign.targeting.howOftenDisplay === undefined) {
            this.campaign.targeting.howOftenDisplay = {
                pageView: {
                    active: true
                },
                session: {
                    active: false
                },
                nthPageView: {
                    active: false,
                    nthPage: 5
                },
                pageViewWithPause: {
                    active: false,
                    count: 5,
                    pause: 2
                }
            };
        }

        if (this.campaign.targeting.popupFixed === undefined) {
            this.campaign.targeting.popupFixed = {
                showAgain: {
                    active: true
                },
                dontShowAgain: {
                    active: false
                },
                afterNthPage: {
                    active: false,
                    nthPage: 5
                }
            };
        }

        this.selectedAuthors = this.campaign.targeting.authors.list;
        console.log(this.selectedAuthors)

        this.getTargetingArticlesData();
        this.initHowOftenDisplay();
        this.initCloseFixedPopupWidget();

    }


    public campaignNameChange(event) {
        this.campaignNameLength = event.target.value.length;
    }

    public openTab(tabNumber: number) {
        if (this.isOpened(tabNumber)) {
            this.opened.splice(this.opened.indexOf(tabNumber), 1)
        } else {
            this.opened.push(tabNumber);
        }
    }

    public isOpened(tabNumber: number) {
        return this.opened.indexOf(tabNumber) > -1;
    }


    private createDateObject(formattedDate: Date) {
        const date = new Date(formattedDate);
        return {day: date.getUTCDate(), year: date.getUTCFullYear(), month: date.getUTCMonth() + 1};
    }

    //add or remove items in monthly_prices to match with value from monthly_prices
    updateNumberOfMonthlyPrices(event) {
        while (this.campaign.payment_settings.monthly_prices.count_of_options !== event && (!!event || event === 0)) {
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
        while (this.campaign.payment_settings.once_prices.count_of_options !== event && (!!event || event === 0)) {
            if (this.campaign.payment_settings.once_prices.count_of_options > event) {
                this.campaign.payment_settings.once_prices.count_of_options--;
                this.campaign.payment_settings.once_prices.options.pop();
            }
            if (this.campaign.payment_settings.once_prices.count_of_options < event) {
                this.campaign.payment_settings.once_prices.count_of_options++;
                this.campaign.payment_settings.once_prices.options.push(
                    {value: this.campaign.payment_settings.once_prices.count_of_options * 5}
                );
            }
        }
    }

    createActivePriceOptions(): DropdownItem[] {
        const result: DropdownItem[] = [];
        this.campaign.payment_settings.monthly_prices.options.forEach((option, i) => {
            result.push({
                title: 'Price No.' + (i + 1),
                value: option.value
            });
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
                    id: 0,
                    path: this.newUrl
                });
                this.newUrl = undefined;
            } else {
                this.newUrlInput.nativeElement.focus();
            }
        }
    }

    addExcludedUrl() {
        if (this.campaign.targeting.excludedPages.specific) {
            if (this.newExcludedUrl) {
                this.campaign.targeting.excludedPages.list.push({
                    id: 0,
                    path: this.newExcludedUrl
                });
                this.newExcludedUrl = undefined;
            } else {
                this.newExcludedUrlInput.nativeElement.focus();
            }
        }
    }


    changeUsersCount() {
        if (this.changeUsersCountSubscribtion !== undefined) {
            this.changeUsersCountSubscribtion.unsubscribe();
        }
        this.targetingUsersLoadingEmit.emit(true);
        this.changeUsersCountSubscribtion = this.campaignService.getUsersTargetingCount(this.campaign.targeting).subscribe((data) => {
            this.targetingUsersCountEmit.emit(data);
            this.targetingDataEmit.emit(this.campaign.targeting);
            this.campaignEmit.emit(this.campaign);
            this.targetingUsersLoadingEmit.emit(false);
        });
    }

    public changeStartDate(startDate) {
        console.log(startDate);
        this.campaign.promote_settings.start_date_value = startDate;
        this.startDate = moment(startDate);
        this.endDate = moment(startDate).add(1, 'days');
        console.log(this.campaign)
    }

    public changeEndDate(endDate) {
        this.endDate = endDate;
        this.campaign.promote_settings.end_date_value = endDate;
        console.log(this.campaign)
        this.campaignEmit.emit(this.campaign);
    }

    public changeTargetingRegistrationAfterDate(dateFrom) {
        this.campaign.targeting.registration.after.date = dateFrom;
        this.changeUsersCount();
    }

    public changeTargetingRegistrationBeforeDate(dateTo) {
        this.campaign.targeting.registration.before.date = dateTo;
        this.changeUsersCount();
    }

    private getTargetingArticlesData() {
        this.campaignService.getTargetingArticlesData().subscribe((data) => {
            data.authors.map((author, key) => {
                this.authors.push(author);
            });
            data.categories.map((category, key) => {
                this.categories.push(category);
            });

        });
    }

    public changeHowOftenDisplay(event) {
        let pageView = false;
        let session = false;
        let nthPageView = false;
        let pageViewWithPause = false;

        switch (event) {
            case 'page_view':
                pageView = true;
                break;
            case 'session':
                session = true;
                break;
            case 'nth_page_view':
                nthPageView = true;
                break;
            case 'page_view_pause':
                pageViewWithPause = true;
                break;
        }
        this.campaign.targeting.howOftenDisplay.pageView.active = pageView;
        this.campaign.targeting.howOftenDisplay.session.active = session;
        this.campaign.targeting.howOftenDisplay.nthPageView.active = nthPageView;
        this.campaign.targeting.howOftenDisplay.pageViewWithPause.active = pageViewWithPause;
    }

    public changeValueCloseFixedPopup(event) {
        let showAgain = false;
        let dontShowAgain = false;
        let showAfterNthPage = false;
        switch (event) {
            case 'show':
                showAgain = true;
                break;
            case 'dont_show':
                dontShowAgain = true;
                break;
            case 'show_after_views':
                showAfterNthPage = true;
                break;
        }
        this.campaign.targeting.popupFixed.showAgain.active = showAgain;
        this.campaign.targeting.popupFixed.dontShowAgain.active = dontShowAgain;
        this.campaign.targeting.popupFixed.afterNthPage.active = showAfterNthPage;
    }

    private initHowOftenDisplay() {
        const targeting = this.campaign.targeting;
        if (targeting.howOftenDisplay.pageView.active) {
            this.currentValueOftenDisplay = 'page_view';
        } else if (targeting.howOftenDisplay.session.active) {
            this.currentValueOftenDisplay = 'session';
        } else if (targeting.howOftenDisplay.nthPageView.active) {
            this.currentValueOftenDisplay = 'nth_page_view';
        } else {
            this.currentValueOftenDisplay = 'page_view_pause';
        }
    }

    private initCloseFixedPopupWidget() {
        const targeting = this.campaign.targeting;
        if (targeting.popupFixed.showAgain.active) {
            this.currentValueCloseFixedPopup = 'show';
        } else if (targeting.popupFixed.dontShowAgain.active) {
            this.currentValueCloseFixedPopup = 'dont_show';
        } else {
            this.currentValueCloseFixedPopup = 'show_after_views';
        }
    }

    public selectAuthorAction() {
        const children = this.authorsListRef.mainElRef.nativeElement.children[1].children;
        this.campaign.targeting.authors.list = [];
        for (const ch of children) {
            const currentAuthor = ch.innerText;
            this.campaign.targeting.authors.list.push(currentAuthor);
        }
    }

    public removeAuthorAction(e) {
        for (let i = 0; i < this.campaign.targeting.authors.list.length; i++) {
            if (this.campaign.targeting.authors.list[i] === e) {
                this.campaign.targeting.authors.list.splice(i, 1);
            }
        }
    }

    public selectCategoryAction() {
        const children = this.categoriesListRef.mainElRef.nativeElement.children[1].children;
        this.campaign.targeting.categories.list = [];
        for (const ch of children) {
            const currentAuthor = ch.innerText;
            this.campaign.targeting.categories.list.push(currentAuthor);
        }
    }

    public removeCategoryAction(e) {
        for (let i = 0; i < this.campaign.targeting.categories.list.length; i++) {
            if (this.campaign.targeting.categories.list[i] === e) {
                this.campaign.targeting.categories.list.splice(i, 1);
            }
        }
    }
}
