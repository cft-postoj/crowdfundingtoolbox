// used to show data in table in overall.component
export class DonorsAndDonations {
    current: { monthly: DonorsAndDonationsValue, one_time: DonorsAndDonationsValue, total: DonorsAndDonationsValue };
    previous: { monthly: DonorsAndDonationsValue, one_time: DonorsAndDonationsValue, total: DonorsAndDonationsValue };
}

export class DonorsAndDonationsValue {
    amount_sum: number;
    amount_avg: number;
    donors_count: number;
    donors_new: number;
    is_monthly_donation: boolean;
}
