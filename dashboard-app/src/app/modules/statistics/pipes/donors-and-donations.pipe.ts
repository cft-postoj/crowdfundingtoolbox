import {Pipe, PipeTransform} from '@angular/core';
import {DonorsAndDonations, DonorsAndDonationsValue} from '../models/donors-and-donations';

@Pipe({
    name: 'donorsAndDonationsPipe'
})
export class DonorsAndDonationsPipe implements PipeTransform {

    // field => actual or historic, based on model DonorsAndDonations
    // key => donations_sum or donors_count based on model DonorsAndDonations.DonorsAndDonationsValue
    // monthly => true to get only monthly donation, false to get only one time donations and undefined to get both
    transform(input: DonorsAndDonations, field: 'current' | 'previous' | 'diff', key: 'donations_sum' | 'donors_count' | 'donations_avg',
              monthly?: boolean): number | 'loading' {
        if (input === undefined) {
            return 'loading';
        }
        // handle diff between current month and
        if (field === 'diff') {
            return this.transform(input, 'current', key, monthly) -
                this.transform(input, 'previous', key, monthly);
        }
        const arrayOfDonorsAndDonationsValue: [DonorsAndDonationsValue] = input[field];
        let result = 0;
        if (arrayOfDonorsAndDonationsValue) {
            arrayOfDonorsAndDonationsValue.forEach(
                item => {
                    if (monthly === undefined || monthly === item.is_monthly_donation) {
                        result += +item[key];
                    }
                });
        }
        return result;
    }

}
