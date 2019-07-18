import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Targeting} from '../../models';
import targetingModalStrings from '../../../../translations/en/campaing-tracking-modal.json';

@Component({
    selector: 'app-target-modal',
    templateUrl: './target-modal.component.html',
    styleUrls: ['./target-modal.component.scss', '../../../../../sass/classes.scss']
})
export class TargetModalComponent implements OnInit, OnChanges {
    @Input()
    public loading: boolean;

    @Input()
    public usersCount: number;

    @Input()
    public visitorsCount: number;

    @Input()
    public targeting: Targeting;

    @Output()
    public signedUsersListEmit = new EventEmitter();

    public targetingText: string = '';

    constructor() {
    }

    ngOnInit() {
        this.usersCount = 0;
        this.loading = true;
    }

    ngOnChanges() {
        this.targetingOnText();
    }

    showSignedUsersList() {
        this.signedUsersListEmit.emit(true);
    }

    private targetingOnText() {
        let targetingSubtext = '';
        this.targetingText = targetingModalStrings.currentlyTargetingCampaign;
        if (this.targeting !== undefined) {
            targetingSubtext += (this.targeting.signed_status.signed.active) ? ' <b>' + targetingModalStrings.signedUsers + '</b>' : '';
            targetingSubtext += (this.targeting.signed_status.not_signed.active) ?
                ((targetingSubtext !== '') ? targetingModalStrings.and + ' <b>'
                    + targetingModalStrings.notSignedUsers + '<b/>' : '<b>' + targetingModalStrings.notSignedUsers + '</b>.') :
                ((targetingSubtext !== '') ? '.' : '');


            // One-time supporter
            const oneTimeSupport = this.targeting.support.one_time;
            const monthlySupport = this.targeting.support.monthly;
            if (oneTimeSupport.active) {
                targetingSubtext += '<u>' + targetingModalStrings.targetingOnOneTimeTitle + '</u><ul>';
                targetingSubtext += (oneTimeSupport.older_than.active && oneTimeSupport.not_older_than.active) ?
                    '<li>' + targetingModalStrings.paymentOlderThanAndNotOlderThan.replace('%1', oneTimeSupport.older_than.value.toString())
                        .replace('%2', oneTimeSupport.not_older_than.value.toString()) + '</li>'
                    : ((oneTimeSupport.older_than.active && !oneTimeSupport.not_older_than.active)
                        ? '<li>' + targetingModalStrings.paymentOlderThan.replace('%1', oneTimeSupport.older_than.value.toString()) + '</li>' :
                        ((!oneTimeSupport.older_than.active && oneTimeSupport.not_older_than.active)
                            ? '<li>' + targetingModalStrings.paymentOlderThan
                            .replace('%1', oneTimeSupport.not_older_than.value.toString()) + '</li>' : ''));

                targetingSubtext += (oneTimeSupport.min.active && oneTimeSupport.max.active) ?
                    '<li>' + targetingModalStrings.donationIsBiggerThanAndLessThan.replace('%1', oneTimeSupport.min.value.toString())
                        .replace('%2', oneTimeSupport.max.value.toString()) + '</li>'
                    : ((oneTimeSupport.min.active && !oneTimeSupport.max.active)
                        ? '<li>' + targetingModalStrings.donationIsBiggerThan.replace('%1', oneTimeSupport.min.value.toString()) + '</li>'
                        : ((!oneTimeSupport.min.active && oneTimeSupport.max.active)
                            ? '<li>' + targetingModalStrings.donationIsBiggerThan
                            .replace('%1', oneTimeSupport.min.value.toString()) + '</li>' : ''));

                targetingSubtext += '</ul>';
            }

            if (monthlySupport.active) {
                targetingSubtext += '<u>' + targetingModalStrings.targetingOnMonthlyTitle + '</u><ul>';

                targetingSubtext += (monthlySupport.older_than.active && monthlySupport.not_older_than.active) ?
                    '<li>' + targetingModalStrings.paymentOlderThanAndNotOlderThan.replace('%1', monthlySupport.older_than.value.toString())
                        .replace('%2', monthlySupport.not_older_than.value.toString()) + '</li>'
                    : ((monthlySupport.older_than.active && !monthlySupport.not_older_than.active)
                        ? '<li>' + targetingModalStrings.paymentOlderThan.replace('%1', monthlySupport.older_than.value.toString()) + '</li>' :
                        ((!monthlySupport.older_than.active && monthlySupport.not_older_than.active)
                            ? '<li>' + targetingModalStrings.paymentOlderThan
                            .replace('%1', monthlySupport.not_older_than.value.toString()) + '</li>' : ''));

                targetingSubtext += (monthlySupport.min.active && monthlySupport.max.active) ?
                    '<li>' + targetingModalStrings.donationIsBiggerThanAndLessThan.replace('%1', monthlySupport.min.value.toString())
                        .replace('%2', monthlySupport.max.value.toString()) + '</li>'
                    : ((monthlySupport.min.active && !monthlySupport.max.active)
                        ? '<li>' + targetingModalStrings.donationIsBiggerThan.replace('%1', monthlySupport.min.value.toString()) + '</li>'
                        : ((!monthlySupport.min.active && monthlySupport.max.active)
                            ? '<li>' + targetingModalStrings.donationIsBiggerThan
                            .replace('%1', monthlySupport.min.value.toString()) + '</li>' : ''));

                targetingSubtext += '</ul>';
            }

            // Not supporter
            if (this.targeting.support.not_supporter.active) {
                targetingSubtext += '<u>' + targetingModalStrings.targetingNotSupporter + '</u>';
            }

            // Read articles
            const readArticles = this.targeting.read_articles;
            if (readArticles.today.active || readArticles.week.active || readArticles.month.active) {
                targetingSubtext += '<u>' + targetingModalStrings.targetingReadArticlesTitle + '</u><ul>';
                if (readArticles.today.active) {
                    targetingSubtext += '<li><b>' + targetingModalStrings.today + '</b></li><ul>';
                    targetingSubtext += '<li>' + targetingModalStrings.min + readArticles.today.min + '</li>';
                    targetingSubtext += '<li>' + targetingModalStrings.max + readArticles.today.max + '</li></ul>';
                }

                if (readArticles.week.active) {
                    targetingSubtext += '<li><b>' + targetingModalStrings.week + '</b></li><ul>';
                    targetingSubtext += '<li>' + targetingModalStrings.min + readArticles.week.min + '</li>';
                    targetingSubtext += '<li>' + targetingModalStrings.max + readArticles.week.max + '</li></ul>';
                }

                if (readArticles.month.active) {
                    targetingSubtext += '<li><b>' + targetingModalStrings.month + '</b></li><ul>';
                    targetingSubtext += '<li>' + targetingModalStrings.min + readArticles.month.min + '</li>';
                    targetingSubtext += '<li>' + targetingModalStrings.max + readArticles.month.max + '</li></ul>';
                }

                targetingSubtext += '</ul>';
            }

            // User registration before/after
            const userRegistration = this.targeting.registration;
            if (userRegistration.before.active || userRegistration.after.active) {
                targetingSubtext += '<u>' + targetingModalStrings.targetingRegistrationDateTitle + '</u><ul>';
                if (userRegistration.before.active) {
                    const beforeDate = userRegistration.before.date.day + '.' + userRegistration.before.date.month + '.' +
                        userRegistration.before.date.year;
                    targetingSubtext += '<li>' + targetingModalStrings.registrationBefore + ' <b>' + beforeDate + '</b></li>';
                }
                if (userRegistration.after.active) {
                    const afterDate = userRegistration.after.date.day + '.' + userRegistration.after.date.month + '.' +
                        userRegistration.after.date.year;
                    targetingSubtext += '<li>' + targetingModalStrings.registrationAfter + ' <b>' + afterDate + '</b></li>';
                }
                targetingSubtext += '</ul>';
            }

            // URLs targeting
            const urlTargeting = this.targeting.url;
            if (urlTargeting.specific === true) {
                targetingSubtext += '<u>' + targetingModalStrings.targetingSpecifiUrlsTitle + '</u><ul>';
                urlTargeting.list.map((url) => {
                    targetingSubtext += '<li>' + url.path + '</li>';
                });
                targetingSubtext += '</ul>';
            }
        }

        if (targetingSubtext === '') {
            this.targetingText = targetingModalStrings.noTrackingEnable;
        } else {
            this.targetingText += targetingSubtext;
        }

    }

}
