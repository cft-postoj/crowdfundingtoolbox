export class Payment {
    id: number;
    transaction_id: string;
    iban: string;
    variable_symbol: number;
    amount: number;
    created_by: string;
    transaction_date: string;
    transfer_type: number;
    status: string;
    payment_notes: string;
}
