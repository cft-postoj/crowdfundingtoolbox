import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Targeting} from '../../models';

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
        this.targetingText = 'You currently target this campaign on';

        targetingSubtext += (this.targeting.signed_status.signed.active) ? ' <b>signed users</b>' : '';
        targetingSubtext += (this.targeting.signed_status.not_signed.active) ?
            ((targetingSubtext !== '') ? ' and <b>not signed users<b/>' : '<b>not signed users</b>.') :
            ((targetingSubtext !== '') ? '.' : '');

        // One-time supporter
        const oneTimeSupport = this.targeting.support.one_time;
        const monthlySupporter = this.targeting.support.monthly;
        if (oneTimeSupport.active) {
            targetingSubtext += '<u>Targeting on <b>One-time supporter</b></u><ul>';
            targetingSubtext += (oneTimeSupport.older_than.active && oneTimeSupport.not_older_than.active) ?
                '<li>last payment is older than <b>' + oneTimeSupport.older_than.value
                + '</b> days and not older than <b>' + oneTimeSupport.not_older_than.value + ' days</b>.</li>'
                : ((oneTimeSupport.older_than.active && !oneTimeSupport.not_older_than.active)
                    ? '<li>last payment is older than <b>' + oneTimeSupport.older_than.value + ' days</b>.</li>' :
                    ((!oneTimeSupport.older_than.active && oneTimeSupport.not_older_than.active)
                        ? '<li>last payment from one-time supporter is not older than <b>'
                        + oneTimeSupport.not_older_than.value + ' days</b>.</li>' : ''));

            targetingSubtext += (oneTimeSupport.min.active && oneTimeSupport.max.active) ?
                '<li>donation is bigger than <b>' + oneTimeSupport.min.value + ' €</b> and less than <b>'
                + oneTimeSupport.max.value + ' €</b>.</li>'
                : ((oneTimeSupport.min.active && !oneTimeSupport.max.active)
                    ? '<li>donation is bigger than <b>' + oneTimeSupport.min.value + ' €</b>.</li>'
                    : ((!oneTimeSupport.min.active && oneTimeSupport.max.active) ? '<li>donation is less than <b>'
                        + oneTimeSupport.max.value + ' €</b>.</li>' : ''));

            targetingSubtext += '</ul>';
        }

        if (monthlySupporter.active) {
            targetingSubtext += '<u>Targeting on <b>Monthly supporter</b></u><ul>';

            targetingSubtext += (monthlySupporter.older_than.active && monthlySupporter.not_older_than.active) ?
                '<li>last payment is older than <b>' + monthlySupporter.older_than.value
                + '</b> days and not older than <b>' + monthlySupporter.not_older_than.value + ' days</b>.</li>'
                : ((monthlySupporter.older_than.active && !monthlySupporter.not_older_than.active)
                    ? '<li>last payment is older than <b>' + monthlySupporter.older_than.value + ' days</b>.</li>' :
                    ((!monthlySupporter.older_than.active && monthlySupporter.not_older_than.active)
                        ? '<li>last payment from one-time supporter is not older than <b>'
                        + monthlySupporter.not_older_than.value + ' days</b>.</li>' : ''));

            targetingSubtext += (monthlySupporter.min.active && monthlySupporter.max.active) ?
                '<li>donation is bigger than <b>' + monthlySupporter.min.value + ' €</b> and less than <b>'
                + monthlySupporter.max.value + ' €</b>.</li>'
                : ((monthlySupporter.min.active && !monthlySupporter.max.active)
                    ? '<li>donation is bigger than <b>' + monthlySupporter.min.value + ' €</b>.</li>'
                    : ((!monthlySupporter.min.active && monthlySupporter.max.active) ? '<li>donation is less than <b>'
                        + monthlySupporter.max.value + ' €</b>.</li>' : ''));

            targetingSubtext += '</ul>';
        }

        // Not supporter
        if (this.targeting.support.not_supporter.active) {
            targetingSubtext += '<u>Targeting on <b>not supporters</b></u>';
        }

        // Read articles
        const readArticles = this.targeting.read_articles;
        if (readArticles.today.active || readArticles.week.active || readArticles.month.active) {
            targetingSubtext += '<u>Targeting on <b>count of read articles</b></u><ul>';
            if (readArticles.today.active) {
                targetingSubtext += '<li><b>today</b></li><ul>';
                targetingSubtext += '<li>min: ' + readArticles.today.min + '</li>';
                targetingSubtext += '<li>max: ' + readArticles.today.max + '</li></ul>';
            }

            if (readArticles.week.active) {
                targetingSubtext += '<li><b>week</b></li><ul>';
                targetingSubtext += '<li>min: ' + readArticles.week.min + '</li>';
                targetingSubtext += '<li>max: ' + readArticles.week.max + '</li></ul>';
            }

            if (readArticles.month.active) {
                targetingSubtext += '<li><b>month</b></li><ul>';
                targetingSubtext += '<li>min: ' + readArticles.month.min + '</li>';
                targetingSubtext += '<li>max: ' + readArticles.month.max + '</li></ul>';
            }

            targetingSubtext += '</ul>';
        }

        // User registration before/after
        const userRegistration = this.targeting.registration;
        if (userRegistration.before.active || userRegistration.after.active) {
            targetingSubtext += '<u>Targeting on <b>user registration date</b></u><ul>';
            if (userRegistration.before.active) {
                const beforeDate = userRegistration.before.date.day + '.' + userRegistration.before.date.month + '.' +
                    userRegistration.before.date.year;
                targetingSubtext += '<li>registration before <b>' + beforeDate + '</b></li>';
            }
            if (userRegistration.after.active) {
                const afterDate = userRegistration.after.date.day + '.' + userRegistration.after.date.month + '.' +
                    userRegistration.after.date.year;
                targetingSubtext += '<li>registration before <b>' + afterDate + '</b></li>';
            }
            targetingSubtext += '</ul>';
        }

        // URLs targeting
        const urlTargeting = this.targeting.url;
        if (urlTargeting.specific === true) {
            targetingSubtext += '<u>Targeting on <b>specific urls</b></u><ul>';
            urlTargeting.list.map((url) => {
               targetingSubtext += '<li>' + url.path + '</li>';
            });
            targetingSubtext += '</ul>';
        }


        if (targetingSubtext === '') {
            this.targetingText = 'Currently you don\'t have enable any targeting option.';
        } else {
            this.targetingText += targetingSubtext;
        }

    }

}
