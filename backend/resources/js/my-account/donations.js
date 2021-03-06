import {getRequest, setTokenHeader, getDateFormat, getPaymentMethod, getPaymentPeriod} from "../helpers";
import {apiUrl} from "../constants/url";

export function donationsInit() {
    getSupportData();
}

function getPaymentOptions() {
    const data = getRequest(apiUrl + 'payment-options', setTokenHeader([]));
    return data;
}

function getIban(paymentMethodId) {
    let iban = '';
    getPaymentOptions().map((option, key) => {
        if (option.id === paymentMethodId) {
            const settings = JSON.parse(option.payment_option.payment_settings);
            iban = settings.oneTimePayment.accountNumber;
        }
    });
    return iban;
}

function getSupportData() {
    const data = getRequest(apiUrl + 'your-support', setTokenHeader([]));
    if (data != null) {
        if (data.donations.length > 0) {
            const yourDonationElem = document.getElementById('cft--yourDonation');
            const variableSymbol = document.getElementById('cft--variableSymbol');
            const portalBankAccount = document.getElementById('cft--portalBankAccount');
            const donatingFrom = document.getElementById('cft--donatingFrom');
            const table = document.querySelector('.cft--donationsTable table tbody');
            const warning = document.querySelector('.cft--accountBox--content--waiting');
            variableSymbol.innerText = data.variable_symbol.variable_symbol;
            const amount = (data.donations[0].amount === null) ? data.donations[0].amount_initialized : data.donations[0].amount;
            yourDonationElem.innerText = amount + ' €';
            portalBankAccount.innerText = getIban(data.donations[0].payment_method);
            if (data.donations[0].payment_id === null) {
                warning.style.display = 'block';
            }

            let firstDate = '';
            data.donations.map((donation, key) => {
                let statusClass = 'waiting';
                let status = 'WAITING';
                if (donation.payment_id !== null) {
                    firstDate = getDateFormat(donation.created_at);
                    statusClass = 'ok';
                    status = 'PROCESSED';
                }
                const newElement = document.createElement('tr');
                const amount = (donation.amount === null) ? donation.amount_initialized : donation.amount;
                newElement.innerHTML = '<td>' + (key + 1) + '.</td>' +
                    '<td>' + getDateFormat(donation.created_at) + '</td>' +
                    '<td>' + amount + ' €</td>' +
                    '<td>' + getPaymentMethod(donation.payment_method) + '</td>' +
                    '<td>' + getPaymentPeriod(donation.is_monthly_donation) + '</td>' +
                    '<td class="' + statusClass + '">' + status + '</td>';
                table.appendChild(newElement);
            });

            donatingFrom.innerText = firstDate;


            document.querySelectorAll('.cft--accountBox--supporter').forEach((el, key) => {
                el.style.display = 'block';
            });
            document.querySelectorAll('.cft--is-supported').forEach((el, key) => {
                el.style.display = 'block';
            });
        } else {
            document.querySelectorAll('.cft--accountBox--notSupporter').forEach((el, key) => {
                el.style.display = 'block';
            });
            document.querySelectorAll('.cft--not-supported').forEach((el, key) => {
                el.style.display = 'block';
            });
        }
    }
}