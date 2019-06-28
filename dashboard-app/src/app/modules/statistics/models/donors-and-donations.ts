// used to show data in table in overall.component
export class DonorsAndDonations {
    current: [DonorsAndDonationsValue];
    previous: [DonorsAndDonationsValue];

}

export class DonorsAndDonationsValue {
    donations_sum;
    donations_avg;
    donors_count;
    is_monthly_donation: boolean;
}
