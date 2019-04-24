export class Targeting {
    signed = {
        active: true
    }

    not_signed = {
        active: false
    }
    one_time = {
        active: true,
        older_than: {
            active: true,
            value: 30
        },
        not_older_than: {
            active: false,
            value: 60
        }
    }
    monthly = {
        active: false,
        bigger_than: {
            active: false,
            value: 5
        },
        less_than: {
            active: false,
            value: 15
        }
    }
    not_donator = {
        active: false
    }
    read_arcticles = {
        today: {
            active: false,
            min: 0,
            max: 5
        },
        week: {
            active: false,
            min: 10,
            max: 25
        },
        month: {
            active: true,
            min: 20,
            max: 0
        }
    }
    registration = {
        before: {
            active: false,
            date: new Date()
        },
        after: {
            active: false,
            date: new Date()
        }
    }
    url = {
        specific: false,
        list: ['https://www.postoj.sk', 'https://www.postoj.sk/politika']
    }
}